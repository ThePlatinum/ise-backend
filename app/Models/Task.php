<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
  use HasFactory;

  protected $fillable = [
    'name',
    'description',
    'duration',
    'duration_type',
    'price',
    'currency',
    'category_id',
    'user_id',
  ];

  protected $casts = [
    'duration' => 'integer',
    'price' => 'float',
  ];

  public function category()
  {
    return $this->belongsTo(Category::class, 'category_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'user_id');
  }
  
  protected $hidden = [
    'user_id',
  ];
}
