<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
                "state" => $result->state,
                "city" => $result->city,
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
                    "state" => $result->state,
                    "city" => $result->city,
                    "pincode" => $result->pincode,
                    "occupation" => $result->occupation,
                    "created_by_doctor" => $result->created_by_doctor,
                    "registered_date" => $result->created_at
                ];
            }
        }
        return array("patient" => $patient);
    }
}
