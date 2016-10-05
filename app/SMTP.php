<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SMTP
 *
 * @property integer $id
 * @property string $domen
 * @method static \Illuminate\Database\Query\Builder|\App\SMTP whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SMTP whereDomen($value)
 * @mixin \Eloquent
 */
class SMTP extends Model
{
    protected $table="smtp";
}
