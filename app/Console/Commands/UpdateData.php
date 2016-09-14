<?php

namespace App\Console\Commands;


use App\smtplistpiece;
use App\smtpfindpiece;
use App\SmtpListForCheck;
use App\smtpfind;
use App\FindSmtpSettings;
use App\PannelSettings;
use App\SettingsForCheckSMTP;
use Illuminate\Support\Facades\DB;

use Illuminate\Console\Command;

class UpdateData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'table:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update pools and bots';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $smtpSetting = SettingsForCheckSMTP::find(1);
        $findSetting = FindSmtpSettings::find(1);
        $pannelSetting = PannelSettings::find(1);

        DB::table('bots')->whereRaw('bots.updated_at <  date_add(now(), Interval -10 MINUTE)')->update(['life' => 0, 'otk' => 1]);
        DB::table('bots')->whereRaw('bots.bandate <  date_add(now(), Interval -1 DAY)')->update(['ban' => 0]);

        $time = empty($smtpSetting->timeout) ? 600 : $smtpSetting->timeout;
        DB::table('smtplistpiece')->whereRaw("time <> '' and time < date_add(now(), INTERVAL -$time SECOND)")->update(['time' => '', 'botid' => 0, 'isget' => 0]);
        $time = empty($findSetting->timeout) ? 600 : $findSetting->timeout;
        DB::table('smtpfindpiece')->whereRaw("time <> '' and time < date_add(now(), INTERVAL -$time SECOND)")->update(['time' => '', 'botid' => 0, 'isget' => 0]);

        if ($pannelSetting->status == 'SMTPFIND') {
            $now = smtpfindpiece::whereRaw("`status` = ''")->count();
            if ($now > $findSetting->pull_swap_size) {
                exit();
            }

            $count = $findSetting->pull_size;

            smtpfindpiece::where([
                ['status', '=', '']
            ])->update(['isget' => 0, 'time' => '', 'botid' => 0]);

            smtpfind::join('smtpfindpiece', 'smtpfindpiece.id', '=', 'smtpfind.id')->update([
                'smtpfind.isget' => 1,
                'smtpfind.status' => DB::raw('smtpfindpiece.status')
            ]);
            DB::table('smtpfindpiece')->delete();
            $count = !empty($count) ? $count : "2000";
            DB::statement("INSERT INTO `smtpfindpiece`(id,`emailpas`, `status`) select id, `emailpas`, `status` from smtpfind where isget = 0 limit $count");
        }

        if ($pannelSetting->status == 'SMTPCHECK') {
            $now = smtplistpiece::where(['status' => ''])->count();
            if ($now > $smtpSetting->countload) {
                exit();
            }

            $count = $smtpSetting->countbase;
            smtplistpiece::where('status', '=', '')->update(['isget' => 0, 'time' => '', 'botid' => 0]);
            SmtpListForCheck::join('smtplistpiece', 'smtplistpiece.id', '=', 'smtplistforcheck.id')->update(['smtplistforcheck.isget' => DB::raw('smtplistpiece.isget'), 'smtplistforcheck.status' => DB::raw('smtplistpiece.status'), 'smtplistforcheck.errmsg' => DB::raw('smtplistpiece.errmsg')]);
            DB::table('smtplistpiece')->delete();
            $count = !empty($count) ? $count : "2000";
            DB::statement("INSERT INTO `smtplistpiece`(id,`smtp`, `status`) select id, `smtp`, `status` from smtplistforcheck where isget = 0 limit $count");
        }
    }
}
