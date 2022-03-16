<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
  use HasApiTokens;
  use HasFactory;
  use HasProfilePhoto;
  use HasTeams;
  use Notifiable;
  use TwoFactorAuthenticatable;

  use SoftDeletes;

  protected $dates = [
    'updated_at',
    'created_at',
    'deleted_at',
    'email_verified_at'
  ];

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $fillable = [
    'name', 'email', 'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array
   */
  protected $hidden = [
    'password',
    'remember_token',
    'two_factor_recovery_codes',
    'two_factor_secret',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
  ];

  /**
   * The accessors to append to the model's array form.
   *
   * @var array
   */
  protected $appends = [
    'profile_photo_url',
  ];

  // Relation table with orm(Object Relational Mapper)- dengan orm kita membuat mapping" atau relasi antar tabel menjadi sebuah object agar bisa digunakan dengan mudah di controller atau view tanpa perlu melaukan proses join join mysql yang ribet 
  // Blueprint penulisan nya - nama fungsi biar mudah disamakan aja dengan nama migrationnya, sebenernya bebas
  /** 
   * public function nama_fungsi()
   * {
   *  return $this->JenisRelasinya('Path\Lokasi\Modelnya', 'nama_field_yang_berada_diMigration_tujan_ex:users_id')
   * }
   */

  //  yang diberikan jenis relasi(hasMany atau hasOne) yaitu model utamanya, *model yang memberikan fielnya ke model atau table lain ex* users_id  yaitu meminta id dari table users - sementar table tujuan nya cukup menggunakan belongsTo untuk memberi tahu laravel bahwa tabel ini berhubungan dengan tabel utama tadi. 

  // one to one
  public function detail_user()
  {
    return $this->hasOne('App\Models\DetailUser', 'users_id');
  }


  // one to many
  public function service()
  {
    return $this->hasMany('App\Models\Service', 'users_id');
  }

  public function order_buyer()
  {
    return $this->hasMany('App\Models\Order', 'buyer_id');
  }

  public function order_frelancer()
  {
    return $this->hasMany('App\Models\Order', 'frelancer_id');
  }
}
