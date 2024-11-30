<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Module;
use App\Models\Paid_course;
use App\Models\PreRecordedVideo;
use App\Models\Resource;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ModuleController extends Controller {

    // public function showAssignments($courseName, $moduleNumber, $encryptedModuleId) {
    //     try {
    //         $moduleId = Crypt::decrypt($encryptedModuleId);
    //         $module = Module::findOrFail($moduleId);
    //         $paid_course = $module->paidCourse;
    //         $assignments = Assignment::where('module_id', $moduleId)->get();
    //         return view('components.job.showAssignments', compact('module', 'paid_course', 'assignments'));
    //     } catch (Exception $e) {
    //         return redirect()->back();
    //     }
    // }

    public function showModule($courseName, $moduleNumber, $encryptedModuleId) {
        try {
            $moduleId = Crypt::decrypt($encryptedModuleId);
            $module = Module::where('id', $moduleId)->orderBy('module_number')->firstOrFail();
            $videos = PreRecordedVideo::where('module_id', $module->id)->get();
            $assignments = Assignment::where('module_id', $module->id)->get();
            $paid_course = $module->paidCourse;
            $resources = Resource::where('module_id', $module->id)->get();

            return view('components.job.module', compact('module', 'paid_course', 'videos', 'resources', ''));
        } catch (Exception $e) {
            return redirect()->back();
        }
    }

    public function storeModule(Request $request, $encryptedId) {
        $paid_course = Paid_course::findOrFail(Crypt::decrypt($encryptedId));
        $moduleNumber = $paid_course->modules()->count() + 1;
        Module::create([
            'paid_course_id' => $paid_course->id,
            'title' => $request->input('title'),
            'content' => $request->input('content'),
            'module_number' => $moduleNumber,
        ]);
        return redirect()->route('job_preparation.show', $encryptedId)->with('success', 'Module added successfully!');
    }

    public function storeExtraModule(Request $request, $encryptedId) {
        $paidCourseId = decrypt($encryptedId);
        $moduleNumber = $request->input('module_number');
        if ($moduleNumber < 0) {
            return redirect()->back()->with('error', 'Module with this number does not already exists. Please choose a different module number.');
        }
        $existingModule = Module::where('paid_course_id', $paidCourseId)
            ->where('module_number', $moduleNumber)
            ->first();
        $firstModule = $existingModule ? $existingModule->module_number - 1 : 0;
        if ($firstModule == 0 || $existingModule) {
            Module::where('paid_course_id', $paidCourseId)
                ->where('module_number', '>=', $moduleNumber)
                ->increment('module_number');
            Module::create([
                'paid_course_id' => $paidCourseId,
                'title' => $request->input('title'),
                'content' => $request->input('content'),
                'module_number' => $moduleNumber,
            ]);
            Module::reSerializeModuleNumbers($paidCourseId);
            return redirect()->route('job_preparation.show', $encryptedId)->with('success', 'Module added successfully!');
        } else {
            return redirect()->back()->with('error', 'Module with this number does not already exists. Please choose a different module number.');
        }
    }

    public function updateModule(Request $request, $encryptedId) {
        $moduleId = decrypt($request->input('module_id'));
        $module = Module::findOrFail($moduleId);
        $newModuleNumber = $request->input('module_number');

        $moduleExists = Module::where('paid_course_id', $module->paid_course_id)
            ->where('module_number', $newModuleNumber)
            ->exists();

        if ($moduleExists) {
            if ($module->module_number != $newModuleNumber) {
                if ($newModuleNumber > $module->module_number) {
                    Module::where('paid_course_id', $module->paid_course_id)
                        ->where('module_number', '>', $module->module_number)
                        ->where('module_number', '<=', $newModuleNumber)
                        ->decrement('module_number');
                } else {
                    Module::where('paid_course_id', $module->paid_course_id)
                        ->where('module_number', '<', $module->module_number)
                        ->where('module_number', '>=', $newModuleNumber)
                        ->increment('module_number');
                }
            }

            $module->title = $request->input('title');
            $module->content = $request->input('content');
            $module->module_number = $newModuleNumber;
            $module->save();

            return redirect()->route('job_preparation.show', $encryptedId)->with('success', 'Module updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Maybe your inserted module is not exists. Please choose a different module number.');
        }
    }

    public function deleteModule($moduleId, $encryptedId) {
        $module = Module::findOrFail($moduleId);
        $paidCourseId = $module->paid_course_id;
        $videos = $module->pre_recorded_videos;
        foreach ($videos as $video) {
            if (!empty($video->file)) {
                $filePath = public_path('uploads/' . $video->file);

                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
        }
        $module->delete();
        Module::reSerializeModuleNumbers($paidCourseId);
        return redirect()->route('job_preparation.show', $encryptedId)->with('success', 'Module deleted successfully!');
    }

    public function storeTitle(Request $request, $module_id) {
        $request->validate([
            'covered_topics' => 'required|string',
        ]);
        $module = Module::findOrFail($module_id);
        $module->covered_topics = $request->input('covered_topics');
        $module->save();
        return redirect()->back()->with('success', 'Module title updated successfully!');
    }

    public function showModuleResource($courseName, $moduleNumber, $encryptedModuleId) {
        $moduleId = Crypt::decrypt($encryptedModuleId);
        $module = Module::where('id', $moduleId)->orderBy('module_number')->firstOrFail();
        $videos = PreRecordedVideo::where('module_id', $module->id)->get();
        $paid_course = $module->paidCourse;
        $resources = Resource::where('module_id', $module->id)->get();
        return view('components.job.showResources', compact('module', 'paid_course', 'videos', 'resources'));
    }

    public function showModuleVideo($courseName, $moduleNumber, $encryptedModuleId) {
        $moduleId = Crypt::decrypt($encryptedModuleId);
        $module = Module::where('id', $moduleId)->orderBy('module_number')->firstOrFail();
        $videos = PreRecordedVideo::where('module_id', $module->id)->get();
        $paid_course = $module->paidCourse;
        $resources = Resource::where('module_id', $module->id)->get();
        return view('components.job.showPreRecordedVideo', compact('module', 'paid_course', 'videos', 'resources'));
    }

    public function viewModuleVideo($courseName, $moduleNumber, $videoNumber, $videoId, $encryptedModuleId) {
        try {
            $moduleId = Crypt::decrypt($encryptedModuleId);
            $module = Module::where('id', $moduleId)->orderBy('module_number')->firstOrFail();
            $videos = PreRecordedVideo::where('module_id', $module->id)->orderBy('video_number')->get();
            $paid_course = $module->paidCourse;
            $video = PreRecordedVideo::findOrFail($videoId);
            $resources = Resource::where('module_id', $module->id)->get();

            $prevVideo = null;
            $nextVideo = null;
            foreach ($videos as $key => $v) {
                if ($v->video_number == $videoNumber) {
                    if ($key > 0) {
                        $prevVideo = $videos[$key - 1];
                    }
                    if ($key < count($videos) - 1) {
                        $nextVideo = $videos[$key + 1];
                    }
                    break;
                }
            }

            return view('components.job.showPreRecordedVideo', compact('module', 'paid_course', 'videos', 'resources', 'video', 'prevVideo', 'nextVideo'));

        } catch (Exception $e) {
            return redirect()->back();
        }}

    public function lockModule($moduleId) {
        $module = Module::findOrFail($moduleId);
        $is_locked = $module->is_locked;
        $module->is_locked = $is_locked == 1 ? 0 : 1;
        $module->save();
        return redirect()->back();
    }

    public function deleteModuleVideo($moduleId, $encryptedId, $videoId) {
        try {
            $module = Module::findOrFail($moduleId);
            $paidCourseId = $module->paid_course_id;

            $video = PreRecordedVideo::findOrFail($videoId);

            $filePath = public_path('uploads/' . $video->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            $video->delete();

            $videos = PreRecordedVideo::where('module_id', $moduleId)->orderBy('video_number')->get();
            foreach ($videos as $key => $video) {
                $video->video_number = $key + 1;
                $video->save();
            }

            Module::reSerializeModuleNumbers($paidCourseId);

            $videoName = '';
            $links = '';

            return redirect()->back();
            // return redirect()->route('constructionsms', compact('videoName', 'links'))->with('success', 'Video deleted successfully!');

        } catch (Exception $e) {
            return redirect()->back()->with('Something went wrong');
        }
    }

    public function deleteModuleResource($moduleId, $encryptedId, $resourceId) {
        $resource = Resource::findorfail($resourceId);
        $moduleId = decrypt($encryptedId);
        $module = Module::findOrFail($moduleId);

        if (!empty($resource->file)) {
            $filePath = public_path('uploads/' . $resource->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $resource->delete();

        $resources = $module->resources()->orderBy('resource_number')->get();
        foreach ($resources as $key => $resource) {
            $resource->resource_number = $key + 1;
            $resource->save();
        }

        return redirect()->back()->with('success', 'Resource deleted successfully!');
    }

    public function storeAssignmentTopics(Request $request, $module_id) {
        $request->validate([
            'assignment_topics' => 'required|string',
        ]);
        $module = Module::findOrFail($module_id);
        $module->assignment_topics = $request->input('assignment_topics');
        $module->save();
        return redirect()->back()->with('success', 'Module title updated successfully!');
    }

    public function storeVideo(Request $request, $module_id) {
        $request->validate([
            'video_title' => 'required|string',
            'image' => 'required|mimes:mp4,mov,avi|max:2048',
        ]);
        $module = Module::findorfail($module_id);
        $videoNumber = $module->pre_recorded_videos()->count() + 1;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'recorded_video_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }
        PreRecordedVideo::create([
            'user_id' => auth()->user()->id,
            'module_id' => $request->module_id,
            'module_number' => $request->module_number_id,
            'paid_course_id' => $request->paid_course_id,
            'file' => $request->hasFile('image') ? $fileNameToStore : '',
            'video_title' => $request->video_title,
            'video_number' => $videoNumber,
        ]);
        return redirect()->back()->with('success', 'Video Uploaded Successfully!');
    }

    public function storeExtraVideo(Request $request, $module_id) {
        $request->validate([
            'video_title' => 'required|string',
            'image' => 'required|mimes:mp4,mov,avi|max:2048',
            'video_number' => 'required|integer|min:1',
        ]);

        $module = Module::findOrFail($module_id);

        $requestedPosition = $request->video_number;

        $existingVideoAtPosition = $module->pre_recorded_videos()->where('video_number', $requestedPosition)->exists();

        if (!$existingVideoAtPosition) {
            return redirect()->back()->with('error', 'The provided video number not exists. Please choose a different one.');
        }

        $existingVideos = $module->pre_recorded_videos()->orderBy('video_number')->get();

        $requestedPosition = $request->video_number;

        foreach ($existingVideos as $video) {
            if ($video->video_number >= $requestedPosition) {
                $video->video_number++;
                $video->save();
            }
        }

        $fileNameToStore = '';
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'recorded_video_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }

        PreRecordedVideo::create([
            'user_id' => auth()->user()->id,
            'module_id' => $module->id,
            'module_number' => $module->module_number,
            'paid_course_id' => $request->paid_course_id,
            'file' => $fileNameToStore,
            'video_title' => $request->video_title,
            'video_number' => $requestedPosition,
        ]);

        return redirect()->back()->with('success', 'Extra Video Uploaded Successfully!');
    }

    public function storeResources(Request $request, $module_id) {
        $module = Module::findorfail($module_id);
        $resourceNumber = $module->resources()->count() + 1;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'resources_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }

        Resource::create([
            'user_id' => auth()->user()->id,
            'module_id' => $request->module_id,
            'module_number' => $request->module_number_id,
            'paid_course_id' => $request->paid_course_id,
            'file' => $request->hasFile('image') ? $fileNameToStore : '',
            'url' => $request->url,
            'resource_number' => $resourceNumber,
            'course_resource_number' => $resourceNumber,
        ]);
        return redirect()->back()->with('success', 'Resource Uploaded Successfully!');
    }

    public function storeExtraResources(Request $request, $module_id) {
        $module = Module::findOrFail($module_id);

        $resources = $module->resources()->orderBy('resource_number')->get();

        $newResourceNumber = intval($request->resource_number);

        foreach ($resources as $resource) {
            if ($resource->resource_number >= $newResourceNumber) {
                $resource->resource_number++;
                $resource->save();
            }
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'resources_' . md5(uniqid()) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }

        Resource::create([
            'user_id' => auth()->user()->id,
            'module_id' => $module->id,
            'module_number' => $module->module_number,
            'paid_course_id' => $request->paid_course_id,
            'file' => $request->hasFile('image') ? $fileNameToStore : '',
            'url' => $request->url,
            'resource_number' => $newResourceNumber,
            'course_resource_number' => $newResourceNumber,
        ]);

        return redirect()->back()->with('success', 'Extra Resource Uploaded Successfully!');
    }

    public function assignment(Request $request) {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg,gif,mp3,wav,mp4,mov,avi,|max:2048',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileNameToStore = 'assignment_' . md5((uniqid())) . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads'), $fileNameToStore);
        }
        Assignment::create([
            'user_id' => auth()->user()->id,
            'module_id' => $request->module_id,
            'module_number' => $request->module_number_id,
            'paid_course_id' => $request->paid_course_id,
            'file' => $request->hasFile('image') ? $fileNameToStore : '',
        ]);
        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }

    public function updateModuleResource(Request $request, $encryptedId) {
        $resourceId = decrypt($request->input('resource_id'));
        $moduleId = decrypt($request->input('module_id'));
        $resource = Resource::findorfail($resourceId);
        $resourceNumber = $request->input('resource_number');

        $existingResource = Resource::where('module_id', $moduleId)
            ->where('resource_number', $resourceNumber)
            ->exists();

        if ($existingResource) {
            if ($resource->resource_number != $resourceNumber) {
                if ($resourceNumber > $resource->resource_number) {
                    Resource::where('module_id', $resource->module_id)
                        ->where('resource_number', '>', $resource->resource_number)
                        ->where('resource_number', '<=', $resourceNumber)
                        ->decrement('resource_number');
                } else {
                    Resource::where('module_id', $resource->module_id)
                        ->where('resource_number', '<', $resource->resource_number)
                        ->where('resource_number', '>=', $resourceNumber)
                        ->increment('resource_number');
                }
            }

            $resource->url = $request->input('url');
            $resource->resource_number = $resourceNumber;
            $resource->save();

            return redirect()->back()->with('success', 'Module updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Maybe your inserted video is not exists. Please choose a different module number.');
        }
    }

    public function updateModuleVideo(Request $request) {
        $videoId = decrypt($request->input('video_id'));
        $moduleId = decrypt($request->input('module_id'));

        $video = PreRecordedVideo::findOrFail($videoId);

        $videoNumber = $request->input('video_number');

        $existingVideo = PreRecordedVideo::where('module_id', $moduleId)
            ->where('video_number', $videoNumber)
            ->exists();

        if ($existingVideo) {
            if ($video->video_number != $videoNumber) {
                if ($videoNumber > $video->video_number) {
                    PreRecordedVideo::where('module_id', $video->module_id)
                        ->where('video_number', '>', $video->video_number)
                        ->where('video_number', '<=', $videoNumber)
                        ->decrement('video_number');
                } else {
                    PreRecordedVideo::where('module_id', $video->module_id)
                        ->where('video_number', '<', $video->video_number)
                        ->where('video_number', '>=', $videoNumber)
                        ->increment('video_number');
                }
            }

            $video->video_title = $request->input('video_title');
            $video->video_number = $videoNumber;
            $video->save();

            return redirect()->back()->with('success', 'Module updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Maybe your inserted video is not exists. Please choose a different module number.');
        }
    }

}
