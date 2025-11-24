<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = ['id'];

    public function product() { return $this->belongsTo(Product::class); }
    public function order() { return $this->belongsTo(Order::class); }
    public function store() { return $this->belongsTo(Store::class); } // Penting untuk Seller Dashboard
}
