<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobile_notification extends Model
{
    use HasFactory;
    protected $table = 'mobile_notification';
    protected $fillable = [
        'notification_type',
        'post_id',
        'notification_from_user',
        'seen_notification',
        'comment_id',
        'user_post',
    ];
}
