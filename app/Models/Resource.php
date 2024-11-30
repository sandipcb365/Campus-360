<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model {
    use HasFactory;
    protected $fillable = [
        'user_id',
        'module_id',
        'module_number',
        'paid_course_id',
        'file',
        'course_resource_number',
        'resource_number',
        'url',
    ];

    public function modules() {
        return $this->belongsTo(Module::class);
    }
}
