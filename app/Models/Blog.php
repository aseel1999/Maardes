<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
class Blog extends Model
{
    use HasFactory,Translatable;
    public $translatedAttributes = ['name_maraad','date'];
    protected $fillable = ['name_maraad'];
    

}
