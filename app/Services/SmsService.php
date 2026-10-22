<?php

namespace App\Services;

use App\Models\AuditLog;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    /**
     * Send an SMS to one or multiple recipients.
     *
     * @param string|array $recipients Phone number(s) (e.g. 0712345678, 255712345678, +255712345678)
     * @param string $message The SMS text content
     * @param int|null $churchId
     * @return array Result array with status, message, and recipient details
     */
    public static function send(string|array $recipients, string $message, ?int $churchId = null): array
    {
        $numbers = is_array($recipients) ? $recipients : [$recipients];
        $formattedNumbers = [];

        foreach ($numbers as $num) {
            $cleaned = self::formatTanzanianPhone($num);
            if ($cleaned) {
                $formattedNumbers[] = $cleaned;
            }
        }

        if (empty($formattedNumbers)) {
            return [
                'success' => false,
                'message' => 'Hakuna namba sahihi ya simu iliyotolewa.',
                'sent_count' => 0,
            ];
        }

        $provider = env('SMS_PROVIDER', 'log'); // 'log', 'beem', 'nextsms', 'twilio'

        try {
            switch ($provider) {
                case 'beem':
                    $result = self::sendViaBeem($formattedNumbers, $message);
                    break;
                case 'nextsms':
                    $result = self::sendViaNextSms($formattedNumbers, $message);
                    break;
                case 'twilio':
                    $result = self::sendViaTwilio($formattedNumbers, $message);
                    break;
                case 'log':
                default:
                    $result = self::sendViaLog($formattedNumbers, $message);
                    break;
            }

            AuditService::log(
                action: 'sent_sms',
                description: 'SMS zilitumwa kwa wapokeaji ' . count($formattedNumbers) . ' kupitia ' . strtoupper($provider) . ': ' . substr($message, 0, 80) . '...',
                entityType: 'SmsNotification',
                churchId: $churchId
            );

            return $result;
        } catch (\Throwable $e) {
            Log::error('SMS Dispatch Error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Hitilafu wakati wa kutuma SMS: ' . $e->getMessage(),
                'sent_count' => 0,
            ];
        }
    }

    /**
     * Clean and format phone number for Tanzania/East Africa (255XXXXXXXXX).
     */
    public static function formatTanzanianPhone(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        $clean = preg_replace('/[^0-9]/', '', $phone);

        // e.g. 0754123456 -> 255754123456
        if (str_starts_with($clean, '0') && strlen($clean) === 10) {
            return '255' . substr($clean, 1);
        }

        // e.g. 754123456 -> 255754123456
        if (strlen($clean) === 9 && in_array(substr($clean, 0, 1), ['6', '7'])) {
            return '255' . $clean;
        }

        // Already 255XXXXXXXXX
        if (str_starts_with($clean, '255') && strlen($clean) === 12) {
            return $clean;
        }

        return $clean;
    }

    /**
     * Simulation / Log driver (default for local & development).
     */
    private static function sendViaLog(array $numbers, string $message): array
    {
        Log::info('--- SIMULATED CHURCH SMS ---');
        Log::info('Recipients: ' . implode(', ', $numbers));
        Log::info('Content: ' . $message);
        Log::info('----------------------------');

        return [
            'success' => true,
            'message' => 'SMS ' . count($numbers) . ' zimetumwa (Simulation/Log mode).',
            'sent_count' => count($numbers),
            'provider' => 'log',
            'recipients' => $numbers,
        ];
    }

    /**
     * Beem Africa SMS Gateway integration.
     */
    private static function sendViaBeem(array $numbers, string $message): array
    {
        $apiKey = env('BEEM_API_KEY');
        $secretKey = env('BEEM_SECRET_KEY');
        $senderName = env('BEEM_SENDER_NAME', 'EAGT');

        if (empty($apiKey) || empty($secretKey)) {
            return self::sendViaLog($numbers, $message);
        }

        $recipientList = [];
        foreach ($numbers as $idx => $num) {
            $recipientList[] = [
                'recipient_id' => $idx + 1,
                'dest_addr' => $num,
            ];
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic ' . base64_encode($apiKey . ':' . $secretKey),
        ])->post('https://apisms.beem.africa/v1/send', [
            'source_addr' => $senderName,
            'schedule_time' => '',
            'encoding' => 0,
            'message' => $message,
            'recipients' => $recipientList,
        ]);

        return [
            'success' => $response->successful(),
            'message' => $response->successful() ? 'SMS zimetumwa kupitia Beem Africa.' : 'Beem API Error: ' . $response->body(),
            'sent_count' => $response->successful() ? count($numbers) : 0,
            'provider' => 'beem',
        ];
    }

    /**
     * NextSMS Gateway integration.
     */
    private static function sendViaNextSms(array $numbers, string $message): array
    {
        $username = env('NEXTSMS_USERNAME');
        $password = env('NEXTSMS_PASSWORD');
        $senderId = env('NEXTSMS_SENDER_ID', 'EAGT');

        if (empty($username) || empty($password)) {
            return self::sendViaLog($numbers, $message);
        }

        $response = Http::withBasicAuth($username, $password)
            ->post('https://messaging-service.co.tz/api/sms/v1/text/multi', [
                'from' => $senderId,
                'to' => $numbers,
                'text' => $message,
            ]);

        return [
            'success' => $response->successful(),
            'message' => $response->successful() ? 'SMS zimetumwa kupitia NextSMS.' : 'NextSMS API Error: ' . $response->body(),
            'sent_count' => $response->successful() ? count($numbers) : 0,
            'provider' => 'nextsms',
        ];
    }

    /**
     * Twilio SMS Gateway integration.
     */
    private static function sendViaTwilio(array $numbers, string $message): array
    {
        $sid = env('TWILIO_SID');
        $token = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_FROM');

        if (empty($sid) || empty($token)) {
            return self::sendViaLog($numbers, $message);
        }

        $sentCount = 0;
        foreach ($numbers as $num) {
            $to = str_starts_with($num, '+') ? $num : '+' . $num;
            $res = Http::withBasicAuth($sid, $token)
                ->asForm()
                ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                    'To' => $to,
                    'From' => $from,
                    'Body' => $message,
                ]);

            if ($res->successful()) {
                $sentCount++;
            }
        }

        return [
            'success' => $sentCount > 0,
            'message' => "SMS {$sentCount} zimetumwa kupitia Twilio.",
            'sent_count' => $sentCount,
            'provider' => 'twilio',
        ];
    }

    // --- TEMPLATES / MUUNDO WA UJUMBE WA KANISA ---

    public static function titheReceipt(string $memberName, float $amount, string $code, string $churchName): string
    {
        $amtFormatted = number_format($amount);
        return "Bwana Asifiwe {$memberName}! Kanisa la {$churchName} linathibitisha kupokea Zaka/Mchango wako wa Tsh {$amtFormatted} (Kumb: {$code}). Mungu akubariki na kukufanikisha daima (Malaki 3:10).";
    }

    public static function visitorWelcome(string $visitorName, string $churchName): string
    {
        return "Bwana Asifiwe {$visitorName}! Ni furaha kubwa kuwa nawe katika ibada ya leo kanisani {$churchName}. Karibu tena nyumbani mwa Bwana; Mungu akubariki sana!";
    }

    public static function serviceReminder(string $churchName, string $serviceTitle, string $time): string
    {
        return "Mpendwa mshirika wa {$churchName}, tukukumbushe kuhudhuria {$serviceTitle} leo kuanzia {$time}. Uwepo wa Bwana utakuhudumia!";
    }
}
