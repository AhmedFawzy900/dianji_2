<?php

namespace App\Services;

use App\Models\OTP;
use Illuminate\Support\Str;
use App\Services\TwilioService;

class OTPService
{
    protected $twilioService;

    public function __construct(TwilioService $twilioService)
    {
        $this->twilioService = $twilioService;
    }

    /**
     * Generate and send an OTP code.
     *
     * @param string $phoneNumber
     * @return string
     */
    public function generateOTP($phoneNumber)
    {
        // Generate a numeric OTP code
        $otpCode = $this->generateNumericOTP(6);

        // Save OTP code to the database
        OTP::updateOrCreate(
            ['phone_number' => $phoneNumber],
            ['otp_code' => $otpCode, 'expires_at' => now()->addMinutes(10)]
        );

        // Send OTP via SMS using Twilio
        $message = "Your OTP code is: $otpCode";
        $this->twilioService->sendSMS($phoneNumber, $message);

        return $otpCode;
    }

    /**
     * Generate a numeric OTP code of a specified length.
     *
     * @param int $length
     * @return string
     */
    private function generateNumericOTP($length = 6)
    {
        $otp = '';
        for ($i = 0; $i < $length; $i++) {
            $otp .= rand(0, 9);
        }
        return $otp;
    }

    /**
     * Validate an OTP code for a given phone number.
     *
     * @param string $phoneNumber
     * @param string $otpCode
     * @return bool
     */
    public function validateOTP($phoneNumber, $otpCode)
    {
        $otp = OTP::where('phone_number', $phoneNumber)
            ->where('otp_code', $otpCode)
            ->where('expires_at', '>', now())
            ->first();

        return $otp ? true : false;
    }
}
