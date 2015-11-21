<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HospitalEmployee extends Model
{
    
    protected $fillable = ['username', 'password'];


    protected $hidden = ['password', 'remember_token'];
}
