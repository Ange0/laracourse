<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CoursesController extends Controller
{
    public function dashboard(){
        return Inertia::render('Dashboard');
    }
    public function index(){
        
        $courses = Course::with('user')->withCount('episodes')->get();
  
        return Inertia::render('Courses/index',compact('courses'));
    }

    public function show(int $id){
        
        $course = Course::where('id',$id)->with('episodes')->first();
        return Inertia::render('Courses/show',['course' => $course]);
    }

}
