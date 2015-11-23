<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements  AuthenticatableContract,
                                        AuthorizableContract,
                                        CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

    protected $table = 'users';
    protected $hidden = ['password', 'remember_token'];

    public function userable() {
      return $this->morphTo();
    }

    public static function getUserAppointment(User $user) {
    	if($user->userable->role == 'Doctor') 
            $appointments = Appointment::getAppointmentDoctor($user->userable->emp_id);
        else if($user->userable->role == null) 
            $appointments = Appointment::getAppointmentPatient($user->userable->id);
        else
        	$appointments = null;
        return  $appointments;
    }
}
