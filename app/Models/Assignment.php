<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model {
    use HasFactory;
    protected $fillable = ['user_id', 'paid_course_id', 'module_id', 'module_number', 'file', 'marks', 'checked'];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function paidCourse() {
        return $this->belongsTo(Paid_course::class);
    }

    public function module() {
        return $this->belongsTo(Module::class);
    }
}
