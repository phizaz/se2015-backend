<?php
//namespace App\Http\Controllers;
namespace App;
use Datetime;
use Illuminate\Database\Eloquent\Model;
use DateInterval;
use DB;
class DoctorTime extends Model
{
    protected $table = 'DoctorTime';
    protected $primaryKey = 'doctorTime_id';
    protected $fillable = ['doctor_id', 'doctorTime_begin','doctorTime_end'];
    
    public static function getByDoctor($doctor_id) {
        $doctorTime[] = DoctorTime::where('doctor_id',$doctor_id)->get();
        return $doctorTime;
    }

    public static function getByspecialty($specialty) {
        $doctorTime[] = DoctorTime::where('specialty',$specialty)->get();
        return $doctorTime;
    }
    
    
    public static function editDoctorTime($doctorTime_id, DateTime $newDoctorTime_begin, 
                                            DateTime $newDoctorTime_end) {
        echo 'dsdfd';
        $doctorTime = DoctorTime::where('doctorTime_id',$doctorTime_id)->first();
        $doctorTime->doctorTime_begin = $newDoctorTime_begin;
        $doctorTime->doctorTime_end = $newDoctorTime_end;
        //$doctorTime->doctor_id = $doctor_id;
        $doctorTime->save();
        // $doctorTime->update(array('doctorTime_begin' => $newDoctorTime_begin,
          //                         'doctorTime_end' => $newDoctorTime_end));
        // DB::table('DoctorTime')->where('doctorTime_id',$doctorTime_id)->update(array('doctorTime_begin' => $newDoctorTime_begin,
        //                           'doctorTime_end' => $newDoctorTime_end));

        return array($doctorTime);
    }


    //not complete
    public static function makeDoctorTime( $doctor_id, Datetime $doctorTime_begin, Datetime $doctorTime_end ) {
        //เช็คความถูกต้องของ Input--------------------------------------------------vv
        if( $doctorTime_begin == null )
            return ["success" => false,
                                     "message" => 'doctorTime_begin_not_found'
                                    ];
        if( $doctorTime_end == null )
            return ["success" => false,
                                     "message" => 'doctorTime_end_not_found'
                                    ];
        if( $doctorTime_end < $doctorTime_begin )
            return ["success" => false,
                                     "message" => 'wrong_time_space'
                                    ];
        //----------------------------------------------------------------------^^
    
        //------------------------------------------------------------------------------------------
        // $result = [];
        // $begin = $doctorTime_begin;
        // //ถ้าเวลาที่ส่งมามีหลักวินาทีเป็น 00s ให้บวกไป 1วิ กลายเป็น 01s Ex 12:15:01 ----vv
        // if ( $begin->format("s") =='00' )
        //     $begin->add( new DateInterval('PT0H0M1S'));
        // $end = new Datetime($begin->format("y-m-d h:i:s"));
        // $end->add(new DateInterval('PT0H14M59S'));
        // //--------------------------------------------------------------------^^
        // //ใส่DoctorTime ทีละอัน แต่ละอันห่างกัน 15นาที -----------------------------------------------vv
        // while ( $begin < $doctorTime_end ) {
        //     $result[] = DoctorTime::makeOneDoctorTime( $doctor_id, $begin,$end);
        //     $begin->add( new DateInterval( 'PT0H15M00S' ));
        //     $end->add( new DateInterval( 'PT0H15M00S' ));
        // }
        //---------------------------------------------------------------------------------------^^
        $doctorTime = new DoctorTime();
        $doctorTime->doctor_id = $doctor_id; 
        $doctorTime->doctorTime_begin = $doctorTime_begin;
        $doctorTime->doctorTime_end = $doctorTime_end;
        $doctorTime->save();
        return array($doctorTime);
    }

    // public static function makeOneDoctorTime( $doctor_id, Datetime $begin, Datetime $end ) {
    //     $doctorTime = new DoctorTime();
    //     $doctorTime->doctor_id = $doctor_id;
    //     $doctorTime->doctorTime_begin = $begin;
    //     $doctorTime->doctorTime_end = $end;
    //     if(DoctorTime::where('doctorTime_begin',$begin)->first()==null)
    //         $doctorTime->save();
    //     return array($doctorTime);
    // }

