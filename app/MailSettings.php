<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\MailSettings
 *
 * @property integer $id
 * @property string $thread_count
 * @property string $emails_from_server
 * @property boolean $send_attach
 * @property string $x_mailer
 * @property string $attach_name_macros
 * @property string $macros_two
 * @property string $smtp_count
 * @property string $message_theme
 * @property string $message_text
 * @property string $macros1
 * @property string $macros2
 * @property string $macros3
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereThreadCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereEmailsFromServer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereSendAttach($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereXMailer($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereAttachNameMacros($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereMacrosTwo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereSmtpCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereMessageTheme($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereMessageText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereMacros1($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereMacros2($value)
 * @method static \Illuminate\Database\Query\Builder|\App\MailSettings whereMacros3($value)
 * @mixin \Eloquent
 */
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

    public function isContainsNull(){
        return in_array(null, $this->attributes);
    }
}
