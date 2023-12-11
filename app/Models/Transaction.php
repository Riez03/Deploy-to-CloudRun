<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ingredients_id',
        'user_id',
        'quantity',
        'total',
        'status',
        'payment_url'
    ];

    // Perbaikan: Gunakan hasMany karena satu transaksi dapat memiliki banyak Ingredients
    // public function ingredients()
    // {
    //     return $this->hasMany(Ingredients::class, 'id', 'ingredients_id');
    // }

    public function ingredients()
    {
        return $this->belongsTo(Ingredients::class, 'ingredients_id', 'id');
    }

    // Perbaikan: Gunakan belongsTo karena setiap transaksi hanya memiliki satu User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // public function getCreatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->timestamp;
    // }

    // public function getUpdatedAtAttribute($value)
    // {
    //     return Carbon::parse($value)->timestamp;
    // }
}
