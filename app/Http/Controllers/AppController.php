<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function gouvernance()
    {
        return view('gouvernance');
    }
    
    public function economie()
    {
        return view('economie');
    }

    public function social()
    {
        return view('social');
    }

    public function sport_culture()
    {
        return view('sport-culture');
    }

    public function jeunes_femmes()
    {
        return view('jeunes-femmes');
    }

    public function equipe()
    {
        return view('equipe');
    }
}
