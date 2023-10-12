<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UnlockBadges
{
    public function handle(AchievementUnlocked $event)
    {
        $user = $event->user;

        // Check for badge conditions
        if ($user->achievementCount() >= 5 && !$user->hasBadge('Advanced')) {
            $user->unlockBadge('Advanced');
        }
    }
}