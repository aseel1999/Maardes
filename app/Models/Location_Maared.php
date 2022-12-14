<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location_Maared extends Model
{
    use HasFactory;
    protected $table = 'location_maarads';
    // protected $table='location__maareds';
    protected $fillable = ['name','area','description','imagemarad'];
    public function user(){
        return $this->belongsTo(User::class);
    }



}
