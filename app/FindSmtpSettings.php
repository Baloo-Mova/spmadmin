<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
