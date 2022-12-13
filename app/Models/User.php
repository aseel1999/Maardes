<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;



class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable=['email','password'];


   

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'service'=>'array',
        
    ];
    public function getImageAttribute($value)
    {
        if (!is_null($value) && isset($value) && $value!=''){
            return url('public/images/' . $value) ;
        }else{
            return url('public/images/avt.png');
        }
    }
    public function getImageProfileAttribute($value)
    {
        if ($value) {
            if (filter_var($value, FILTER_VALIDATE_URL) === FALSE) {
                return url('public/images/' . $value);
            } else {
                return $value;
            }
        } else {
            return url('public/images/avt.png');
        }
    }
    public function package()
    {
        return $this->hasOne(Package::class);
    }
    public function location_maared(){
        return $this->hasOne(Location_Maared::class);
    }
    public function company(){
        return $this->hasOne(Company::class);
    }
    public function profile(){
        return $this->hasOne(Profile::class);
    }
    
    public function scopeFilter($query)
    {
    if (request()->has('email')) {
        if (request()->get('email') != null)
            $query->where('email', 'like', '%' . request()->get('email') . '%');
    }
    if (request()->has('name')) {
        if (request()->get('name') != null)
            $query->whereTranslationLike('name','%' . request()->get('name') . '%');
    }
    if (request()->has('mobile')) {
        if (request()->get('mobile') != null)
            $query->where('mobile', 'like', '%' . request()->get('mobile') . '%');
    }
    if (request()->has('id')) {
        if (request()->get('id') != null)
            $query->where('id', request()->get('id'));
    }

}
}