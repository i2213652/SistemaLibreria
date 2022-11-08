<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use Inertia\Inertia;


class HomeController extends Controller
{

    public function home()
    {
        return Inertia::render('home');
    }
}
