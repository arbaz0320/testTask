<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * The comments that belong to the user.
     */

     public function achievements()
        {
            return $this->belongsToMany(Achievement::class, 'achievement_user', 'user_id', 'achievement_id');
        }        

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * The lessons that a user has access to.
     */
    public function lessons()
    {
        return $this->belongsToMany(Lesson::class);
    }

    /**
     * The lessons that a user has watched.
     */
    public function watched()
    {
        return $this->belongsToMany(Lesson::class)->wherePivot('watched', true);
    }


    public function unlockAchievement($name)
        {
            $achievement = Achievement::where('name', $name)->firstOrFail();
            $this->achievements()->attach($achievement);
        }

        public function hasAchievement($name)
        {
            return $this->achievements->contains('name', $name);
        }

        public function unlockBadge($name)
        {
            $badge = Badge::where('name', $name)->firstOrFail();
            $this->badges()->attach($badge);
        }

        public function hasBadge($name)
        {
            return $this->badges->contains('name', $name);
        }

        public function achievementCount()
        {
            return $this->achievements->count();
        }


}

