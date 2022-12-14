<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    public $translatedAttributes = ['name'];
    protected $fillable = ['name'];
    protected $hidden=['translations'];
    public function events(){
        return $this->hasMany(Event::class);
    }
}
