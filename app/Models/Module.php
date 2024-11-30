<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model {
    use HasFactory;

    protected $fillable = [
        'paid_course_id',
        'title',
        'content',
        'covered_topics',
        'assignment_topics',
        'module_number',
    ];

    public static function reSerializeModuleNumbers($paidCourseId) {
        $modules = self::where('paid_course_id', $paidCourseId)->orderBy('module_number')->get();

        foreach ($modules as $key => $module) {
            $module->module_number = $key + 1;
            $module->save();
        }
    }

    public function paidCourse() {
        return $this->belongsTo(Paid_course::class);
    }

    public function resources() {
        return $this->hasMany(Resource::class);
    }

    public function pre_recorded_videos() {
        return $this->hasMany(PreRecordedVideo::class);
    }
}
