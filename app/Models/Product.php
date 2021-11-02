<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'name','sku','article_code','total_in_stock'];
    
    public function sizes()
    {
        return $this->belongsToMany(Size::class,'product_quantity')->withPivot('quantity');
    } 
}
