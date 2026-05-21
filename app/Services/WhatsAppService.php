<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Send WhatsApp notification using Fonnte API.
     *
     * @param string|array|null $targets Phone number(s) to send to.
     * @param string $message The message content.
     * @return bool
     */
    public static function send($targets, string $message): bool
    {
        $fonteToken = env('FONNTE_TOKEN');
        if (!$fonteToken) {
            Log::warning('WhatsAppService: FONNTE_TOKEN is not configured.');
            return false;
        }

        // Normalize targets to an array
        if (is_string($targets)) {
            $targets = explode(',', $targets);
        }

        $targets = is_array($targets) ? array_filter(array_map('trim', $targets)) : [];
        
        if (empty($targets)) {
            // Fallback to env default number
            $fallback = env('WHATSAPP_NOTIFY_NUMBER', '6281332809923');
            if ($fallback) {
                $targets = [$fallback];
            } else {
                Log::warning('WhatsAppService: No targets specified and no fallback available.');
                return false;
            }
        }

        // Format each target number to international format
        $formattedTargets = [];
        foreach ($targets as $target) {
            $formatted = preg_replace('/[^0-9]/', '', $target);
            if (strpos($formatted, '0') === 0) {
                $formatted = '62' . substr($formatted, 1);
            }
            if ($formatted) {
                $formattedTargets[] = $formatted;
            }
        }

        if (empty($formattedTargets)) {
            Log::warning('WhatsAppService: Normalized target list is empty.');
            return false;
        }

        $targetString = implode(',', $formattedTargets);

        try {
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_HTTPHEADER => [
                    'Authorization: ' . $fonteToken,
                ],
                CURLOPT_POSTFIELDS => [
                    'target' => $targetString,
                    'message' => $message,
                ],
                CURLOPT_TIMEOUT => 10,
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                Log::error('WhatsAppService cURL Error: ' . $err);
                return false;
            }

            Log::info('WhatsAppService Response: ' . $response);
            return true;
        } catch (\Exception $e) {
            Log::error('WhatsAppService Exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send WhatsApp notification to all users matching a specific role.
     * Falls back to the WHATSAPP_NOTIFY_NUMBER if no users have a phone set.
     *
     * @param string $role User role (e.g. manager, accounting, direktur, penasihat)
     * @param string $message
     * @return bool
     */
    public static function sendToRole(string $role, string $message): bool
    {
        $users = User::where('role', $role)->whereNotNull('phone')->where('phone', '!=', '')->get();
        
        $targets = [];
        foreach ($users as $user) {
            $targets[] = $user->phone;
        }

        if (empty($targets)) {
            Log::info("WhatsAppService: No phone numbers found for role '$role'. Using default notify number.");
            return self::send(null, $message);
        }

        return self::send($targets, $message);
    }
}
