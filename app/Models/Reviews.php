<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reviews extends Model
{
  use HasFactory;

  protected $casts = [
    'created_at' => 'datetime', 
    'updated_at' => 'datetime',
  ];

  protected $fillable = [
    'review', 'rating', 'user_id', 'task_id'
  ];

  public function getUserAttribute(){
    return User::find($this->user_id);
  }

  public function getSinceAttribute(){
    return $this->created_at->diffForHumans();
  }

  protected $appends = [
    'since', 'user'
  ];
}
