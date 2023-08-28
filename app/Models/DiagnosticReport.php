<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DiagnosticReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_map_id',
        'patient_id',
        'report_type',
        'report_category',
        'laboratory_test_name',
        'report_conclusion',
        'reporting_Doctor',
        'upload_file',
        'created_at'
    ];

    protected $table = 'patient_diagnostic_report';
    protected $primaryKey = 'id';

    public function getDiagnosticReport($patient_id)
    {
        $res = DiagnosticReport::where('patient_id', $patient_id)->get();
        return $res;
    }


}
