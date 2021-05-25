<?php

namespace App\Models;
// use App\Observers\PostObserver;

// use Notification;
// use App\Notifications\NewTrendingPostNotification;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    use HasFactory, Notifiable;
    
    protected $fillable = [
        'title',
        'description',
        'anonymous',
        'upvote_count',
        'downvote_count',
        'status',
        'user_id', 
    ];

    // public static function boot()
    // {
    //     // parent::boot();
    //     // self::observe(new PostObserver);
    //     parent::boot();
    //     static::updated(function($post) {
    //         if ($post->upvote_count == 3) {
    //             //event(new UserVerified($user));
    //             auth()->user()->notify(new NewTrendingPostNotification($post));
    //         }
    //     });
    //     }
}
