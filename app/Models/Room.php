<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;
    
    protected $table = 'chats';

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'room_user', 'chat_id', 'user_id');
    }

    /**
     * チャットのゲストユーザーを取得する。
     */
    public function guest()
    {
        return $this->belongsTo(User::class, 'guest_id');
    }
}
