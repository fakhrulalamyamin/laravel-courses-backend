<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $level = $request->level;

        $course = Course::where(function ($query) use ($search) {
            if (!empty($search)) {
                $query->where('name', 'like', '%' . $search . '%');
            }
        })->when($level, function ($query) use ($level) {
            if ($level == 'beginner') {
                $field = 0;
            } elseif ($level == 'intermediate') {
                $field = 1;
            } else {
                $field = 2;
            }

            $query->where('difficulty_label', $field);
        })->with('reviews')->paginate(10);

        // dd($course);

        return view('courses', [
            'courses' => $course
        ]);
    }





    public function show($slug)
    {
        $course = Course::where('slug', $slug)->with(['platform', 'topics', 'authors', 'series', 'reviews'])->first();

        // return response()->json($course);

        if (empty($course)) {
            return abort(404);
        }

        return view('course.single', [
            'course' => $course,
        ]);
    }
}
