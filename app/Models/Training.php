<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'superpower_id',
        'title',
        'description',
        'level',
        'max_level',
        'trainings_per_day'
    ];

    public function superpower()
    {
        return $this->belongsTo(Superpower::class);
    }

    public function logs()
    {
        return $this->hasMany(TrainingLog::class);
    }
}