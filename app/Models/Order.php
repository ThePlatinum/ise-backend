<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  use HasFactory;

  protected $fillable = [
    'task_id', 'buyer_id', 'seller_id',
    'task_title', 'order_price',
    'quantity', 'duration', 'duration_type'
  ];
}
