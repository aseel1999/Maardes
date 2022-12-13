<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Post extends Model
{
    use HasFactory,Translatable;
    public $translatedAttributes = ['name','bio'];
    protected $fillable = ['name','bio','image'];
    protected $hidden = ['translations'];
}
