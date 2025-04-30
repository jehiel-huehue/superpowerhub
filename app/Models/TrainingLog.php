<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TrainingLog extends Model
{

    use HasFactory;

    protected $fillable = [
        'training_id',
        'user_id',
        'previous_level',
        'new_level',
        'trained_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function training()
    {
        return $this->belongsTo(Training::class);
    }
}
