<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SmtpListForCheck
 *
 * @property integer $id
 * @property string $smtp
 * @property integer $botid
 * @property integer $isget
 * @property string $time
 * @property string $status
 * @property string $errmsg
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereSmtp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereBotid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereIsget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SmtpListForCheck whereErrmsg($value)
 * @mixin \Eloquent
 */
class SmtpListForCheck extends Model
{
    protected $table = "smtplistforcheck";
    public $timestamps = false;


}
