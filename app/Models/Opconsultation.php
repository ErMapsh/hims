<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
class Opconsultation extends Model
{
    use HasFactory;
    protected $table = 'patient_op_consultation';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_map_id', 'patient_id', 'notes', 'upload_file', 'created_at'
    ];
    public function getOpconsultationReport($docId,$patient_id)
    {
        $reports = Opconsultation::where('patient_id', $patient_id)->where('user_map_id', $docId)->get()->all();
        if (count($reports) > 0) {
            return $reports;
        }
        return null;
    }

}
