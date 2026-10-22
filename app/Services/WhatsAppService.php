<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    /**
     * Clean and format phone number for WhatsApp URL (e.g., 255754123456).
     */
    public static function formatPhone(?string $phone): ?string
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
     * Generate a direct WhatsApp click-to-chat URL (wa.me).
     */
    public static function chatUrl(?string $phone, string $message = ''): string
    {
        $formatted = self::formatPhone($phone);
        $encodedMessage = urlencode($message);

        if ($formatted) {
            return "https://wa.me/{$formatted}?text={$encodedMessage}";
        }

        return "https://wa.me/?text={$encodedMessage}";
    }

    /**
     * Generate a pre-filled WhatsApp Tithe / Offering receipt URL.
     */
    public static function receiptUrl(
        string $memberName,
        ?string $phone,
        float $amount,
        string $code,
        string $churchName,
        string $category = 'Sadaka/Zaka'
    ): string {
        $categoryName = match($category) {
            'tithe' => 'Zaka ya Mwezi',
            'building_offering' => 'Mchango wa Ujenzi',
            'thanksgiving' => 'Sadaka ya Shukrani',
            default => 'Sadaka',
        };

        $amtFormatted = number_format($amount);
        $message = "Bwana Asifiwe Ndugu *{$memberName}*!\n\n"
            . "Uongozi wa Kanisa la *{$churchName}* unathibitisha kupokea *{$categoryName}* yako ya *Tsh {$amtFormatted}*.\n\n"
            . "📋 *Nambari ya Kumbukumbu:* `{$code}`\n"
            . "📅 *Tarehe:* " . date('d/m/Y') . "\n\n"
            . "_\"Leteni zaka kamili ghalani, ili kiwemo chakula katika nyumba yangu... mkaone kama sitawafungulia madirisha ya mbinguni na kuwamwagia baraka...\" (Malaki 3:10)_\n\n"
            . "Mungu azidi kukufanikisha na kukubariki!";

        return self::chatUrl($phone, $message);
    }

    /**
     * Generate WhatsApp prayer request consultation link.
     */
    public static function prayerChatUrl(string $requesterName, ?string $phone, string $prayerCategory): string
    {
        $message = "Bwana Asifiwe Ndugu *{$requesterName}*!\n\n"
            . "Tunawasiliana nawe kutoka Ofisi ya Mchungaji Kiongozi (EAGT Golani) kuhusu ombi lako la maombi (*{$prayerCategory}*).\n\n"
            . "Mchungaji na Baraza la Wazee wanakuombea. Tungependa kujua maendeleo yako ya kiroho na jinsi Mungu anavyokutendea.";

        return self::chatUrl($phone, $message);
    }

    /**
     * Send automated message via Meta WhatsApp Business Cloud API (if configured in .env).
     */
    public static function sendCloudMessage(string $phone, string $message): array
    {
        $token = env('WHATSAPP_TOKEN');
        $phoneId = env('WHATSAPP_PHONE_ID');

        if (empty($token) || empty($phoneId)) {
            Log::info("--- SIMULATED WHATSAPP MESSAGE ---");
            Log::info("To: {$phone} | Content: {$message}");
            Log::info("----------------------------------");

            return [
                'success' => true,
                'mode' => 'simulated',
                'message' => 'Ujumbe umerekodiwa (WhatsApp Cloud API haijaunganishwa). Bofya link ya WhatsApp moja kwa moja.',
            ];
        }

        $formatted = self::formatPhone($phone);

        try {
            $response = Http::withToken($token)
                ->post("https://graph.facebook.com/v19.0/{$phoneId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to' => $formatted,
                    'type' => 'text',
                    'text' => ['body' => $message],
                ]);

            if ($response->successful()) {
                return ['success' => true, 'data' => $response->json()];
            } else {
                Log::error('WhatsApp Cloud API Error: ' . $response->body());
                return ['success' => false, 'error' => $response->body()];
            }
        } catch (\Throwable $e) {
            Log::error('WhatsApp Dispatch Exception: ' . $e->getMessage());
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}
