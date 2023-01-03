<?php

namespace App\Http\Controllers;

use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function show($slug) {
        $topic = Topic::where('slug', $slug)->first();
        $course = $topic->courses()->latest()->paginate(12);

        //return $topic;

        return view('topic.single',[
            'topic' => $topic,
            'courses' => $course
        ]);
    }
}
