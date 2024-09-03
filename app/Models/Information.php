<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    use HasFactory;

    protected $fillable = ['phone','telegram','instagram','youtube','linkedln','photo','project_completed','client_satisfied',
'design_project'];


    protected $casts = [
        'photo' => 'array',
    ];
}
