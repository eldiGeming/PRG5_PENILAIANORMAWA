<?php

namespace App\Http\Controllers\pengurus;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class pengurusController extends Controller
{
    public function index() {
        return view('pengurus/dashboard');
    }
}
