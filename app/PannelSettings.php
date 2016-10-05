<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\PannelSettings
 *
 * @property integer $id
 * @property string $status
 * @property string $k
 * @property string $spam_k_name
 * @property string $_id
 * @property string $checkBlackList
 * @method static \Illuminate\Database\Query\Builder|\App\PannelSettings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PannelSettings whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PannelSettings whereK($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PannelSettings whereSpamKName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\PannelSettings whereCheckBlackList($value)
 * @mixin \Eloquent
 */
class PannelSettings extends Model
{
    public $timestamps = false;

    public $fillable = [
        'status',
        'k',
        'spam_k_name',
        '_id',
        'checkBlackList',
    ];
}
