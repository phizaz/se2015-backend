<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;
//kuy kuy
class HospitalEmployee extends Model implements  AuthenticatableContract,
                                        AuthorizableContract,
                                        CanResetPasswordContract
{

	use Authenticatable, Authorizable, CanResetPassword;
	protected $table = 'hospital_employees';
    protected $fillable = ['username', 'password'];


   	protected $hidden = ['password', 'remember_token'];

}
