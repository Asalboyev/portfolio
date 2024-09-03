<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_category_id',
        'title',
        'status',
        'order',
        'photo',
        'popular',
        'descriptions',

    ];
    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];


    public function product_categories()
    {
        return $this->hasMany(self::class)->orderBy('id');
    }

    public function product_category()
    {
        return $this->belongsTo(self::class);
    }
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function subProduct()
    {
        return $this->hasManyThrough(Product::class, ProductCategory::class)->orderBy('id');
    }





}
