<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Platform;
use App\Models\Series;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index() {
        $series = Series::take(4)->get();
        $featured_courses = Course::take(6)->get();

        return view('welcome', [
            'series' => $series,
            'courses' => $featured_courses
        ]);
    }

    public function dashboard() {
        if(Auth::user()->type === 1) {
            return view('dashboard');
        }
        else {
            return redirect()->route('home');
        }
    }

    public function archive($archive_type, $slug) {
        $allowed_archive_type = ['series', 'duration', 'level', 'platform', 'topic'];

        if(!in_array($archive_type, $allowed_archive_type)) {
            return abort(404);
        }

        // duration check
        if($archive_type === 'duration') {
            $allowed_duration = ['1-5-hours', '5-10-hours', '10-plus-hours'];

            if(!in_array($slug, $allowed_duration)) {
                return abort(404);
            }
        }

        // level check
        if($archive_type === 'level') {
            $allowed_duration = ['beginner', 'intermediate', 'advance'];

            if(!in_array($slug, $allowed_duration)) {
                return abort(404);
            }
        }

        if($archive_type === 'series') {
            $item = Series::where('slug', $slug)->first();
            $course = $item->courses()->paginate(12);

            if(empty($item)) {
                return abort(404);
            }

            $title = 'Courses on ' . $item->name;
        } elseif($archive_type === 'duration') {
            if($slug === '1-5-hours') {
                $item = '1-5 Hours';
                $duration_db_key = 0;
            } elseif($slug === '5-10-hours') {
                $item = '5-10 Hours';
                $duration_db_key = 1;
            } else {
                $item = '10+ Hours';
                $duration_db_key = 2;
            }

            $title = $item . ' long courses';
            $course = Course::where('duration', $duration_db_key)->paginate(12);
        } elseif($archive_type === 'level') {
            if($slug === 'beginner') {
                $item = 'Beginner';
                $level_db_key = 0;
            } elseif($slug === 'intermediate') {
                $item = 'Intermediate';
                $level_db_key = 1;
            } else {
                $item = 'Advance';
                $level_db_key = 2;
            }

            $title = $item . "'s courses";
            $course = Course::where('difficulty_label', $level_db_key)->paginate(12);
        } elseif($archive_type === 'platform') {
            $item = Platform::where('slug', $slug)->first();
            $course = $item->courses()->paginate(12);


            if(empty($item)) {
                return abort(404);
            }

            $title = 'Courses from ' . $item->name;
        } elseif($archive_type === 'topic') {
            $item = Topic::where('slug', $slug)->first();
            $course = $item->courses()->paginate(12);

            $title = 'Courses on ' . $item->name;
        }

        return view('archive.single', [
            'title' => $title,
            'courses' => $course
        ]);
    }
}
