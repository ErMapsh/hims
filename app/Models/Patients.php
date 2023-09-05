<?php

namespace App\Models;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $primaryKey = 'patient_id';
    protected $fillable = [
        'health_id', 'patient_name', 'gender', 'dob', 'mobile', 'occupation', 'state', 'city', 'pincode', 'created_by'
    ];

    public function patientExist($patientId)
    {
        try {
            $exist = Patients::find($patientId)->exists();
            return $exist;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function patientlist($esteblishmentusermapID)
    {
        $patient = [];
        $controller = new Controller();
        $result = Patients::join('patient_doctor_relation', 'patient_doctor_relation.patient_id', 'patients.patient_id')->where('patient_doctor_relation.user_map_id', $esteblishmentusermapID)->orderBy('patients.patient_name')->distinct()->get();
        if (count($result) > 0) {
            foreach ($result as $r) {
                $patient[] = [
                    "patient_id" => $r->patient_id,
                    "health_id" => $r->health_id,
                    "patient_name" => $r->patient_name,
                    "dob" => $r->dob,
                    "gender" => $r->gender,
                    "mobile" => $r->mobile,
                    "state_id" => $r->state,
                    "state" => $controller->stateName($r->state),
                    "city_id" => $r->city,
                    "city" => $controller->cityName($r->city),
                    "pincode" => $r->pincode,
                    "visit_type" => $r->visit_type,
                    "occupation" => $r->occupation,
                    "registered_date" => $r->created_at,
                    "last_appointment_date" => $r->updated_at
                ];
            }

            return $patient;
        }
        return null;
    }
}
