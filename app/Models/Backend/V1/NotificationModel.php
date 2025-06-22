<?php

namespace App\Models\Backend\V1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationModel extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'user_id',
        'url',
        'message',
        'is_read',
    ];

    public static function sendNotification($user_id, $url, $message)
{
    $save = new NotificationModel();
    $save->user_id = $user_id;
    $save->url = $url;
    $save->message = $message;
    $save->save();
}

public static function getUnreadNotification()
{
    return NotificationModel::where('user_id', 1)
        ->where('is_read', 0)
        ->orderBy('id', 'desc')
        ->get();


}

public static function unreadNotificationsCount()
{
    return NotificationModel::where('user_id', 1)
        ->where('is_read', 0)
        ->count();
}

public static function getRecord()
{
    return NotificationModel::where('user_id', 1)
        ->orderBy('id', 'desc')
        ->paginate(30);
}

public static function getRecordUser($user_id)
{
    return NotificationModel::where('user_id', $user_id)
        ->orderBy('id', 'desc')
        ->paginate(30); 
}

}
