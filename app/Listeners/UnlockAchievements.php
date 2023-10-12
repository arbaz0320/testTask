<?php
namespace App\Listeners;
use App\Events\CommentWritten;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\LessonWatched;
use App\Models\Achievement;

class UnlockAchievements
{
    public function handle($event)
    {
        $user = $event->user;

        if ($event instanceof LessonWatched) {
            // Check if the user has watched a lesson
            if (!$user->hasAchievement('First Lesson Watched')) {
                $user->unlockAchievement('First Lesson Watched');
            } elseif ($user->lessonWatchCount() >= 5 && !$user->hasAchievement('5 Lessons Watched')) {
                $user->unlockAchievement('5 Lessons Watched');
            }
        } elseif ($event instanceof CommentWritten) {
            // Check if the user has written a comment
            if (!$user->hasAchievement('First Comment Written')) {
                $user->unlockAchievement('First Comment Written');
            }
        }
    }
}
