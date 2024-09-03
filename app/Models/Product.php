<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_category_id',
        'title',
        'optional_key',
        'standard_key',
        'status',
        'view',
        'photo',
        'price',
        'descriptions',

    ];
    protected $casts = [
        'title' => 'array',
        'photo' => 'array',
        'descriptions' => 'array',
        'optional_key' =>'array',
        'standard_key' =>'array',
    ];

    public function product_category()
    {
        return $this->belongsTo(ProductCategory::class);
    }
}
