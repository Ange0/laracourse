<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class CoursesController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
    public function index(){
        $courses = Course::with('user')
            ->select('courses.*',DB::raw(
                '(SELECT COUNT(DISTINCT(user_id))
                FROM completions
                INNER JOIN episodes ON completions.episode_id = episodes.id
                WHERE episodes.course_id = courses.id
                ) AS participants'
            ))
            ->withCount('episodes')->latest()->get();
        return Inertia::render('Courses/Index',compact('courses'));
    }

    public function show(int $id)
    {
        $watched = auth()->user()->episodes;
        $course = Course::where('id',$id)->with('episodes')->first();
        return Inertia::render('Courses/Show',['course' => $course,'watched' => $watched]);
    }

    public function toggleProgress(Request $request)
    {
        $id =  $request->input('episodeId');
        $user = auth()->user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }

}
