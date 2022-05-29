<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    protected $fillable = ['name', 'slug'];

    protected $hidden = ['created_at', 'updated_at'];
}
