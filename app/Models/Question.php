<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Answer;


class Question extends Model
{
    use HasFactory;
    
    protected $primaryKey = 'id';
    protected $fillable = [
        'title'
    ];

    public function answers(){
        return $this->hasMany(Answer::class)->inRandomOrder();
    }

    public function correctAnswer(){
        return $this->answers()->where('is_correct', true)->first();
    }

    public function incorrectAnswers(){
        return $this->answers->where('is_correct', false);
    }

}
