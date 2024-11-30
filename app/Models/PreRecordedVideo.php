<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreRecordedVideo extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'module_id',
        'module_number',
        'paid_course_id',
        'file',
        'course_video_number',
        'video_number',
        'video_title',
    ];

    public function Module() {
        return $this->belongsTo(Module::class);
    }
}
