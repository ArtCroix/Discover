<?php

use App\Http\Resources\Answer as AnswerResource;
use App\Models\Application\Answer;
use App\Models\Application\Application;
use App\Models\Application\Question;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

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

if (env('APP_DEBUG')) {
    Artisan::call('view:clear');
}

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test/{p1}/{locale?}', function () {
    // dd(array_merge(Request::route()->parameters(), ['locale' => 'cn']));
    //    dd(\Request::route()->getName());
    // return view('welcome');
});

Route::get('add_team_member/{submit_id}', 'ApplicationController@doCopySubmit')
    ->middleware('signed')
    ->name('add_team_member');

Auth::routes(['verify' => true]);

Route::get('login/{locale?}', 'Auth\LoginController@showLoginForm')
    ->name('login');

Route::get('register/{locale?}', 'Auth\RegisterController@showRegistrationForm')
    ->name('register');

Route::get('/home/{locale?}', 'HomeController@index')
    ->where('locale', 'en|ru|cn')
    ->middleware('verified')
    ->name('home');

Route::get('/home/event/{event_name}/status/{locale?}', 'HomeController@event_status')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('home_event_status');

Route::get('/home/event/{event_name}/app/{app_id}/{locale?}', 'HomeController@getEventApp')
    ->where('locale', 'en|ru|cn')
    ->middleware('verified')
    ->middleware('check_prev_submit')
    ->name('home_event_app');

Route::get('/my_home/{locale?}', 'HomeController@myHome')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('my_home');

Route::get('/profile/{locale?}', 'HomeController@profile_status')
    ->where('locale', 'en|ru|cn')
    ->name('profile');

Route::post('/add_app_inst/{application_id}/{locale}', 'ApplicationController@doCreateApplicationSubmit')
    ->where('locale', 'en|ru|cn')
    ->middleware('verified')
    ->name('add_app_inst');

Route::delete('/delete_file_from_app_submit/{application_id}', 'ApplicationController@doDeleteFileFromApplicationSubmit')
    ->name('add_app_inst');
