<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Episode;
use App\Youtube\YoutubeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
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
            ))->addSelect(DB::raw(
                '(
                    SELECT SUM(duration) 
                    FROM episodes
                    WHERE episodes.course_id=courses.id
                ) AS total_duration'
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
    public function store(Request $request,YoutubeService $yts)
    {
     /*    
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['array','required'],
            'episodes.*.title' => 'required', // le titre de chaque episode est requis
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required'


        ]);


       $course =  Course::create($request->all()); */

        foreach ($request->input('episodes') as $episode) {

            /* $episode['course_id'] = $course->id;  */// je creer une variable course_id à la volé
            $episode['duration'] = $yts->videoDuration($episode['video_url']);
            Episode::create($episode);
        }

        return Redirect::route('dashboard')->with('success','Felicitation la formation à bien été mise en ligne');
    }

    public function edit(int $id)
    { 
        $course = Course::where('id',$id)->with('episodes')->first();
        $this->authorize('update',$course);// gere l'autorisation grace au policy
        return Inertia::render('Courses/Edit',compact('course'));
    }
    public function update(Request $request)
    {
        
         
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'episodes' => ['array','required'],
            'episodes.*.title' => 'required', // le titre de chaque episode est requis
            'episodes.*.description' => 'required',
            'episodes.*.video_url' => 'required'


        ]);

        $course = Course::where('id',$request->id)->with('episodes')->first();
        $this->authorize('update',$course);// gere l'autorisation grace au policy
        $course->update($request->all());
        $course->episodes()->delete();

        foreach ($request->episodes as $episode) {
            $episode['course_id'] = $course->id; // je creer une variable course_id à la volé
            Episode::create($episode);
        }
        return Redirect::route('courses.index')->with('success','Felicitation votre formation à bien été modifiée');
    }

}