    public static function getFreeSlotByDoctor( $doctor_id ) {
        // $freeSlot = [];
        // $doctorTimes = DoctorTime::where( 'doctor_id', $doctor_id )->get();
        // foreach($doctorTimes as $doctorTime) {
        //     $appointment = null;
        //     $appointment = Appointment::where('emp_id',$doctorTime->doctor_id)->where('time'
        //                                 ,$doctorTime->doctorTime_begin)->first();
            
        //     if($appointment == null) 
        //         $freeSlot[] = $doctorTime->doctorTime_begin;
        // }
        // return ["data" => $freeSlot];
        $freeSlot = [];
        $doctorTimes = DoctorTime::where('doctor_id', $doctor_id)->get();

        foreach($doctorTimes as $doctorTime) {
            // echo 'for';
            $count = 0;
            $begin = new Datetime($doctorTime->doctorTime_begin);
            $end = new DateTime($doctorTime->doctorTime_end);
            // echo $begin->format("h:i:s").'<br>';
            // echo $end->format("h:i:s");
            if ( $begin->format("s") =='00' )
                $begin->add( new DateInterval('PT0H0M1S'));
            while($begin < $end) {
                // echo "before if";
                //echo $begin->format("h:i:s").'<br>';
                if(Appointment::where('time',$begin)->
                                where('emp_id',$doctorTime->doctor_id)->first() ){
                    //echo 'jer<br>';
                    if($count == 1) {
                        $count = 0;
                        $endFree = new DateTime($begin->format("y-m-d H:i:s"));
                        $endFree->sub( new DateInterval('PT0H0M1S'));
                        $freeSlot[] = ["doctorTime_end" => new DateTime($endFree->format("y-m-d H:i:s"))];
                    }
                }
                else if($count == 0){
                    $freeSlot[] = ["doctorTime_begin" => new DateTime($begin->format("y-m-d H:i:s"))]; 
                    $count = 1;
                }
                $begin->add( new DateInterval('PT0H15M00S'));
            }
            if($count == 1) {
                $freeSlot[] = ["doctorTime_end" => new DateTime($end->format("y-m-d H:i:s"))];
                $count = 0;
            }
        }
        // $freeSlot[] = ["begin" => $doctorTimes->doctorTime_begin];
        // $freeSlot[] = ["end" => $doctorTimes->doctorTime_end]; 
        return $freeSlot;
    }

    
    public static function getFreeSlotBySpecialty( $specialty ) {
        $doctors = HospitalEmployee::where('role','Doctor')->
                                     where('specialty',$specialty)->get();
        $result = [];
        foreach ($doctors as $doctor) {
            $doctor_id = $doctor->emp_id;
            $result[] = ["doctor_id" => $doctor_id];
            $result[] = DoctorTIme::getFreeSlotByDoctor($doctor_id);
        }
        // $freeSlot[] = ["begin" => $doctorTimes->doctorTime_begin];
        // $freeSlot[] = ["end" => $doctorTimes->doctorTime_end]; 
        return $result;
    }

    public static function refreshDoctorTime($doctor_id) {
        $appointments = Appointment::where('emp_id',$doctor_id)->get();
        $doctorTimes = DoctorTime::where('doctor_id',$doctor_id)->get();
        foreach($appointments as $appointment) {
            foreach($doctorTimes as $doctorTime) {
                //ถ้า appointment และ doctorTime อยู่ในวันเดียวกัน
                if(($appoinment->time)->format("y-m-d") == ($doctorTime->doctorTime_begin)->format("y-m-d")) {
                    if(Datetime($appointment)->time < Datetime($doctorTime->doctorTime_begin) || 
                        Datetime($appointment)->time > Datetime($doctorTime_end)) {
                        Appointment::deleteAppointment($appontment->appointment_id);
                    }
                }
            }
        }
        return ["success" => true];
    }
    
}
