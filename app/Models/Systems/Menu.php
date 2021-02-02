<?php

namespace App\Models\Systems;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';

    protected $fillabel = [
        'url',
        'parent_id',
        'name',
        'slug',
        'icon',
        'i18n',
        'order',
        'is_parent',
        'navheader',
    ];
}
