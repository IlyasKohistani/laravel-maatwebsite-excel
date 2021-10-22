<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    protected $fillable = ['id','name'];

    public function packages(){
        return $this->belongsToMany(Package::class,'package_shop')->withPivot('product_id');
    }


    public function products(){
        return $this->belongsToMany(Product::class,'package_shop')->withPivot('package_id');
    }
}
