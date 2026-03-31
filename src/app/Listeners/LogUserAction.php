<?php

namespace App\Listeners;

use App\Events\UserUpdated;
use App\Models\UserAction;
use Illuminate\Support\Facades\Log;

class LogUserAction
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

        foreach ($event->changes as $change) {
            UserAction::create([
                'user_id' => $event->user->id,
                'action' => "updated_{$change}"
            ]);
        }

        Log::info("Đã ghi nhận hành động cập nhật cho User ID: {$event->user->id}");
    }
}
