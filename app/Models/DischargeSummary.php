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
        'id', 'user_map_id', 'patient_id', 'notes', 'upload_file', 'created_at', 'updated_at'
    ];

    public function getDischargeSummaryList($patient_id)
    {
        $res =DischargeSummary::where('patient_id', $patient_id)->get();
        return $res;
    }




}
