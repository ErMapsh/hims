<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DischargeSummary extends Model
{
    use HasFactory;
    protected $table = 'patient_record_discharge_summary';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id', 'user_map_id', 'patient_id', 'notes', 'upload_file', 'created_at'
    ];


    public function getDischargeSummaryList($docId, $patientId)
    {
        $reports = DischargeSummary::where('patient_id', $patientId)->where('user_map_id', $docId)->get()->all();
        if (count($reports) > 0) {
            return $reports;
        }
        return null;
    }
}
