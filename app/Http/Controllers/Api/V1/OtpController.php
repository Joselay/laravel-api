<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Otp; // Import the Otp model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OtpController extends Controller
{
    /**
     * @OA\Post(
     *     path="/send-otp",
     *     tags={"OTP"},
     *     summary="Send OTP to email",
     *     description="Sends an OTP to the specified email address for verification",
     *     @OA\RequestBody(
     *         required=true,
     *         description="Email address",
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP sent successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid email"
     *     )
     * )
     */
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $otp = rand(100000, 999999);

        Otp::create([
            'email' => $request->email,
            'otp' => $otp,
            'created_at' => now(),
        ]);

        error_log('OTP Stored: ' . $otp . ' Email: ' . $request->email);

        Mail::to($request->email)->send(new \App\Mail\OtpMail($otp));

        return response()->json(['message' => 'OTP sent successfully'], 200);
    }

    /**
     * @OA\Post(
     *     path="/verify-otp",
     *     tags={"OTP"},
     *     summary="Verify OTP code",
     *     description="Verifies the OTP code sent to the specified email",
     *     @OA\RequestBody(
     *         required=true,
     *         description="OTP and email address",
     *         @OA\JsonContent(
     *             required={"email", "otp"},
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="otp", type="string", example="123456")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP verified successfully"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid OTP or email"
     *     )
     * )
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:6',
        ]);

        $otpRecord = Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->latest()
            ->first();

        if ($otpRecord && $otpRecord->created_at->diffInMinutes(now()) <= 5) {
            $otpRecord->delete();
            return response()->json(['message' => 'OTP verified successfully'], 200);
        }

        return response()->json(['message' => 'Invalid OTP or email'], 400);
    }
}
