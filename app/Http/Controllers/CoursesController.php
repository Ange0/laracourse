<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class CoursesController extends Controller
{
    public function dashboard()
    {
        return Inertia::render('Dashboard');
    }
    public function index(){
        $courses = Course::with('user')->withCount('episodes')->get();
        return Inertia::render('Courses/index',compact('courses'));
    }

    public function show(int $id)
    {
        $watched = auth()->user()->episodes;
        $course = Course::where('id',$id)->with('episodes')->first();
        return Inertia::render('Courses/show',['course' => $course,'watched' => $watched]);
    }

    public function toggleProgress(Request $request)
    {
        $id =  $request->input('episodeId');
        $user = auth()->user();
        $user->episodes()->toggle($id);
        return $user->episodes;
    }

}
