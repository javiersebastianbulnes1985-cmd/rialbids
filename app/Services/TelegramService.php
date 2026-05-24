<?php
namespace App\Services;

class TelegramService
{
    public static function send(string $message): void
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');
        if (!$token || !$chatId) return;
        $url = "https://api.telegram.org/bot{$token}/sendMessage";
        $data = ['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'HTML'];
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }
}
