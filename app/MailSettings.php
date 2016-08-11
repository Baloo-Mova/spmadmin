<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MailSettings extends Model
{
    public $timestamps = false;

    public $fillable = [
        'emails_from_server',
        'attach_name_macros',
        'thread_count',
        'x_mailer',
        'smtp_count',
        'message_theme',
        'message_text',
        'send_attach',
        'macros1',
        'macros2',
        'macros3',
    ];
}
