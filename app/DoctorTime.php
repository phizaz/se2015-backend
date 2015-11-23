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

    //------------------getDoctorTimeByDoctor----------------------------
    public static function getByDoctor($doctor_id) {
        $doctorTime = DoctorTime::where('doctor_id',$doctor_id)->get();
        return ["success"=>true, "data" =>$doctorTime];
    }

    //-----------------getDoctorTimeBySpecialty-------------------------
    public static function getByspecialty($specialty) {
        $doctorTime[] = DoctorTime::where('specialty',$specialty)->get();
        return ["success"=>true, "data" =>$doctorTime];
    }

    //not finish
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

        return  ["success"=>true, "data" =>array($doctorTime)];
    }


    //----------------------------------makeDoctorTime---------------------------------
    public static function makeDoctorTime( $doctor_id, Datetime $doctorTime_begin,
                                            Datetime $doctorTime_end ) {
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
        $doctorTime = new DoctorTime();
        $doctorTime->doctor_id = $doctor_id;
        $doctorTime->doctorTime_begin = $doctorTime_begin;
        $doctorTime->doctorTime_end = $doctorTime_end;
        $doctorTime->save();
        return  ["success"=>true, "data" =>array($doctorTime)];
    }

    //---------------------------getFreeSlotByDoctor-----------------------------
    public static function getFreeSlotByDoctor( $doctor_id ) {

        $freeSlot = [];
        $doctorTimes = DoctorTime::where('doctor_id', $doctor_id)->get();

        foreach($doctorTimes as $doctorTime) {
            $count = 0;
            $begin = new Datetime($doctorTime->doctorTime_begin);
            $end = new DateTime($doctorTime->doctorTime_end);

            if ( $begin->format("s") =='00' )
                $begin->add( new DateInterval('PT0H0M1S'));

            while($begin < $end) {
                if(Appointment::where('time',$begin)->
                                where('emp_id',$doctorTime->doctor_id)->first() ){
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

        return ["datetime" => $freeSlot,
                "doctor" => HospitalEmployee::where('emp_id',$doctor_id)->first()
               ];
    }

    //---------------------------getFreeSlotBySpecialty-----------------------------
    public static function getFreeSlotBySpecialty( $specialty ) {
        $doctors = HospitalEmployee::where('role','Doctor')->
                                     where('specialty',$specialty)->get();
        $result = [];
        foreach ($doctors as $doctor) {
            $doctor_id = $doctor->emp_id;
            $result[] = ["datetime" => DoctorTIme::getFreeSlotByDoctor($doctor_id),
                         "doctor" => $doctor
                        ];
        }
        return $result;
    }
    //not finish
    //----------------------------refreshDoctorTime-------------------------------
    public static function refreshDoctorTime($doctor_id) {
        $appointments = Appointment::where('emp_id',$doctor_id)->get();
        $doctorTimes = DoctorTime::where('doctor_id',$doctor_id)->get();
        foreach($appointments as $appointment) {
            $aptime = new DateTime($appointment->time);
            $del = true;
            foreach($doctorTimes as $doctorTime) {
                $begin = new DateTime($doctorTime->doctorTime_begin);
                $end = new DateTime($doctorTime->doctorTime_end);

                if($aptime >= $begin && $aptime < $end) {
                    $del = false;
                }
            }
            if($del)
                Appointment::deleteAppointment($appointment->appointment_id);
        }
        $docTime = DoctorTime::orderBy('doctorTime_begin','asc')->where('doctor_id',$doctor_id)->get();
        return ["success" => true,"new doctorTime" => $docTime];
    }

}
