<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
  use HasFactory;

  protected $fillable = [
    'review', 'rating', 'user_id', 'task_id'
  ];
}
