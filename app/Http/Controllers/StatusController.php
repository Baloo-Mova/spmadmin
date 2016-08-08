<?php

namespace App\Http\Controllers;

use App\Bots;
use App\PannelSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use narutimateum\Toastr\Facades\Toastr;

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

        if($statusName == "BANALL"){
            Bots::where('id', '>', 0)->update(['ban'=>1, 'bandate' => Carbon::now('Europe/Kiev')]);

            Toastr::success('All bots are banned');
        }

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
