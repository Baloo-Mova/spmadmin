<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
