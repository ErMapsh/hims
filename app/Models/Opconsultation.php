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
    public function getOpconsultationReport($patient_id)
    {
        $res = Opconsultation::where('patient_id', $patient_id)->get();
        return $res;
    }

}
