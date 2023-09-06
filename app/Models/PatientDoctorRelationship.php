<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientDoctorRelationship extends Model
{
    use HasFactory;
    protected $table = 'patient_doctor_relation';
    protected $primaryKey = 'patient_doctor_relation_id';

    protected $fillable = [
        'patient_doctor_relation_id', 'user_map_id', 'patient_id', 'visit_type', 'created_at'
    ];

    public function doctorPatientRelationExists($patientId,$docId)
    {
        try {
            $exist = PatientDoctorRelationship::where('patient_id', $patientId)
            ->where('user_map_id', $docId)
            ->exists();
            return $exist;
        } catch (\Throwable $th) {
            return false;
        }
    }

    // public function patientlist($esteblishmentusermapID)
    // {
    //     $patient = [];
    //     $controller = new Controller();
    //     $result = Patients::join('patient_doctor_relation', 'patient_doctor_relation.patient_id', 'patients.patient_id')->where('patient_doctor_relation.user_map_id', $esteblishmentusermapID)->orderBy('patients.patient_name')->distinct()->get();
    //     if (count($result) > 0) {
    //         foreach ($result as $r) {
    //             $patient[] = [
    //                 "patient_id" => $r->patient_id,
    //                 "health_id" => $r->health_id,
    //                 "patient_name" => $r->patient_name,
    //                 "dob" => $r->dob,
    //                 "gender" => $r->gender,
    //                 "mobile" => $r->mobile,
    //                 "state_id" => $r->state,
    //                 "state" => $controller->stateName($r->state),
    //                 "city_id" => $r->city,
    //                 "city" => $controller->cityName($r->city),
    //                 "pincode" => $r->pincode,
    //                 "visit_type" => $r->visit_type,
    //                 "occupation" => $r->occupation,
    //                 "registered_date" => $r->created_at,
    //                 "last_appointment_date" => $r->updated_at
    //             ];
    //         }

    //         return $patient;
    //     }
    //     return null;
    // }





}
