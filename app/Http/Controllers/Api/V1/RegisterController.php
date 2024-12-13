<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="User registration details",
     *         @OA\JsonContent(
     *             required={"name", "email", "password"},
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="email", type="string", format="email", example="user@example.com"),
     *             @OA\Property(property="password", type="string", format="password", example="password123"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OTP sent successfully. Please verify to complete registration."
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid input or other error"
     *     )
     * )
     */
    public function register(Request $request)
    {
        // Validate the user input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Call the `send-otp` endpoint logic
        $otpController = new OtpController();
        $otpRequest = new Request(['email' => $request->email]);
        $sendOtpResponse = $otpController->sendOtp($otpRequest);

        if ($sendOtpResponse->getStatusCode() == 200) {
            return response()->json([
                'message' => 'OTP sent successfully. Please verify using the /verify-otp endpoint.',
                'email' => $request->email,
            ], 200);
        }

        return response()->json(['message' => 'Failed to send OTP.'], 400);
    }
}
