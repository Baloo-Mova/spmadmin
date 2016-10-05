<?php
/**
 * Created by PhpStorm.
 * User: mova_sa
 * Date: 05.10.2016
 * Time: 11:54
 */

namespace App\Helpers;


use App\MailSettings;
use App\SMTP;
use narutimateum\Toastr\Facades\Toastr;

class PrepareForPannelWork
{
    public static function spam()
    {
        $errors = [];

        $spamSettings = MailSettings::find(1);

       if($spamSettings->isContainsNull()){
           $errors[] = "В настройках из базы данных есть неопределенные значения.";
       }

       if(SMTP::count() < 1){
           $errors[] = "SMTP для спама отсутствуют в бд.";
       }

        if(count($errors) < 1) {
            Toastr::success('Включен режим SPAM.');
            return true;
        }else{

            $string = "Присутствуют следующие ошибки:<br/> <ul>";

            foreach ($errors as $error){
                $string.= "<li> $error</li>";
            }
            $string.="</ul>";

            Toastr::error($string,'Недостаточно настроек для корректной работы SPAM(3)',['timeOut'=>0]);
            return false;
        }
    }
}