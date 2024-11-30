<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paid_course extends Model {
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
    ];

    public function enrollments() {
        return $this->hasMany(Enrollment::class);
    }

    public function modules() {
        return $this->hasMany(Module::class);
    }

    public function pre_recorded_videos() {
        return $this->hasMany(PreRecordedVideo::class);
    }
}
