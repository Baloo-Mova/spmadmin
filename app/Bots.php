<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Bots
 *
 * @property integer $id
 * @property string $ip
 * @property integer $status
 * @property string $time
 * @property integer $result
 * @property integer $life
 * @property integer $ban
 * @property integer $otk
 * @property integer $bot_status
 * @property integer $black
 * @property string $bandate
 * @property string $blacklistdate
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereTime($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereResult($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereLife($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereBan($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereOtk($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereBotStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereBlack($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereBandate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereBlacklistdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Bots whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Bots extends Model
{
    public $fillable=['ip'];
}
