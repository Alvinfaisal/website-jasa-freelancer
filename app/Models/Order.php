<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
  // use HasFactory;

  use SoftDeletes;

  protected $table = 'order';

  protected $dates = [
    'updated_at',
    'created_at',
    'deleted_at',
  ];

  protected $fillable = [
    'buyer_id',
    'frelancer_id',
    'service_id',
    'file',
    'note',
    'expired',
    'order_status_id',
    'updated_at',
    'created_at',
    'deleted_at',
  ];

  // relation

  // one to many
  public function user_buyer()
  {
    return $this->belongsTo('App\Models\User', 'buyer_id', 'id');
  }

  public function user_frelancer()
  {
    return $this->belongsTo('App\Models\User', 'frelancer_id', 'id');
  }

  public function service()
  {
    return $this->belongsTo('App\Models\Service', 'service_id', 'id');
  }

  public function order_status()
  {
    return $this->belongsTo('App\Models\OrderStatus', 'order_status_id', 'id');
  }
}
