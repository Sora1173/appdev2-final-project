<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atmosphere extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users() {
        return $this->belongsToMany(User::class, 'atmosphere_users')
        ->withTimestamps()
        ->withPivot('joined_at');
    }

    public function questions() {
        return $this->belongsToMany(Question::class, 'atmosphere_questions')
        ->withTimestamps();
    }
}
