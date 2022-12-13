<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;
    public $table = 'tokens'; 

	  protected $fillable = ['user_id','device_type','fcm_token','accept' , 'lang'];
	  protected $hidden = ['updated_at','deleted_at'];

}
