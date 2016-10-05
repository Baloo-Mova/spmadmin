<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\smtpfind
 *
 * @property integer $id
 * @property integer $isget
 * @property string $time
 * @property integer $botid
 * @property string $emailpas
 * @property string $status
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfind whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfind whereIsget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfind whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfind whereBotid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfind whereEmailpas($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfind whereStatus($value)
 * @mixin \Eloquent
 */
class smtpfind extends Model
{
    protected  $table = "smtpfind";
    public $timestamps = false;
}
