<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['content'];

    public function atmospheres()
    {
        return $this->belongsToMany(Atmosphere::class)
                    ->withPivot('created_by')
                    ->withTimestamps();
    }

    public function answers() {
        return $this->hasMany(Answer::class);
    }
}
