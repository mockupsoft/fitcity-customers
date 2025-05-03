<?php

namespace App\Http\Controllers;

use App\Models\UserAdmin;
use Illuminate\Http\Request;

class TrainersConstoller extends Controller
{
    public function index()
    {
        $data = UserAdmin::where('permission_role', 3)->get();
        return view('Kpanel.trainers.index', compact('data'));
    }

    public function show($id)
    {
        $data = UserAdmin::findOrFail($id);
        return view('Kpanel.trainers.show', compact('data'));
    }

}