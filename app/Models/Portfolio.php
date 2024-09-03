<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use function Symfony\Component\Translation\t;

class Portfolio extends Model
{
    use HasFactory;
    protected $fillable = [
        'portfolio_category_id',
        'title',
        'status',
        'view',
        'photo',
        'descriptions',
        'url'

    ];
    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];

    public function tags()
    {
        return $this->belongsToMany(Tag::class);

    }

}
