<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OTP;
use Illuminate\Http\Request;
use App\Services\OTPService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class OtpVerifyController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Request OTP
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function requestOTP(Request $request)
    {
        $request->validate(['phone_number' => 'required|string']);

        $otpCode = $this->otpService->generateOTP($request->phone_number);
        
        return response()->json(['message' => 'OTP sent', 'otp_code' => $otpCode]);
    }

    /**
     * Verify OTP
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'phone_number' => 'required|string',
            'otp_code' => 'required|string',
        ]);

        $isValid = $this->otpService->validateOTP($request->phone_number, $request->otp_code);

        if ($isValid) {
            // Authenticate user
                // Authenticate user
                $user = OTP::firstOrCreate(['phone_number' => $request->phone_number]);
                $userInstance = User;
                $token = $userInstance->createToken('authToken')->plainTextToken;

            return response()->json(['message' => 'OTP verified', 'token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid OTP'], 400);
        }
    }
}
