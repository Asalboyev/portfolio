<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_category_id',
        'title',
        'status',
        'order',
        'photo',
        'descriptions',
    ];

    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];

    public function service_categories()
    {
        return $this->hasMany(self::class)->orderBy('id');
    }

    public function service_category()
    {
        return $this->belongsTo(self::class);
    }

    public function services()
    {
        return $this->hasMany(Servic::class);
    }

    public function subService()
    {
        return $this->hasManyThrough(Servic::class, ServiceCategory::class)->orderBy('id');
    }


}

