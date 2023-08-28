<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Patients extends Model
{
    use HasFactory;
    protected $table = 'patients';
    protected $primaryKey = 'id';
    protected $fillable = [
        'health_id', 'patient_name', 'gender', 'dob', 'mobile', 'occupation', 'state', 'city', 'pincode', 'created_by'
    ];

    public function search($key, $value)
    {
        $patient = [];
        if ($key == 'id') {
            $result = Patients::where($key, $value)->first();
            $patient = [
                "id" => $result->patient_id,
                "health_id" => $result->health_id,
                "patient_name" => $result->patient_name,
                "gender" => $result->gender,
                "dob" => $result->dob,
                "mobile" => $result->mobile,
                "state_id" => $result->state,
                "state" => $this->stateName($result->state),
                "city_id" => $result->city,
                "city" => $this->cityName($result->city),
                "pincode" => $result->pincode,
                "occupation" => $result->occupation,
                "created_by_doctor" => $result->created_by_doctor,
                "registered_date" => $result->created_at
            ];
        } else {
            $results = Patients::where('patient_name', 'like', '%' . $value . '%')->orWhere('mobile', 'like', '%' . $value . '%')->get();
            foreach ($results as $result) {
                $patient[] = [
                    "id" => $result->patient_id,
                    "health_id" => $result->health_id,
                    "patient_name" => $result->patient_name,
                    "gender" => $result->gender,
                    "dob" => $result->dob,
                    "mobile" => $result->mobile,
                    "state_id" => $result->state,
                    "state" => $this->stateName($result->state),
                    "city_id" => $result->city,
                    "city" => $this->cityName($result->city),
                    "pincode" => $result->pincode,
                    "occupation" => $result->occupation,
                    "created_by_doctor" => $result->created_by_doctor,
                    "registered_date" => $result->created_at
                ];
            }
        }
        return array("patient" => $patient);
    }

    public function patientlist($esteblishmentusermapID)
    {
        $patient = [];
        $result = Patients::join('patient_doctor_relation', 'patient_doctor_relation.patient_id', 'patients.id')->where('patient_doctor_relation.user_map_id', $esteblishmentusermapID)->orderBy('patients.patient_name')->distinct()->get();
        foreach ($result as $r) {
            $patient[] = [
                "patient_id" => $r->id,
                "patient_name" => $r->patient_name,
                "mobile" => $r->mobile,
                "gender" => $r->gender,
                "dob" => $r->dob,
                "health_id" => $r->health_id,
                "pincode" => $r->pincode,
                "occupation" => $r->occupation,
                "visit_type" => $r->visit_type,
                "registered_date" => $r->created_at,
                "visit_date" => $r->updated_at
            ];
        }
        return $patient;
    }
}
