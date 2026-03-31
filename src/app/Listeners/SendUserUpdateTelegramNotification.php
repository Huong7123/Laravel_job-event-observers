<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendUserUpdateTelegramNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserUpdated $event): void
    {
        $changes = implode(', ', $event->changes);
        $message = "🔔 <b>Người dùng vừa thay đổi {$changes}!</b>\nName: {$event->user->name}\nEmail: {$event->user->email}";

        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('TELEGRAM_CHAT_ID');

        if (!$token || !$chatId) {
            Log::warning('Chưa cấu hình TELEGRAM_BOT_TOKEN hoặc TELEGRAM_CHAT_ID trong .env');
            return;
        }

        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        $response = Http::post($url, [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);

        if ($response->successful()) {
            Log::info("Đã gửi thông báo Telegram thành công cho sự thay đổi của User ID: {$event->user->id}");
        } else {
            Log::error('Lỗi khi gửi thông báo Telegram: ' . $response->body());
        }
    }
}
