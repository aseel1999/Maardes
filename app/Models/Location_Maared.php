<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location_Maared extends Model
{
    use HasFactory;
    protected $fillable = ['name','area','description','imagemarad'];
    public function user(){
        return $this->belongsTo(User::class);
    }
}
