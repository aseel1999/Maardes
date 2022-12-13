<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Language extends Model
{
    use HasFactory,Translatable;
    public $translatedAttributes = ['name'];
    protected $fillable = ['lang'];
}
