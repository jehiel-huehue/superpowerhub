<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;


use Illuminate\Database\Eloquent\Model;

class Superpower extends Model
{
    use HasFactory;

    // Define the fields that can be mass-assigned
    protected $fillable = [
        'superpower',
        'description',
        'strength',
        'weakness',
        'user_id',
    ];

    // Define relationship with User (if needed later)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function trainings()
    {
        return $this->hasMany(Training::class);
    }
}