<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Brand;
use App\Models\category;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'price',
        'weight',
        'quantity',
        'expiry',
        'preserve',
        'description',
        'image',
        'category_id',
        'brand_id',
        'manufacture',
        'subtitle',
        'sale',
    ];
    public function category()
    {
        return $this->belongsTo(category::class);
    }
    public function Brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function getDiscountedPriceAttribute()
    {
        if ($this->sale > 0) {
            return $this->price - ($this->price * ($this->sale / 100));
        }
        return $this->price;
    }
}
