<?php
//namespace App\Http\Controllers;
namespace App;
use Datetime;
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
        $doctorTime[] = DoctorTime::where('specialty',$specialty)->get();
        return $doctorTime;
    }
    
    
    public static function editDoctorTime() {
        
    
    }


    //not complete
    public static function makeDoctorTime( $doctor_id, Datetime $doctorTime_begin, Datetime $doctorTime_end ) {
        $result = [];
        //เช็คความถูกต้องของ Input--------------------------------------------------vv
        // if( $doctorTime_begin == null )
        //     return response()->json(["success" => false,
        //                              "message" => 'doctorTime_begin_not_found'
        //                             ]);
        // if( $doctorTime_end == null )
        //     return response()->json(["success" => false,
        //                              "message" => 'doctorTime_end_not_found'
        //                             ]);
        // if( $doctorTime_end > $doctorTime_begin )
        //     return response()->json(["success" => false,
        //                              "message" => 'wrong_time_space'
        //                             ]);
        //----------------------------------------------------------------------^^
        
        //$doctorTime[] = new DoctorTime();
        $begin = $doctorTime_begin;
        //ถ้าเวลาที่ส่งมามีหลักวินาทีเป็น 00s ให้บวกไป 1วิ กลายเป็น 01s Ex 12:15:01 ----vv
        if ( $begin->format("s") =='00' )
            $begin->add( new DateInterval('PT0H0M1S'));
        $end = new Datetime($begin->format("y-m-d h:i:s"));
        $end->add(new DateInterval('PT0H14M59S'));
        //--------------------------------------------------------------------^^
        // echo $begin->format("h:i:s")."<br>";
        // echo $end->format("h:i:s");
        //ใส่DoctorTime ทีละอัน แต่ละอันห่างกัน 15นาที -----------------------------------------------vv
        while ( $begin < $doctorTime_end ) {
            //echo $begin->format("h:i:s").'<br>';
            $result[] = DoctorTime::makeOneDoctorTime( $doctor_id, $begin,$end);
            $begin->add( new DateInterval( 'PT0H15M00S' ));
            $end->add( new DateInterval( 'PT0H15M00S' ));
        }
        //---------------------------------------------------------------------------------------^^
        return $result;
    }

    public static function makeOneDoctorTime( $doctor_id, Datetime $begin, Datetime $end ) {
        $doctorTime = new DoctorTime();
        $doctorTime->doctor_id = $doctor_id;
        $doctorTime->doctorTime_begin = $begin;
        $doctorTime->doctorTime_end = $end;
        if(DoctorTime::where('doctorTime_begin',$begin)->first()==null)
            $doctorTime->save();
        return array($doctorTime);
    }

    

    public static function getFreeSlotByDoctor( $doctor_id ) {
        $freeSlot = [];
        $doctorTimes = DoctorTime::where( 'doctor_id', $doctor_id )->get();
        foreach($doctorTimes as $doctorTime) {
            $appointment = null;
            $appointment = Appointment::where('emp_id',$doctorTime->doctor_id)->where('time'
                                        ,$doctorTime->doctorTime_begin)->first();
            
            if($appointment == null) 
                $freeSlot[] = $doctorTime->doctorTime_begin;
        }
        return ["data" => $freeSlot];
    }

    
    public static function getFreeSlotBySpecialty( $specialty ) {
        $freeSlot = [];
        $doctors = HospitalEmployee::where('specialty',$specialty)->get();
        //echo $doctors;
        foreach ($doctors as $doctor) {
            $doctorTime = null;
            $doctor_id = $doctor->emp_id;
            //$freeSlot[] = DoctorTime::getFreeSlotByDoctor($doctor_id);
            $doctorTimes = DoctorTime::where( 'doctor_id', $doctor_id )->get();
            if(sizeof($doctorTimes)>0)
                $freeSlot[] = $doctor_id;
            foreach($doctorTimes as $doctorTime) {
                $appointment = null;
                $appointment = Appointment::where('emp_id',$doctorTime->doctor_id)->where('time'
                                                     ,$doctorTime->doctorTime_begin)->first();
            
                if($appointment==null) 
                    $freeSlot[] = $doctorTime->doctorTime_begin;
            }
        }
        return ["data" => $freeSlot];
    }
    
}
