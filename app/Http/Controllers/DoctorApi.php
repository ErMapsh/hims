<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Doctors;
use App\Models\Patients;
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
}
