<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\smtpfindpiece
 *
 * @property integer $id
 * @property integer $isget
 * @property string $time
 * @property integer $botid
 * @property string $emailpas
 * @property string $status
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfindpiece whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfindpiece whereIsget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfindpiece whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfindpiece whereBotid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfindpiece whereEmailpas($value)
 * @method static \Illuminate\Database\Query\Builder|\App\smtpfindpiece whereStatus($value)
 * @mixin \Eloquent
 */
class smtpfindpiece extends Model
{
    protected  $table = "smtpfindpiece";
    public $timestamps = false;
}
