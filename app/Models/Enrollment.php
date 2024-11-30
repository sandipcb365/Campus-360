<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'paid_course_id'];

    // Define the relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paidCourse()
    {
        return $this->belongsTo(Paid_course::class);
    }
}
