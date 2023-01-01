<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $guarded = [];

    public function product(){
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function productColor(){
        return $this->belongsTo(ProductColor::class,'product_color_id','id');
    }
}
