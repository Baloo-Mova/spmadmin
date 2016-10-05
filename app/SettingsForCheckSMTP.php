<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\SettingsForCheckSMTP
 *
 * @property integer $id
 * @property integer $threads
 * @property integer $countbots
 * @property string $mark
 * @property integer $timeout
 * @property integer $includefile
 * @property integer $mailText
 * @property integer $countsmtp
 * @property integer $countbase
 * @property integer $countload
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereThreads($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereCountbots($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereMark($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereTimeout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereIncludefile($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereMailText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereCountsmtp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereCountbase($value)
 * @method static \Illuminate\Database\Query\Builder|\App\SettingsForCheckSMTP whereCountload($value)
 * @mixin \Eloquent
 */
class SettingsForCheckSMTP extends Model
{
    protected $table    = 'settingsforchecksmtp';
    protected $fillable = [
        'threads',
        'countbots',
        'mark',
        'timeout',
        'includefile',
        'mailText',
        'countsmtp',
        'countbase',
       'countload'
    ];
    public $timestamps = false;
}
