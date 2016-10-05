<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\smtplistpiece
 *
 * @property integer $id
 * @property string $smtp
 * @property integer $botid
 * @property integer $isget
 * @property string $time
 * @property string $status
 * @property string $errmsg
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereSmtp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereBotid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereIsget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtplistpiece whereErrmsg($value)
 * @mixin \Eloquent
 */
class smtplistpiece extends Model
{
    public $table='smtplistpiece';
    public $timestamps = false;

}
