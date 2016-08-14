<?php

namespace App\Http\Controllers;

use App\FindSmtpSettings;
use App\smtpfind;
use App\smtpfindpiece;
use App\SmtpListForCheck;
use App\SettingsForCheckSMTP;
use App\smtplistpiece;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;

class PullController extends Controller
{
    public function smtp(Request $request){

        $count = SettingsForCheckSMTP::find(1)->countbase;

        smtplistpiece::where('status','=','')->update(['isget' => 0,'time'=>'','botid'=>0]);
        SmtpListForCheck::join('smtplistpiece','smtplistpiece.id' ,'=', 'smtplistforcheck.id')->update(['smtplistforcheck.isget'=>DB::raw('smtplistpiece.isget'),'smtplistforcheck.status'=>DB::raw('smtplistpiece.status'),'smtplistforcheck.errmsg'=>DB::raw('smtplistpiece.errmsg')]);
        DB::table('smtplistpiece')->truncate();
         $count = !empty($count) ? $count : "2000";
        DB::statement("INSERT INTO `smtplistpiece`(id,`smtp`) select id, `smtp` from smtplistforcheck where isget = 0 limit $count");

        $val =$request->get('redirect');
        if(isset($val)){
            return redirect('/');
        }

    }

    public function email(Request $request){
        $count = FindSmtpSettings::find(1)->pull_size;

        smtpfindpiece::where([
            ['status', '=', '']
        ])->update(['isget' => 0,'time'=>'','botid'=>0]);

        smtpfind::join('smtpfindpiece','smtpfindpiece.id' ,'=', 'smtpfind.id')->update(['smtpfind.isget'=>1
                                                                                        ,'smtpfind.status'=>DB::raw('smtpfindpiece.status')]);

        DB::table('smtpfindpiece')->truncate();

        $count = !empty($count) ? $count : "2000";
        DB::statement("INSERT INTO `smtpfindpiece`(id,`emailpas`) select id, `emailpas` from smtpfind where isget = 0 limit $count");

        $val =$request->get('redirect');
        if(isset($val)){
            return redirect('/');
        }

    }


}
