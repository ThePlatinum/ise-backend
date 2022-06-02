<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
  use HasFactory;

  protected $cast = [
    'start_date' => 'date',
    'end_date' => 'date',
  ];

  protected $fillable = [
    'user_id', 'title',
    'description', 'file',
    'external_link',
    'start_date', 'end_date'
  ];

  protected $hidden = [
    'created_at', 'updated_at'
  ];
}
