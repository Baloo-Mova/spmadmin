<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
