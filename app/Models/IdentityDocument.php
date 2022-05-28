<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IdentityDocument extends Model
{
  use HasFactory;

  protected $fillable = [
    'user_id', 'file_name', 'type_id', 'file_type', 'file_url', 'name_on_document', 'document_number', 'document_expiry'
  ];
}
