<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'answered_by',
        'question_id',
        'answer_content',
        'rating'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'answered_by');
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
