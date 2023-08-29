<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationObject extends Model
{
    use HasFactory;

    public function getComment()
    {
        return $this->belongsToMany(Comment::class, 'comment_notification_objects', 'id_noti_object', 'id_comment');
    }

     public function getDonate()
    {
        return $this->belongsToMany(Donate::class, 'donate_notification_objects', 'id_noti_object', 'id_donate');
    }

     public function getTransition()
    {
        return $this->belongsToMany(TransitionHistory::class, 'load_cent_notification_objects', 'id_noti_object', 'id_transition');
    }

}
