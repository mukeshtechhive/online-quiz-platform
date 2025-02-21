<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'description',
        'duration',
    ];

    // Define relationships
    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
