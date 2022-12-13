<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class About extends Model
{
    use HasFactory,Translatable;
    public $translatedAttributes = ['name','description','date'];
    protected $fillable = ['name','image','date'];
}
