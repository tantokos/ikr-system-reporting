<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessPortal extends Model
{
    use HasFactory;

    protected $fillable=[
        'portal_menu',
        'portal_link'
    ];
}
