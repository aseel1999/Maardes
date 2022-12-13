<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
class Location_Work extends Model
{
    use HasFactory,Translatable;
    public $translatedAttributes = ['location','area'];
    protected $fillable = ['location','area'];
    protected $hidden = ['translations'];
}
