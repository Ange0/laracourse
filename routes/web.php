<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::group(['prefix' => LaravelLocalization::setLocale(),'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]], function()
 {
    Route::get('/', function () {
        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'laravelVersion' => Application::VERSION,
            'phpVersion' => PHP_VERSION,
        ]);
    });
    Route::get('/courses','App\Http\Controllers\CoursesController@index')->name('courses.index');
    Route::group(['auth:sanctum', 'verified'],function() {
        Route::get('/course/{id}','App\Http\Controllers\CoursesController@show')->name('courses.show');
        Route::post('/toggleProgress','App\Http\Controllers\CoursesController@toggleProgress')->name('courses.toggleProgress');
        Route::post('/store','App\Http\Controllers\CoursesController@store')->name('courses.store');
        Route::get('/course/edit/{id}','App\Http\Controllers\CoursesController@edit')->name('courses.edit');
        Route::patch('/course/update/{id}','App\Http\Controllers\CoursesController@update')->name('courses.update');
        Route::get('/create','App\Http\Controllers\CoursesController@create')->name('courses.create');
    });

});