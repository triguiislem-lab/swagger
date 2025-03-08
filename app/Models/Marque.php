<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * @OA\Schema(
 *     schema="Marque",
 *     required={"nom", "description", "logo"},
 *     @OA\Property(property="id", type="integer", format="int64"),
 *     @OA\Property(property="nom", type="string", example="Nike"),
 *     @OA\Property(property="description", type="string", example="Marque de vêtements sportifs"),
 *     @OA\Property(property="logo", type="string", example="nike_logo"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 */
class Marque extends Model
{
    use HasFactory;

    protected $fillable = ['nom','description','logo'];
}
