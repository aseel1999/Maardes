<?php

namespace App\Models;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    
    protected $fillable = ['user_id','name','image'];
    
    public function works()
    {
        return $this->hasMany(Location_Work::class);
    }
    public function packages()
    {
        return $this->hasMany(Package::class);
    }
    public function location_works()
    {
        return $this->hasMany(Location_Work::class);
    }
    public function ticket(){
        return $this->belongsTo(Ticket::class);
    }
    public function user(){
        return $this->hasOne(User::class);
    }

}
