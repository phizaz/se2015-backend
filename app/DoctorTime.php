<?php
//namespace App\Http\Controllers;
namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorTime extends Model
{
    protected $table = 'DoctorTime';
    protected $fillable = ['doctor_id', 'doctorTime_begin','doctorTime_end'];
    
    public static function getByDoctor($doctor_id) {
        $doctorTime[] = DoctorTime::where('doctor_id',$doctor_id)->get();
        return $doctorTime;
    }
    
    public static function editDoctorTime() {
        
        
    }
    
    public static function makeDoctorTime() {
        
        
    }
    
    public static function getFreeSlotByDoctor($doctor_id) {
        $doctorTime[] = DoctorTime::where('doctor_id',$doctor_id)->get();
        return $doctorTime;
    }
    
    public static function getFreeSlotBySpecialty($specialty) {
        $doctorTime[] = DoctorTime::where('specialty',$specialty)->get();
        return $doctorTime;
    }
    
}
