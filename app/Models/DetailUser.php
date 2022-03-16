<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailUser extends Model
{
  // use HasFactory;

  use SoftDeletes;

  // mereprentasikan atau mewakili tabel detail_user
  protected $table = 'detail_user';

  // Memberi tahu laravel field ini hanya dapat diisi dengan format date
  protected $dates = [
    'updated_at',
    'created_at',
    'deleted_at',
  ];

  // Memeberi tahu laravel bahwa field" ini bisa diisi dari sebuah request atau view yang dilakukan oleh user/client - field id tidak perlu didaftarkan karena akan terisi otomatis increment
  protected $fillable = [
    'users_id',
    'photo',
    'role',
    'contact_number',
    'biography',
    'updated_at',
    'created_at',
    'deleted_at',
  ];


  // Relation

  // Memberi tahu laravel bahwa field users_id berhubungan dengan model dari user
  /**
   * Blueprint untuk memberi tahunya 
   * public function nama_fungsi()
   * {
   *  return $this->belongsTo('Path/Lokasi/Model', 'field_yang_ada_pada_table_ini', 'dan_terkait_denan_field_apaEx:id pada table users');
   * }
   */

  // one to one 
  public function user()
  {
    return $this->belongsTo('App\Models\User', 'users_id', 'id');
  }

  // one to many
  public function experience_user()
  {
    return $this->hasMany('App\Models\ExperienceUser', 'detail_user_id');
  }
}
