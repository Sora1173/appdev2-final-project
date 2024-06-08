<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Atmosphere extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'creator_id'];

    public function users() {
        return $this->belongsToMany(User::class, 'atmosphere_users')
        ->withPivot('joined_at')
        ->withTimestamps();
    }

    public function questions() {
        return $this->belongsToMany(Question::class)
        ->withPivot('created_by')
        ->withTimestamps();
    }

    public function creator() {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
