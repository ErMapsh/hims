<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DischargeSummary extends Model
{
    use HasFactory;
    protected $table = 'patient_record_discharge_summary';
    protected $primaryKey = 'id';

    protected $fillable = [
        'user_map_id', 'patient_id', 'report_type', 'report_category', 'laboratory_test_name', 'report_conclusion', 'reporting_Doctor', 'upload_file', 'upload_file_name'
    ];


    public function dischargeList($esteblishmentusermapID, $patientId)
    {
        // $dischargeList = [];
        // $result = DischargeSummary::join('patient_diagnostic_report', 'patient_diagnostic_report.patient_id', 'patients.id')->where('patient_diagnostic_report.user_map_id', $esteblishmentusermapID, 'patient_diagnostic_report.patient_id', $patientId)->orderBy('patients.patient_name')->distinct()->get();
        // dd($result);
        // if (count($result) > 0) {
        //     foreach ($result as $r) {
        //         $patient[] = [
        //             "patient_id" => $r->id,
        //             "health_id" => $r->health_id,
        //             "patient_name" => $r->patient_name,
        //             "dob" => $r->dob,
        //             "gender" => $r->gender,
        //             "mobile" => $r->mobile,
        //             "state_id" => $r->state,
        //             "state" => $controller->stateName($r->state),
        //             "city_id" => $r->city,
        //             "city" => $controller->cityName($r->city),
        //             "pincode" => $r->pincode,
        //             "occupation" => $r->occupation,
        //             "registered_date" => $r->created_at,
        //             "visit_date" => $r->updated_at
        //         ];
        //     }
        //     return $patient;
        // }
        // return null;
    }
}
