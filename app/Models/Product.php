<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function productImages(){
        return $this->hasMany(ProductImage::class,'product_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function productColors(){
        return $this->hasMany(ProductColor::class,'product_id');
    }

    public function reviews(){
        return $this->hasMany(Review::class,'product_id','id');
    }
}
