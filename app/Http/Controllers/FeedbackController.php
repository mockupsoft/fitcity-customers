<?php

namespace App\Http\Controllers;

use App\Models\CustomerFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('Kpanel.feedback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = Http::withToken(session('api_token'))
            ->post(env('API_URL').'/feedbacks', [
                'type' => $request->type,
                'message' => $request->message,
            ]);

        $response = json_decode($response->body());
        if (!$response->type){
            return redirect()->back()->with('error', $response->message);
        }

        return back()->with('success', ' Mesajınız Gönderildi.');
    }
}
