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
        $reports = clinicalhistory::where('patient_id', $patient_Id)->where('user_map_id', $docId)->get()->all();
        if (count($reports) > 0) {
            return $reports;
        }
        return null;
    }
}
