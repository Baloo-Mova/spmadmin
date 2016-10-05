<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\ControlMailList
 *
 * @property integer $id
 * @property string $mail
 * @method static \Illuminate\Database\Query\Builder|\App\ControlMailList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\ControlMailList whereMail($value)
 * @mixin \Eloquent
 */
class ControlMailList extends Model
{
    public $timestamps = false;
    public $table = "controlmaillist";
}
