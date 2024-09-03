<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servic extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_category_id',
        'title',
        'status',
        'view',
        'photo',
        'descriptions',

    ];
    protected $casts = [
        'title' => 'array',
        'descriptions' => 'array',
    ];
    public function service_category()
    {
        return $this->belongsTo(ServiceCategory::class);
    }
}
