<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    // get doctor list
    public function index($docId, Request $request)
    {
        try {
            $Doctors = Doctors::all();
            if (count($Doctors) > 0) {
                return response()->json(['data' => true, 'data' => $Doctors], 200);
            }
            return response()->json(['status' => false, 'message' => "Doctors not exists"], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    // registration of a doctor
    public function create(Request $request)
    {
        try {
            $input = $request->all();
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function createPatient($docId, Request $request)
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
            $pm->created_by = $docId;
            $save = $pm->save();
            if ($save) {
                $currentTimestamp = $this->generateTimestamp();
                DB::insert('insert into patient_doctor_relation (user_map_id, patient_id, visit_type, created_at) values(?,?,?,?)', [$docId, $pm->id, $input['visit_type'], $currentTimestamp]);
                return response()->json(['status' => true, 'message' => 'Patient Registration Successful'], 200);
            } else {
                return response()->json(['status' => false, 'message' => 'Patient Registration Failed'], 500);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    // diagnostic report
    public function createDiagnosticReport($docId, Request $request)
    {
        try {
            $req = $request->all();
            // dd($req, $docId);
            $dr = new DiagnosticReport();
            $dr->patient_id = $req['patient_id'];
            $dr->user_map_id = $docId;
            $dr->report_type = $req['report_type'];
            $dr->report_category = $req['report_category'];
            $dr->laboratory_test_name = $req['laboratory_test_name'];
            $dr->report_conclusion = $req['report_conclusion'];
            $dr->reporting_Doctor = $req['reporting_Doctor'];
            $dr->upload_file = $req['upload_file'];
            $dr->created_at = $req['report_created_date'];

            $save = $dr->save();
            // dd($save);
            if ($save) {
                return response()->json(['status' => true, 'message' => "Diagnostic report successfully added"], 200);
            }
        } catch (\Throwable $th) {

            dd("catch", $th);
            return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
        }
    }

    public function diagnosticlist($patientId)
    {
        $api = new PatientApi();
        if ($api->patientExist($patientId)) {
            $fun = new DiagnosticReport();
            $res = $fun->getDiagnosticReport($patientId);
            return response()->json(['status' => true, "data" => $res], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not exist"], 404);
    }

    // opconsultation
    public function createOpConsultation($docId, Request $request)
    {
        try {
            $req = $request->all();
            $op = new Opconsultation();
            $op->patient_id = $req['patient_id'];
            $op->user_map_id = $docId;
            $op->notes = $req['notes'];
            $op->upload_file = $req['upload_file'];

            $save = $op->save();
            if ($save) {
                return response()->json(['status' => true, 'message' => "Opconsultation record successfully added"], 200);
            }
        } catch (\Throwable $th) {
            dd($th);
            return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
        }
    }

    public function Opconsultationlist($patientId)
    {
        // first we have to check the patient and doctor is exist or not
        $api = new PatientApi();
        if ($api->patientExist($patientId)) {
            $fun = new Opconsultation();
            $res = $fun->getOpconsultationReport($patientId);
            return response()->json(['status' => true, "data" => $res], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not exist"], 404);
    }

    // Discharge summary
    public function CreateDischargeSummary($docId, Request $request)
    {
        try {
            $req = $request->all();
            $op = new DischargeSummary();

            $op->patient_id = $req['patient_id'];
            $op->user_map_id = $docId;
            $op->notes = $req['notes'];
            $op->upload_file = $req['upload_file'];

            $save = $op->save();
            if ($save) {
                return response()->json(['status' => true, 'message' => "Discharge summary record successfully added"], 200);
            }
        } catch (\Throwable $th) {
            return response()->json(["status" => false, 'message' => "Internal Server Error"], 500);
        }
    }

    public function DischargeSummaryList($patientId)
    {
        $api = new PatientApi();
        if ($api->patientExist($patientId)) {
            $fun = new DischargeSummary();
            $res = $fun->getDischargeSummaryList($patientId);
            return response()->json(['status' => true, "data" => $res], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not exist"], 404);
    }

    // Record prescription
    public function UploadRecordPrescription($docId, Request $request)
    {
        try {
            $req = $request->all();
            $op = new RecordPrescription();
            $op->patient_id = $req['patient_id'];
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

    public function RecordPrescriptionList($patientId)
    {
        $api = new PatientApi();
        if ($api->patientExist($patientId)) {
            $fun = new RecordPrescription();
            $res = $fun->getRecordPrescriptionList($patientId);
            return response()->json(['status' => true, "data" => $res], 200);
        }
        return response()->json(['status' => false, "message" => "Patient Not exist"], 404);
    }





}
