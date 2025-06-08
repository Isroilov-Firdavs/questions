<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestSession extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'started_at', 'finished_at'];

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }

}
