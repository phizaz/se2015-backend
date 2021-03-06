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
    public static function editDoctorTime($doctorTime_id, DateTime $newDoctorTime_begin, DateTime $newDoctorTime_end) {
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

    public static function timeToBlock($datetime) {
        $beginHours = 8;

        $future_hour = intval($datetime->format('H'));
        // echo 'future_hour', $future_hour, "\n";
        $future_minute = intval($datetime->format('i'));
        // echo 'future_minute', $future_minute, "\n";

        $future = (new DateTime())->setTime($future_hour, $future_minute);

        $begin = (new DateTime())->setTime($beginHours, 0);

        $diff = $future->diff($begin);
        // echo "\n", 'diff:', $diff->i;
        $diffMinutes = $diff->h * 60 + $diff->i;
        return $diffMinutes / 15;
    }

    public static function blockToTime($block, $baseDate = NULL) {
        $beginHours = 8;

        $hoursPassed = $block / 4;
        $minutesPassed = ($block % 4) * 15;

        if ($baseDate == NULL) {
            $baseDate = new DateTime();
        }

        return $baseDate->setTime($beginHours + $hoursPassed, $minutesPassed);
    }

    //---------------------------getFreeSlotByDoctor-----------------------------
    public static function getFreeSlotByDoctor( $doctor_id ) {
        $doctorTimes =
            DoctorTime::where('doctor_id', $doctor_id)
                ->where('doctorTime_end', '>=', new DateTime())
                ->get();
        // echo "doctortimes: \n";
        // var_dump($doctorTimes->toArray());

        $appointments =
            Appointment::where('time', '>=', new DateTime())->get();

        // echo "appointmnets: \n";
        // var_dump($appointments->toArray());

        $freeSlots = [];

        // cerate doctortimes slots
        foreach($doctorTimes as $doctorTime) {
            $beginTime = $doctorTime->doctorTime_begin;
            $endTime = $doctorTime->doctorTime_end;

            $datetime = $beginTime;
            $date = (new DateTime($datetime))->format('Y-m-d');
            $freeSlots[$date] = array_fill(0, (20 - 8) * 4, false);

            $beginBlock = DoctorTime::timeToBlock(new DateTime($beginTime));
            $endBlock = DoctorTime::timeToBlock(new DateTime($endTime));

            // echo 'beginblock:', $beginBlock, 'endblock:', $endBlock, "\n";

            // set as free
            for ($i = $beginBlock; $i < $endBlock; ++$i) {
                $freeSlots[$date][$i] = true;
            }
        }

        // echo "freeslots: \n";
        // var_dump($freeSlots);

        // mark out the unfit
        foreach($appointments as $appointment) {
            $datetime = $appointment->time;
            $date = (new DateTime($datetime))->format('Y-m-d');
            $block = DoctorTime::timeToBlock(new DateTime($datetime));

            if (isset($freeSlots[$date])
                && isset($freeSlots[$date][$block])) {
                $freeSlots[$date][$block] = false;
            }
        }

        // echo "after freeslots: \n";
        // var_dump($freeSlots);

        // make the result
        $doctor = HospitalEmployee::find($doctor_id);
        $result = [];

        foreach($freeSlots as $date => $free) {
            foreach($free as $i => $isFree) {
                if ($isFree) {
                    $datetime = DoctorTime::blockToTime($i, new DateTime($date));
                    $result[] = [
                        'datetime' => $datetime,
                        'doctor' => $doctor,
                    ];
                }
            }
        }

        return $result;
    }

    //---------------------------getFreeSlotBySpecialty-----------------------------
    public static function getFreeSlotBySpecialty( $specialty ) {
        $doctors = HospitalEmployee::where('role','Doctor')->
                                     where('specialty',$specialty)->get();
        $result = [];
        foreach ($doctors as $doctor) {
            $doctor_id = $doctor->emp_id;
            $result = array_merge($result, DoctorTIme::getFreeSlotByDoctor($doctor_id));
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
            if($del) {
                // find a new appointment
                Appointment::createNextAppointment($doctor_id, $appointment);

                // delete the old one
                Appointment::deleteAppointment($appointment->appointment_id);

            }
        }
        $docTime = DoctorTime::orderBy('doctorTime_begin','asc')->where('doctor_id',$doctor_id)->get();
        return ["success" => true,"new doctorTime" => $docTime];
    }

}
