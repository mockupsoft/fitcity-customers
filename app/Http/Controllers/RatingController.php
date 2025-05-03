<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function index()
    {
        return view('Kpanel.ratings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'cleanliness' => 'nullable|integer|min:1|max:5',
            'maintenance' => 'nullable|integer|min:1|max:5',
            'trainers' => 'nullable|integer|min:1|max:5',
            'friendliness' => 'nullable|integer|min:1|max:5',
            'service' => 'nullable|integer|min:1|max:5',
            'general' => 'nullable|integer|min:1|max:5',
        ]);

        Rating::updateOrCreate(
            ['customer_id' => auth()->id(), 'club_id' => $request->club_id],
            $request->only(['cleanliness', 'maintenance', 'trainers', 'friendliness', 'service', 'general'])
        );

        return back()->with('success', 'Puanlama kaydedildi.');
    }

}
