<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = ['id'];

    public function store() { return $this->belongsTo(Store::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function reviews() { return $this->hasMany(ProductReview::class); }

    // Relasi untuk Wishlist: Mengetahui siapa saja yang memasukkan produk ini ke Wishlist
    public function wishlistedBy() 
    {
        // Asumsi model Wishlist dibuat
        return $this->hasMany(Wishlist::class); 
    }
}