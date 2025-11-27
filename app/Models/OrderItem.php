<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // KITA PAKAI FILLABLE AGAR LEBIH SPESIFIK & AMAN
    protected $fillable = [
        'order_id', 
        'product_id', 
        'store_id', 
        'quantity', 
        'price', 
        'subtotal', 
        'status' // <--- Pastikan kolom ini ada disini!
    ];

    public function product() {
        return $this->belongsTo(Product::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }
}