<?php

namespace App\Models\Student;

use Illuminate\Database\Eloquent\Model;

 class Mentor extends Model
 {
     protected $fillable = [
        'mentor_name',
        'mentor_phone',
        'gender',
        'mentor_gender',
        'district',
        'semester',
        'school_id',
        'school_name',
        'bursary_id',
        'student_name',
        'm_date',
        'age',
        'disability_status',
        'form',
        'topics',
        'comments',
        'created_by'
     ];
 }