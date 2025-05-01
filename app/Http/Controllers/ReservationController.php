<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ReservationController extends Controller
{
    public function index()
    {
        $response = Http::withToken('Bearer ' . session('api_token'))
            ->post(env('API_URL') . '/customer_lessons', [

            ]);
        $response = json_decode($response->body());
        //dd($response);
        if ($response?->type == 'false')
            return redirect()->back()->with('error', $response->message);

        $reservations = $response?->lessons;
        return view('Kpanel.reservation.index', compact('reservations'));
    }

    public function create()
    {
        $personels = [];
        $times = [];
        if (isset($_GET['date']) && isset($_GET['type']) && isset($_GET['personel_id'])) {
            $response = Http::withToken('Bearer ' . session('api_token'))
                ->post(env('API_URL') . '/privatelesson_suitability', [
                    'date' => $_GET['date'],
                    'personel_id' => $_GET['personel_id'],
                ]);
            $response = json_decode($response->body());
            if ($response->type == 'false')
                return redirect()->back()->with('error', $response->message);

            $times = $response->times;
        } elseif (isset($_GET['date']) && isset($_GET['type'])) {
            $response = Http::withToken('Bearer ' . session('api_token'))
                ->post(env('API_URL') . '/get_personels', [
                ]);
            $response = json_decode($response->body());

            if ($response?->type == 'false')
                return redirect()->back()->with('error', $response->message);
            $personels = $response->getPersonels;
        }
        return view('Kpanel.reservation.create', [
            'personels' => $personels,
            'times' => $times,
        ]);
    }

    public function store(Request $request)
    {
        if ($request->type == 'private_lesson')
            $endPoint = '/private_lesson_appointment';
        elseif ($request->type == 'group_lesson')
            $endPoint = '/group_lesson_appointment';
        else
            $endPoint = '/measurement_appointment';

        list($startDate, $finishDate) = explode('_', $request->start_finish_time);
        $response = Http::withToken('Bearer ' . session('api_token'))
            ->post(env('API_URL') . $endPoint, [
                'date' => $request->date,
                'personel_id' => $request->personel_id,
                'start_time' => $startDate,
                'finish_time' => $finishDate,
            ]);
        $response = json_decode($response->body());
        if ($response->type == 'false')
            return redirect()->back()->with('error', $response->message);

        return redirect()->back()->with('success', 'Randevunuz Oluşturuldu!');
    }

    public function destroy(Request $request)
    {
        $response = Http::withToken('Bearer ' . session('api_token'))
            ->post(env('API_URL') . '/cancelled_lesson_appointment', [
                'lesson_id' => $request->lesson_id,
            ]);
        $response = json_decode($response->body());

        if ($response->type == 'false') {
            return redirect()->back()->with('error', $response->message);
        }

        return redirect()->back()->with('success', $response->message);
    }

    public function vote(Request $request)
    {
        $response = Http::withToken('Bearer ' . session('api_token'))
            ->post(env('API_URL') . '/lesson_point', [
                'lesson_id' => $request->reservation_id,
                'general_rate' => $request->vote,
            ]);
        $response = json_decode($response->body());

        if ($response->type == 'false') {
            return redirect()->back()->with('error', $response->message);
        }

        return redirect()->back()->with('success', "Oylama Başarılı");
    }
}
