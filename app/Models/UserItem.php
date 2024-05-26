<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserItem extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'string',
        'text',
        'number',
        'item_select_id',
    ];
}
