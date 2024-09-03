<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
/**
 * @OA\Schema(
 *     schema="Zayavka",
 *     required={"first_name",  "phone_number", "descriptions"},
 *     @OA\Property(property="id", type="integer", example="1"),
 *     @OA\Property(property="first_name", type="string", example="John"),
 *     @OA\Property(property="phone_number", type="string", example="+123456789"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Zayavka extends Model
{
    use HasFactory;
    protected $fillable = [
        'first_name','email', 'phone_number', 'descriptions', 'status'
    ];
}
