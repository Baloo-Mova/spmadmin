<?php

namespace App\Http\Controllers;

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

        $count = SettingsForCheckSMTP::whereId(1)->first()->countbase;

        smtplistpiece::where('status','<>','')->update(['isget' => 0,'time'=>'','botid'=>0]);
        $update = smtplistpiece::where('status','<>','')->get();
        foreach ($update as $item){
           $smtp = SmtpListForCheck::find($item->id);
            $smtp->status = $item->status;
            $smtp->isget = 1;
            $smtp->errmsg = $item->errmsg;
            $smtp->save();
        }
        DB::table('smtplistpiece')->delete();
         $count = !empty($count) ? $count : "2000";
        DB::statement("INSERT INTO `smtplistpiece`(id,`smtp`) select id, `smtp` from smtplistforcheck where isget = 0 ORDER BY RAND() limit $count");

        $val =$request->get('redirect');
        if(isset($val)){
            return redirect('/');
        }

    }

    public function email(Request $request){

        $count = SettingsForCheckSMTP::whereId(1)->first()->countbase;

        smtpfindpiece::where([
            ['status', '=', 'NULL'],
            ['status', '=', '']
        ])->update(['isget' => 0,'time'=>'','botid'=>0]);

        $update = smtpfindpiece::where([
            ['status', '<>', 'NULL'],
            ['status', '<>', '']
        ])->get();

        foreach ($update as $item){
            $smtp = smtpfind::find($item->id);
            $smtp->status = $item->status;
            $smtp->isget = 1;
            $smtp->save();
        }

        DB::table('smtpfindpiece')->delete();
        $count = !empty($count) ? $count : "2000";

        DB::statement("INSERT INTO `smtpfindpiece`(id,`emailpas`) select id, `emailpas` from smtpfind where isget = 0 ORDER BY RAND() limit $count");

        $val =$request->get('redirect');
        if(isset($val)){
            return redirect('/');
        }

    }


}
