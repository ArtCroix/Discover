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

/**
 * Home routes
 */
Route::get('/home/{locale?}', 'HomeController@index')
    ->where('locale', 'en|ru|cn')
    ->middleware('verified')
    ->name('home');

/**
 * Profile routes
 */
Route::get('/profile/{locale?}', 'ProfileController@profileStatus')
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('profile');

Route::get('/edit_profile/{locale?}', 'ProfileController@showEditProfile')
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('edit_profile');

Route::get('/edit_password/{locale?}', 'ProfileController@showEditPassword')
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('edit_password');

Route::post('/edit_profile/{locale?}', 'ProfileController@editProfile')
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('post_edit_profile');

Route::post('/edit_password/{locale?}', 'ProfileController@editPassword')
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('post_edit_password');

/**
 * Event routes
 */
Route::get('/home/event/{event_name}/status/{locale?}', 'EventController@eventStatus')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('home_event_status');

/**
 * Admin routes
 */
Route::middleware(['auth', 'verified', 'admin_only'])->prefix('admin')->group(function () {

    Route::get('/{locale?}', 'AdminController@index')->where('locale', 'en|ru|cn')->name('admin_dashboard');
    Route::get('/edit_app/{event_name}/{app_id}/{user_id}', 'AdminController@doShowApplicationFormForUser')->where('locale', 'en|ru|cn')->name('show_form_for_user');
    Route::get('/edit_submit/{event_name}/{app_id}/{submit_id}', 'AdminController@doShowApplicationFormForSubmit')->name('show_form_for_submit');
    Route::post('/edit_app/{app_id}/{user_id}', 'AdminController@editApplicationDataForUser')->name('edit_app_for_user');

    Route::get('/events', 'AdminController@showEvents')->name('show_events');
    Route::get('/events/{event_name}/', 'AdminController@showEventInfo')->name('show_event_info');
    Route::get('/events/{event_name}/apps/{app_id}', 'AdminController@showAppInfo')->name('app_info');
    Route::get('/events/{event_name}/users', 'AdminController@showUsersInEvent')->name('users_in_event');
    Route::get('/events/{event_name}/users/{user_id}/{app_id}', 'AdminController@showUsersAppsInEvent')->name('users_apps_in_event');

    Route::get('/applications/{app_id}', 'ApplicationController@showAppAnswers')->name('show_app_answers');
    Route::post('/applications/{app_id}', 'ApplicationController@getAppAnswers')->name('get_app_answers');

    Route::get('/users/{user_id}', 'AdminController@showUserInfo')->name('user_info');
    Route::get('/users', 'AdminController@showUsers')->name('users');
    Route::get('/users/edit/{user_id}', 'AdminController@showEditUserForm')->name('show_edit_user_form');
    Route::post('/users/edit/{user_id}', 'AdminController@editUser')->name('edit_user');
    Route::get('/users/delete/{user_id}', 'AdminController@deleteUser')->name('delete_user');

    Route::post('/teams/edit/{team_id}', 'TeamController@editTeam')->name('edit_team');
    Route::post('/teams/users/unbind/{team_id}/{user_id}', 'TeamController@doUnbindUserFromTeam')->name('unbind_user');
    Route::get('/teams/{team_id}', 'TeamController@showEditTeamForm')->name('team_info');
    Route::get('/teams/edit/{team_id}', 'TeamController@showEditTeamForm')->name('show_edit_team_form');
});

/**
 * Submit routes
 */

Route::delete('/delete_file_from_app_submit/{application_id}', 'SubmitController@doDeleteFileFromApplicationSubmit')
    ->middleware('auth')
    ->middleware('verified')
    ->name('delete_file_from_app_submit');

/**
 * Team routes
 */
Route::get('add_team_member/{submit_id}', 'TeamController@doAddUserToTeam')
    ->middleware('signed')
    ->name('add_team_member');



Route::get('test/{loc?}', 'TestController@test')
    // ->middleware('signed')
    ->name('test');

Route::get('add_team_member_test/{submit_id}', 'TeamController@doAddUserToTeam')
    // ->middleware('signed')
    ->name('add_team_member_test');


/**
 * Auth
 */
Auth::routes(['verify' => true]);

Route::get('login/{locale?}', 'Auth\LoginController@showLoginForm')
    ->name('login');

Route::get('register/{locale?}', 'Auth\RegisterController@showRegistrationForm')
    ->name('register');

/**
 * Application routes
 */
Route::get('/home/event/{event_name}/app/{app_id}/{locale?}', 'ApplicationController@doShowApplicationForm')
    ->where('locale', 'en|ru|cn')
    ->middleware('verified')
    ->middleware('check_prev_submit')
    ->name('home_event_app');

Route::post('/add_app_inst/{application_id}/{locale}', 'ApplicationController@doCreateApplicationSubmit')
    ->where('locale', 'en|ru|cn')
    ->middleware('verified')
    ->name('add_app_inst');

/**
 * Payment routes
 */
Route::get('payment/{event_name}/{team_id}/{locale?}', 'PaymentController@showPaymentPage')
    ->where('locale', 'en|ru|cn')
    ->name('payment_page');
/* Route::get('payment/{event_name}/{team_id}', 'PaymentController@showPaymentPage')
    ->where('locale', 'en|ru|cn')
    ->name('payment_page'); */

Route::get('usd/payment/{event_name}/{team_id}/{locale?}', 'PaymentController@showUSDPaymentPage')
    ->where('locale', 'en|ru|cn')
    ->name('usd_payment_page');
/* Route::get('usd/payment/{event_name}/{team_name}', 'PaymentController@showUSDPaymentPage')
    ->where('locale', 'en|ru|cn')
    ->name('usd_payment_page'); */

Route::get('succes_payment', function () {
    return "success";
})->name('succes_payment');

Route::get('fail_payment', function () {
    return "fails";
})->name('fail_payment');

/* Route::post('payment/{event_name}/{locale?}', 'PaymentController@toPay')
    ->where('locale', 'en|ru|cn')
    ->name('payment_page'); */
