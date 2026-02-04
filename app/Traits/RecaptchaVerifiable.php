<?php

namespace App\Traits;

use Illuminate\Support\Facades\Http;

trait RecaptchaVerifiable
{
    /**
     * Verify Google reCAPTCHA v3 token
     * 
     * @param string $response reCAPTCHA token from frontend
     * @param string|null $action Expected action name
     * @return array ['success' => bool, 'score' => float, 'message' => string]
     */
    protected function verifyRecaptcha(string $response, ?string $action = null): array
    {
        $secretKey = config('services.recaptcha.secret_key', '');
        $threshold = config('services.recaptcha.score_threshold', 0.5);

        if (empty($secretKey)) {
            // No secret key configured, skip verification
            return ['success' => true, 'score' => 1.0, 'message' => 'reCAPTCHA not configured'];
        }

        if (empty($response)) {
            return ['success' => false, 'score' => 0, 'message' => 'Không thể xác thực reCAPTCHA'];
        }

        try {
            $verifyResponse = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
                'secret' => $secretKey,
                'response' => $response,
            ]);

            $result = $verifyResponse->json();

            if (!$result['success']) {
                return [
                    'success' => false,
                    'score' => 0,
                    'message' => 'Xác thực reCAPTCHA thất bại',
                ];
            }

            // Check action if provided
            if ($action && isset($result['action']) && $result['action'] !== $action) {
                return [
                    'success' => false,
                    'score' => $result['score'] ?? 0,
                    'message' => 'Action không hợp lệ',
                ];
            }

            // Check score
            $score = $result['score'] ?? 0;
            if ($score < $threshold) {
                return [
                    'success' => false,
                    'score' => $score,
                    'message' => 'Điểm reCAPTCHA quá thấp. Vui lòng thử lại.',
                ];
            }

            return [
                'success' => true,
                'score' => $score,
                'message' => 'OK',
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'score' => 0,
                'message' => 'Lỗi kết nối reCAPTCHA',
            ];
        }
    }
}
