<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Patients;
use Illuminate\Http\Request;


class PatientApi extends Controller
{

    public function index($docId, Request $request)
    {
        try {
            $patients = Patients::all();
            if (count($patients) > 0) {
                for ($i = 0; $i < count($patients); $i++) {
                    $patients[$i]['state_id'] = $this->stateName($patients[$i]['state']);
                    $patients[$i]['city_id'] = $this->cityName($patients[$i]['city']);
                }
                return response()->json(['status' => true, 'data' => $patients]);
            }
            return response()->json(['status' => false, 'message' => "Patients not exists"], 200);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $input = $request->all();
            $patient = Patients::where('mobile', $input['mobile'])->first();
            // dd($patient);
            if ($patient) {
                return response()->json(['status' => false, 'message' => 'Patient Mobile Number already exist'], 400);
            } else {
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
                $save = $pm->save();
                if ($save) {
                    return response()->json(['status' => true, 'message' => 'Patient Registration Successful'], 200);
                } else {
                    return response()->json(['status' => false, 'message' => 'Patient Registration Failed'], 500);
                }
            }
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'message' => 'Internal Server Error'], 500);
        }
    }
}
