<?php

namespace App\Http\Controllers;

use App\Models\TimeActivite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_id = Auth::user()->id;
        $total_time = TimeActivite::where('user_id', $user_id)->sum('temps_connecte');
        return view('home');
    }
}
