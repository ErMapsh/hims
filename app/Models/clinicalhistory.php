<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class clinicalhistory extends Model
{
    use HasFactory;
    protected $table = 'patient_doctor_relation';
    protected $primaryKey = 'id';

    protected $fillable = [
        'patient_doctor_relation_id', 'user_map_id', 'patient_id', 'visit_type', 'created_at'
    ];

    public function getClinicalhistory($docId,$patient_Id)
   {
        //     $result = Patients::join('patient_doctor_relation', 'patient_doctor_relation.patient_id', 'patients.patient_id')->where('patient_doctor_relation.user_map_id', $esteblishmentusermapID)->orderBy('patients.patient_name')->distinct()->get();
        $query1 = DB::table('patient_doctor_relation AS pdr')
        ->join('patient_diagnostic_report AS dr', 'pdr.patient_id', '=', 'dr.patient_id')
        ->select('dr.created_at', DB::raw("'Diagnostic Report' AS type"), 'pdr.patient_id', 'pdr.visit_type')
        ->where('pdr.patient_id', $patient_Id)
        ->where('dr.user_map_id', $docId);

    $query2 = DB::table('patient_doctor_relation AS pdr')
        ->join('patient_op_consultation AS op', 'pdr.patient_id', '=', 'op.patient_id')
        ->select('op.created_at', DB::raw("'Op Consultation' AS type"), 'pdr.patient_id', 'pdr.visit_type')
        ->where('pdr.patient_id', $patient_Id)
        ->where('op.user_map_id', $docId);

    $query3 = DB::table('patient_doctor_relation AS pdr')
        ->join('patient_record_discharge_summary AS ds', 'pdr.patient_id', '=', 'ds.patient_id')
        ->select('ds.created_at', DB::raw("'Discharge Summary' AS type"), 'pdr.patient_id', 'pdr.visit_type')
        ->where('pdr.patient_id', $patient_Id)
        ->where('ds.user_map_id', $docId);

    $query4 = DB::table('patient_doctor_relation AS pdr')
        ->join('patient_record_prescription AS rp', 'pdr.patient_id', '=', 'rp.patient_id')
        ->select('rp.created_at', DB::raw("'Record Prescription' AS type"), 'pdr.patient_id', 'pdr.visit_type')
        ->where('pdr.patient_id', $patient_Id)
        ->where('rp.user_map_id', $docId);

    $result = $query1->union($query2)->union($query3)->union($query4)->get();


        // $reports = clinicalhistory::where('patient_id', $patient_Id)->where('user_map_id', $docId)->get()->all();
        if (count($result) > 0) {
            return $result;
        }
        return null;
    }
}
