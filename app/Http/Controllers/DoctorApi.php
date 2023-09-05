<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\clinicalhistory;
use App\Models\DiagnosticReport;
use App\Models\DischargeSummary;
use App\Models\Doctors;
use App\Models\Opconsultation;
use App\Models\Patients;
use App\Models\RecordPrescription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class DoctorApi extends Controller
{

    public function DoctorExist($docId)
    {
        $entity = Doctors::find($docId);
        return $entity;
    }

    public function createPatient($esteblishmentusermapID, Request $request)
    {
        try {
            $input = $request->all();
            // $patient = Patients::where('mobile', $input['mobile'])->first();
            // if ($patient) {
            //     return response()->json(['status' => false, 'message' => 'Mobile Number already exist, Try another Mobile Number'], 400);
            $pm = new Patients;
            $pm->health_id = $input['health_id'];
            $pm->patient_name = $input['patient_name'];
            $pm->gender = $input['gender'];
            $pm->dob = $input['dob'];
            $pm->mobile = $input['mobile'];
            $pm->state = $input['state'];
            $pm->city = $input['city'];
            $pm->pincode = $input['pincode'];
            $pm->occupation = $input['occupation'];
            $pm->visit_type = $input['visit_type'];
            $pm->created_by = $esteblishmentusermapID;
            $save = $pm->save();

            if ($save) {
                $currentTimestamp = $this->generateTimestamp();
                DB::insert('insert into patient_doctor_relation (user_map_id, patient_id, visit_type, created_at) values(?,?,?,?)', [$esteblishmentusermapID, $pm->patient_id, $input['visit_type'], $currentTimestamp]);
                return response()->json(['status' => true, 'message' => 'Patient Registration Successful'], 200);
            } else {
                return response()->json(['status' => false, 'error' => 'Something went wrong', 'message' => "Patient Registration Failed"], 500);
            }
        } catch (\Throwable $th) {
            // dd($th);
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function getPatientList($esteblishmentusermapID)
    {
        // $entity = $this->DoctorExist($esteblishmentusermapID);
        // dd($entity);
        // doctor is exist and moving forward so tempory purpose
        $pm = new Patients();

        $data = $pm->patientlist($esteblishmentusermapID);

        if ($data) {
            return response()->json(['status' => true, 'data' => $data], 200);
        }
        return response()->json(['status' => false, 'message' => 'No patient records found (and its depends on doctor id)']);
    }

    // diagnostic report
    public function createDiagnosticReport($docId, $patientId, Request $request)
    {
        /* before creating diagnostric report we have to check the patient have doctor have relation */
        try {
            $req = $request->all();
            $dr = new DiagnosticReport();
            $dr->patient_id = $patientId;
            $dr->user_map_id = $docId;
            $dr->report_type = $req['report_type'];
            $dr->report_category = $req['report_category'];
            $dr->laboratory_test_name = $req['laboratory_test_name'];
            $dr->report_conclusion = $req['report_conclusion'];
            $dr->reporting_Doctor = $req['reporting_Doctor'];
            $dr->upload_file = $req['upload_file'];
            $dr->upload_file_name = $req['upload_file_name'];
            $dr->created_at = $req['report_created_date'];
            $save = $dr->save();
            if ($save) {
                return response()->json(['status' => true, 'message' => "Diagnostic report successfully added"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
        }
    }

    public function getDiagnosticList($docId, $patientId)
    {
        /* here first check doctor and patient is exist */
        $patientModel = new Patients();
        $patietntExist = $patientModel->patientExist($patientId);

        if ($patietntExist) {
            $api = new DiagnosticReport();
            $res = $api->getDiagnosticReport($docId, $patientId);
            if ($res) {
                return response()->json(['status' => true, "diagnostic_data" => $res], 200);
            }
            return response()->json(['status' => false, "message" => "Patient Records Not Available"], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not Found"], 400);
    }

     // opconsultation
     public function createOpConsultation($docId,$patientId, Request $request)
     {
         try {
             $req = $request->all();
             $op = new Opconsultation();
             $op->patient_id =$patientId;
             $op->user_map_id = $docId;
             $op->notes = $req['notes'];
             $op->upload_file = $req['upload_file'];
             $op->upload_file_name =$req['upload_file_name'];
             $save = $op->save();

             if ($save) {
                 return response()->json(['status' => true, 'message' => "Opconsultation record successfully added"], 200);
             }
         } catch (\Throwable $th) {
             dd($th);
             return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
         }
     }

     public function Opconsultationlist($patientId,$docId)
     {
        $patientModel = new Patients();
        $patietntExist = $patientModel->patientExist($patientId);

        if ($patietntExist) {
            $api = new Opconsultation();
            $res = $api->getOpconsultationReport($docId, $patientId);
            if ($res) {
                return response()->json(['status' => true, "opConsultation_data" => $res], 200);
            }
            return response()->json(['status' => false, "message" => "Records Not Available"], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not Found"], 400);
     }

     // Discharge summary
     public function CreateDischargeSummary($docId, $patientId,Request $request)
     {

        try {
            $req = $request->all();
            $di = new DischargeSummary();
            $di->patient_id =$patientId;
            $di->user_map_id = $docId;
            $di->notes = $req['notes'];
            $di->upload_file = $req['upload_file'];
            $di->upload_file_name =$req['upload_file_name'];
            $save = $di->save();

            if ($save) {
                return response()->json(['status' => true, 'message' => "DischargeSummary record successfully added"], 200);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
        }
     }

     public function DischargeSummaryList($docId,$patientId)
     {
        $patientModel = new Patients();
        $patietntExist = $patientModel->patientExist($patientId);

        if ($patietntExist) {
            $api = new DischargeSummary();
            $res = $api->getDischargeSummaryList($docId,$patientId);
            if ($res) {
                return response()->json(['status' => true, "Discharge_summary_data" => $res], 200);
            }
            return response()->json(['status' => false, "message" => "Records Not Available"], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not Found"], 400);
     }

     // Record prescription
     public function UploadRecordPrescription($docId,$patientId, Request $request)
     {
         try {
             $req = $request->all();
             $op = new RecordPrescription();
             $op->patient_id = $patientId;
             $op->user_map_id = $docId;
             $op->notes = $req['notes'];
             $op->upload_file = $req['upload_file'];

             $save = $op->save();
             if ($save) {
                 return response()->json(['status' => true, 'message' => "Record prescription successfully added"], 200);
             }
         } catch (\Throwable $th) {
             dd($th);
             return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
         }
     }

     public function RecordPrescriptionList($docId,$patientId)
     {
        $patientModel = new Patients();
        $patietntExist = $patientModel->patientExist($patientId);

        if ($patietntExist) {
            $api = new RecordPrescription();
            $res = $api->getRecordPrescriptionList($docId,$patientId);
            if ($res) {
                return response()->json(['status' => true, "Record_Prescription_data" => $res], 200);
            }
            return response()->json(['status' => false, "message" => "Records Not Available"], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not Found"], 400);
     }
public function viewPastClinicalHistory($docId,$patientId){
        $api =new clinicalhistory();
        $res =$api ->getClinicalhistory($docId,$patientId);
        if($res){
            return response()->json(['status' => true, "data" => $res], 200);
        }
        return response()->json(['status' => true, "message" => "data not Available"], 200);
     }
}
