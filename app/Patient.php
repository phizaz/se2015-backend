<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class Patient extends Model implements  AuthenticatableContract,
                                        AuthorizableContract,
                                        CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    
    protected $table = 'patients';
    protected $fillable = ['personal_id', 'password'];
//    protected $fillable = ['firstname', 'lastname', 'personal_id', 
//                           'password','religion','address','birthdate',
//                           'status','gender','nationality','bloodtype',
//                           'remark','priority'];
//    
    public function getAuthPassword() {
        return $this->password;
    }

    protected $hidden = ['password', 'remember_token'];
}
