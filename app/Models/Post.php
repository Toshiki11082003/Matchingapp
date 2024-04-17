<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon; // Carbonをインポート

class Post extends Model
{
    use HasFactory;
    
    // Mass Assignmentの対象となる属性
    protected $fillable = ['title', 'body', 'deadline'];

    // ユーザーとのリレーションを定義
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
