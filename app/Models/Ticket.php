<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = ['name','date'];
    protected $casts=['date'=>'date'];
    public function company()
    {
        return $this->hasOne(Company::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    

}
