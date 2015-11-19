<?php
//namespace App\Http\Controllers;
namespace App;

use Illuminate\Database\Eloquent\Model;
use DateInterval;
class DoctorTime extends Model
{
    protected $table = 'DoctorTime';
    protected $fillable = ['doctor_id', 'doctorTime_begin','doctorTime_end'];
    
    public static function getByDoctor($doctor_id) {
        $doctorTime[] = DoctorTime::where('doctor_id',$doctor_id)->get();
        return $doctorTime;
    }

    public static function getByspecialty($specialty) {
        $doctorTime[] = DoctorTime::where('specialty',$specialty);
        return $doctorTime;
    }
    
    
    public static function editDoctorTime() {
        
        
    }


    //not complete
    public static function makeDoctorTime( $doctorTime_begin, $doctorTime_end ) {
        
        //เช็คความถูกต้องของ Input--------------------------------------------------vv
        if( doctorTime_begin == null )
            return response()->json(["success" => false,
                                     "message" => 'doctorTime_begin_not_found'
                                    ]);
        if( doctorTime_end == null )
            return response()->json(["success" => false,
                                     "message" => 'doctorTime_end_not_found'
                                    ]);
        if( $doctorTime_end > $doctorTime_begin )
            return response()->json(["success" => false,
                                     "message" => 'wrong_time_space'
                                    ]);
        //----------------------------------------------------------------------^^

        $doctorTime[] = new DoctorTime();
        $begin = $doctorTime_begin;

        //ถ้าเวลาที่ส่งมามีหลักวินาทีเป็น 00s ให้บวกไป 1วิ กลายเป็น 01s Ex 12:15:01 ----vv
        if ( $begin->format("s")=='00' )
            $begin->add( new DateInterval('PT0H0M1S'));
        //--------------------------------------------------------------------^^


        //ใส่DoctorTime ทีละอัน แต่ละอันห่างกัน 15นาที -----------------------------------------------vv
        while ( $begin < $doctorTime_end ) {
            makeOneDoctorTime( $doctorTime[], $begin,$begin->add( new DateInterval( 'PT0H14M59S' )));
            $begin->add( new DateInterval( 'PT0H0M1S' ));
        }
        //---------------------------------------------------------------------------------------^^

        $doctorTime->save();
    }

    public static function makeOneDoctorTime( DoctorTime $doctorTime, $begin, $end ) {
        $doctorTime->doctorTime_begin = $begin;
        $doctorTime->doctorTime_end = $end;
    }
    
    public static function getFreeSlotByDoctor( $doctor_id ) {
        $doctorTime[] = DoctorTime::where( 'doctor_id', $doctor_id )->get();
        return $doctorTime;
    }
    
    public static function getFreeSlotBySpecialty( $specialty ) {
        $doctorTime[] = DoctorTime::where( 'specialty', $specialty )->get();
        return $doctorTime;
    }
    
}
