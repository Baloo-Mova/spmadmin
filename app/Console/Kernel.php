<?php

namespace App\Console;

use App\FindSmtpSettings;
use App\MailSettings;
use App\PannelSettings;
use App\SettingsForCheckSMTP;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\smtplistpiece;
use App\smtpfindpiece;
use App\SmtpListForCheck;
use App\smtpfind;
use Illuminate\Support\Facades\Storage;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $schedule->call(function(){

            $smtpSetting = SettingsForCheckSMTP::find(1);
            $findSetting = FindSmtpSettings::find(1);
            $pannelSetting = PannelSettings::find(1);

            DB::table('bots')->whereRaw('bots.updated_at <  date_add(now(), Interval -10 MINUTE)')->update(['life'=>0, 'otk'=>1]);
            DB::table('bots')->whereRaw('bots.bandate <  date_add(now(), Interval -1 DAY)')->update(['ban'=>0]);

            DB::table('smtplistpiece')->whereRaw('time <> \'\' and time < date_add(now(), INTERVAL -'.empty($smtpSetting->timeout)? 600 : $smtpSetting->timeout.' SECOND)')->update(['time'=>'', 'botid'=>0, 'isget'=>0]);
            DB::table('smtpfindpiece')->whereRaw('time <> \'\' and time < date_add(now(), INTERVAL -'.empty($findSetting->timeout)? 600 : $findSetting->timeout.' SECOND)')->update(['time'=>'', 'botid'=>0, 'isget'=>0]);

            if ($pannelSetting->status == 'SMTPFIND') {
                $now = smtpfindpiece::whereRaw('`status` = \'\'')->count();
                if($now < $findSetting->pull_swap_size){
                    return;
                }
                $count = $findSetting->pull_size;
                smtpfindpiece::where([
                    ['status', '=', '']
                ])->update(['isget' => 0, 'time' => '', 'botid' => 0]);

                smtpfind::join('smtpfindpiece', 'smtpfindpiece.id', '=', 'smtpfind.id')->update([
                    'smtpfind.isget'  => 1,
                    'smtpfind.status' => DB::raw('smtpfindpiece.status')
                ]);
                DB::table('smtpfindpiece')->truncate();
                $count = ! empty($count) ? $count : "2000";
                DB::statement("INSERT INTO `smtpfindpiece`(id,`emailpas`, `status`) select id, `emailpas`, `status` from smtpfind where isget = 0 limit $count");
            }

            if ($pannelSetting->status == 'SMTPCHECK') {
                $now = smtplistpiece::where(['status'=>''])->count();

                if($now < $findSetting->countload){
                    return;
                }

                $count = $smtpSetting->countbase;
                smtplistpiece::where('status','=','')->update(['isget' => 0,'time'=>'','botid'=>0]);
                SmtpListForCheck::join('smtplistpiece','smtplistpiece.id' ,'=', 'smtplistforcheck.id')->update(['smtplistforcheck.isget'=>DB::raw('smtplistpiece.isget'),'smtplistforcheck.status'=>DB::raw('smtplistpiece.status'),'smtplistforcheck.errmsg'=>DB::raw('smtplistpiece.errmsg')]);
                DB::table('smtplistpiece')->truncate();
                $count = !empty($count) ? $count : "2000";
                DB::statement("INSERT INTO `smtplistpiece`(id,`smtp`, `status`) select id, `smtp`, `status` from smtplistforcheck where isget = 0 limit $count");
            }


        })->cron("* * * * * *");
    }
}
