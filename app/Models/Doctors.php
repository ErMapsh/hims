<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    use HasFactory;
    protected $table = 'doctors';
    protected $primaryKey = 'id';

    // protected $fillable = [
    //     'health_id', 'patient_name', 'gender', 'dob', 'mobile', 'occupation', 'state', 'city', 'pincode', 'visit_type_id'
    // ];
}
