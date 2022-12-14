<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location_Maared extends Model
{
    use HasFactory;
<<<<<<< HEAD
    protected $table = 'location_maarads';
    // protected $table='location__maareds';
=======
    protected $table='location_maarads';
>>>>>>> 82481533682ebbb96da8172dca8220239d1592e8
    protected $fillable = ['name','area','description','imagemarad'];
    public function user(){
        return $this->belongsTo(User::class);
    }



}
