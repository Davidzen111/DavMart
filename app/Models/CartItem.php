<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // Item ini ada di keranjang mana?
    public function cart() {
        return $this->belongsTo(Cart::class);
    }

    // Item ini produknya apa?
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
