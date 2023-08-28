<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class RecordPrescription extends Model
{
    use HasFactory;
    protected $table = 'patient_record_prescription';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_map_id', 'patient_id', 'notes', 'upload_file', 'created_at'
    ];
    public function getRecordPrescriptionList($patient_id)
    {
        $res = RecordPrescription::where('patient_id', $patient_id)->get();
        return $res;
    }

}
