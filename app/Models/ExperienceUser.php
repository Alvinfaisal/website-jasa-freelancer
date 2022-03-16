<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExperienceUser extends Model
{
  // use HasFactory;

  use SoftDeletes;

  // mereprentasikan atau mewakili tabel experience_user
  protected $table = 'experience_user';

  // Memberi tahu laravel field ini hanya dapat diisi dengan format date
  protected $dates = [
    'updated_at',
    'created_at',
    'deleted_at',
  ];

  // Memeberi tahu laravel bahwa field" ini bisa diisi dari sebuah request atau view yang dilakukan oleh user/client
  protected $fillable = [
    'detail_user_id',
    'experience',
    'updated_at',
    'created_at',
    'deleted_at',
  ];


  // relation

  // one to many
  public function detail_user()
  {
    return $this->belongsTo('App\Models\DetailUser', 'detail_user_id', 'id');
  }
}
