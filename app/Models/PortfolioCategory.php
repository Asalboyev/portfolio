<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PortfolioCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'photo',
        'descriptions',

    ];
    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];
//    public function product(): HasMany
//    {
//        return $this->hasMany(Product::class);
//    }
    public function categories()
    {
        return $this->hasMany(self::class)->orderBy('id');
    }

    public function category()
    {
        return $this->belongsTo(self::class);
    }
    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }



}


