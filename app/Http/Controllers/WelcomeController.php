<?php

namespace App\Http\Controllers;
use App\Models\Canteen;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index() {
        $canteens = Canteen::all();
        return view('welcome', compact('canteens'));
    }
}