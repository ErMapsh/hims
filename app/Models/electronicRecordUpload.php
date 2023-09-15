<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class electronicRecordUpload extends Model
{
    use HasFactory;
    protected $table = 'electronicrecordupload';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_map_id', 'patient_name', 'gender', 'dob','notes', 'upload_file', 'upload_file_name', 'created_at', 'updated_at'
    ];

    // public function ElectronicRecord($docId, $patientId)
    // {   $reports = electronicRecordUpload::where('patient_id', $patientId)->where('user_map_id', $docId)->get()->all();
    //     if (count($reports) > 0) {
    //         return $reports;
    //     }
    //     return null;
    // }
}
