<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Otp",
 *     type="object",
 *     required={"email", "otp", "created_at"},
 *     @OA\Property(property="id", type="integer", example=1, description="The unique identifier for the OTP record"),
 *     @OA\Property(property="email", type="string", format="email", example="user@example.com", description="The email address associated with the OTP"),
 *     @OA\Property(property="otp", type="string", example="123456", description="The OTP code sent to the user"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-12-12T12:34:56Z", description="The date and time when the OTP was created")
 * )
 */
class Otp extends Model
{
    use HasFactory;

    protected $fillable = ['email', 'otp', 'created_at'];
}
