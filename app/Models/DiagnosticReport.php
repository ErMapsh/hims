<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class DiagnosticReport extends Model
{
    use HasFactory;
    protected $table = 'patient_diagnostic_report';
    protected $primaryKey = 'id';

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

    public function getDiagnosticReport($docId, $patient_id)
    {
        $reports = DiagnosticReport::where('patient_id', $patient_id)->where('user_map_id', $docId)->get()->all();
        if (count($reports) > 0) {
            return $reports;
        }
        return null;
    }
}
