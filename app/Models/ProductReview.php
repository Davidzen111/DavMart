<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user() {
        return $this->belongsTo(User::class); // Siapa yang review
    }

    public function product() {
        return $this->belongsTo(Product::class); // Produk apa yang direview
    }
    
    // Optional: Untuk cek review ini dari order yang mana (validasi verified purchase)
    public function order() {
        return $this->belongsTo(Order::class);
    }
}