<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use App\Transformers\UserTransformer;
use Laravel\Passport\HasApiTokens;


class User extends Authenticatable
{   
    use HasApiTokens,Notifiable,SoftDeletes;

    const VERIFIED_USER = '1';
    const UNVERIFIED_USER = '0';

    const ADMIN_USER = 'true';
    const REGULAR_USER = 'false';

    protected $dates = ['deleted_at'];
    protected $table='users';

    public $transformer = UserTransformer::class;




    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','verified','verification_token','admin',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setNameAttribute($name){
        $this->attributes['name'] = strtolower($name);
    }

    public function getNameAttribute($name){

        return ucwords($name);
    }

    public function setEmailAttribute($email){

        $this->attributes['email'] = strtolower($email);
    
    }

    public function isVerified(){
        return $this->verified == USER::VERIFIED_USER;
    }

    public function isAdmin(){
        return $this->admin == USER::ADMIN_USER;
    }

    public static function generateVerificationCode(){
        return str::random(40);
    }
}
