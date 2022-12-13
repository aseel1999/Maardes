<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{

    use HasFactory;
    
    protected $fillable = ['nameofquestion','answer'];
    protected $casts=['answer'=>'array'];
}
