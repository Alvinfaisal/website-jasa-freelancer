<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
  // use HasFactory;

  use SoftDeletes;

  protected $table = 'service';

  protected $dates = [
    'updated_at',
    'created_at',
    'deleted_at',
  ];

  protected $fillable = [
    'users_id',
    'title',
    'description',
    'delivery_time',
    'revision_time',
    'price',
    'note',
    'updated_at',
    'created_at',
    'deleted_at',
  ];
}
