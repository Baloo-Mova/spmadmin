<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function smtpSettings(){


        return view('settings.smtp.index',compact(''));
    }

    public function emailSettings(){

    }

    public function smtpSettingsStore(){

    }

    public function emailSettingsStore(){

    }

}
