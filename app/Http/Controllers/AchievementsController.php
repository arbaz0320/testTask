<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Achievement;
use App\Models\Badge;
class AchievementsController extends Controller
{
     public function unlockAchievements(Request $request)
    {
        // Assuming you have received the user and achievement data in the request
        $userId = $request->input('user_id');
        $achievementName = $request->input('achievement_name');
        
        // Find the user
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Check if the user already has the achievement
        if ($user->hasAchievement($achievementName)) {
            return response()->json(['message' => 'Achievement already unlocked']);
        }

        // Assuming you have a method to unlock the achievement for the user
        $user->unlockAchievement($achievementName);

        // Dispatch the AchievementUnlocked event
        event(new \App\Events\AchievementUnlocked($user, $achievementName));

        return response()->json(['message' => 'Achievement unlocked']);
    }

    public function getUserAchievements(User $user)
    {
        $unlockedAchievements = $user->achievements->pluck('name')->all();
        
        $nextAvailableAchievements = Achievement::whereNotIn('name', $unlockedAchievements)
            ->orderBy('order_column')
            ->pluck('name')
            ->all();

        $currentBadge = $user->getCurrentBadgeName();
        $nextBadge = $user->getNextBadgeName();
        $remainingToUnlockNextBadge = $user->getRemainingAchievementsForNextBadge();

        return response()->json([
            'unlocked_achievements' => $unlockedAchievements,
            'next_available_achievements' => $nextAvailableAchievements,
            'current_badge' => $currentBadge,
            'next_badge' => $nextBadge,
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge,
        ]);
    }

}
