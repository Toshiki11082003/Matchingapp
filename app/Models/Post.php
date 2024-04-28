<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Carbonをインポート

class Post extends Model
{
    use HasFactory;
    
    // Mass Assignmentの対象となる属性
    protected $fillable = [
    'title', 'university_name', 'circle_name', 'circle_type',
    'event_date', 'event_location', 'deadline', 'free_text', //'cost'
    ];


    // 日付として扱う属性
    protected $dates = [
        'deadline', 'event_date'
    ];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}