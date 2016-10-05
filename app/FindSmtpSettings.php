<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\FindSmtpSettings
 *
 * @property integer $id
 * @property integer $threads
 * @property integer $count_emails
 * @property integer $timeout
 * @property integer $pull_size
 * @property integer $pull_swap_size
 * @method static \Illuminate\Database\Query\Builder|\App\FindSmtpSettings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FindSmtpSettings whereThreads($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FindSmtpSettings whereCountEmails($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FindSmtpSettings whereTimeout($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FindSmtpSettings wherePullSize($value)
 * @method static \Illuminate\Database\Query\Builder|\App\FindSmtpSettings wherePullSwapSize($value)
 * @mixin \Eloquent
 */
class FindSmtpSettings extends Model
{
    public $timestamps = false;
    public $table = "find_settings";
    public $fillable = [
        'threads',
        'count_emails',
        'pull_size',
        'pull_swap_size',
        'timeout'
    ];
}
