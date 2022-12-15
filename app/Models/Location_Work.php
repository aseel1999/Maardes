<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
class Location_Work extends Model
{
    use HasFactory;
    protected $table='location_works';
    
    protected $fillable = ['location','area'];
    public function company(){
        return $this->belongsTo(Company::class);
    }
}
