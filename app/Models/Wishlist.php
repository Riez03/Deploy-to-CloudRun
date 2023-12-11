<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
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

    public function ingredients()
    {
        return $this->hasOne(Ingredients::class, 'id', 'ingredients_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
