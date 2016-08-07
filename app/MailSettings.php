<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSettings extends Model
{
    public $timestamps = false;

    public $fillable = [
        'theme',
        'message',
        'bb',
        'sh',
        'from',
        'reply',
        'mot',
        'kolps',
        'html',
        'redirects',
        'macros_one',
        'macros_two',
        'macros_try',
        'macros1',
        'macros2',
        'macros3',
    ];
}
