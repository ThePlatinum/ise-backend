<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'email', 'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
    'role'
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'phone_verified_at' => 'datetime',
  ];

  public function isAdmin(): bool
  {
    return $this->role;
  }

  public function getFullNameAttribute(): string
  {
    return $this->firstname . ' ' . $this->lastname . ' ' . $this->othername;
  }

  public function portfolio()
  {
    return $this->hasMany(Portfolio::class, 'user_id');
  }

  public function reviews()
  {
    return $this->hasManyThrough(Reviews::class, Task::class, 'user_id', 'task_id');
  }

  public function getRatingsAttribute()
  {
    return $this->reviews()->avg('rating');
  }

  public function getRatingsCountsAttribute()
  {
    return $this->reviews()->count();
  }

  protected $appends = [
    'fullname', 'ratings', 'ratings_counts'
  ];
}
