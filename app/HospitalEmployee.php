<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class HospitalEmployee extends Model
{
	protected $table = 'hospital_employees';

  protected $primaryKey = 'emp_id';

  // config the toArray return types
  protected $casts = [
    'valid' => 'boolean',
  ];

  public function user() {
    return $this->morphOne('App\User', 'userable');
  }

  /**
   * Override the toArray function to append 'username' (which belongs to App\User) to it
   * @return [type] [description]
   */
  public function toArray() {
    $original = Parent::toArray($this);
    $new = array_merge($original, [
      'username' => $this->user->username,
      ]);

    return $new;
  }

  public static function create(array $attributes = []) {
    $employee = new HospitalEmployee;
    $employee->firstname = $attributes['firstname'];
    $employee->lastname = $attributes['lastname'];
    $employee->tel = $attributes['tel'];
    $employee->email = $attributes['email'];
    $employee->role = $attributes['role'];

    if ($attributes['role'] == 'Doctor') {
      $employee->specialty = $attributes['specialty'];
    }

    $employee->valid = false;
    $employee->save();

    // this will also create the User for authentication
    $user = new User;
    // duplicate personal id to username
    $user->username = $attributes['username'];
    $user->password = Hash::make($attributes['password']);
    $user->userable_id = $employee->emp_id;
    $user->userable_type = 'App\HospitalEmployee';
    $user->save();

    return $employee;
  }



}
