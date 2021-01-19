<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Course' => 'App\Policies\CoursePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // utiliser dans les vues (tu as le droit de mettre à jour si course->user_id = user->id) / alors que policy est utiliser dans les controlleur
        Gate::define('update-course', function ($course){
            return $course->user_id === auth()->user()->id;
        });
    }
}
