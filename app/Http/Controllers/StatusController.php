<?php

namespace App\Http\Controllers;

use App\PannelSettings;
use Illuminate\Http\Request;

use App\Http\Requests;

class StatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changeStatus($statusName){
        $settings = PannelSettings::whereId(1)->first();
        if($settings == null){
            abort(404);
        }
        $settings->status = $statusName;
        $settings->save();

        return redirect('/');
    }

    public function changeBlack($status){
        $settings = PannelSettings::whereId(1)->first();
        if($settings == null){
            abort(404);
        }
        $settings->checkBlackList = $status;
        $settings->save();

        return redirect('/');
    }
}
