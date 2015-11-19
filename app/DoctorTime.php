<?php
//namespace App\Http\Controllers;
namespace App;

use Illuminate\Database\Eloquent\Model;

class DoctorTime extends Model
{
    protected $table = 'DoctorTime';
    protected $fillable = ['doctor_id', 'doctorTime_begin','doctorTime_end'];
    
    public function getByDoctor(Request $request) {
        $doctor_id = $request->input('doctor_id');
        return response()->json(DoctorTime::where('doctor_id',$doctor_id));
    }
    
}
