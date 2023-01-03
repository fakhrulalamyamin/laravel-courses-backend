<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Platform;
use App\Models\Series;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::latest()->take(6)->get();

        return response()->json($courses);
    }

    public function allCourses(Request $request)
    {
        $courses = Course::where(function ($query) use ($request) {
            if (!empty($request)) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if (!empty($request->price)) {
                if ($request->price === 'free') {
                    $query->where('price', 0);
                }

                if ($request->price === 'paid') {
                    $query->where('price', '>', 0);
                }
            }

            if (!empty($request->duration)) {
                $query->whereIn('duration', $request->duration);
            }

            if (!empty($request->platform)) {
                $query->whereIn('platform_id', $request->platform);
            }

            // if (!empty($request->series)) {
            //     $query->whereIn('series_id', $request->series);
            // }
        })->get();

        $platforms = Platform::select('id', 'name')->get();
        $series = Series::select('id', 'name')->get();

        return response()->json([
            'courses' => $courses,
            'platforms' => $platforms,
            'series' => $series
        ]);
    }
}
