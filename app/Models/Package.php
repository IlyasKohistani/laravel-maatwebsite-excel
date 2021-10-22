<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;
    protected $fillable = ['name','total_quantity'];

    public function sizes()
    {
        return $this->belongsToMany(Size::class,'package_quantity')->withPivot('quantity');
    } 
}
