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
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('home_event_status');

Route::get('/home/event/{event_name}/materials/{locale?}', 'EventController@showMaterialsPage')
    ->middleware('auth')
    ->middleware('verified')
    ->where('locale', 'en|ru|cn')
    ->name('home_event_materials');


/**
 * Admin routes
 */
Route::middleware(['auth', 'verified', 'admin_only'])->prefix('admin')->group(function () {

    Route::get('/{locale?}', 'AdminController@index')->where('locale', 'en|ru|cn')->name('admin_dashboard');

    Route::get('/edit_submit/{submit_id}/{locale?}', 'AdminController@doShowApplicationForm')->name('show_form_for_user');
    Route::post('/edit_app/{application_id}/{user_id}', 'ApplicationController@doCreateApplicationSubmit')->name('edit_app_for_user');

    Route::get('/events', 'AdminController@showEvents')->name('show_events');
    Route::get('/events/{event_name}/', 'AdminController@showEventInfo')->name('show_event_info');
    Route::get('/events/{event_name}/apps/{application_id}', 'AdminController@showAppInfo')->name('app_info');
    Route::get('/events/{event_name}/users', 'AdminController@showUsersInEvent')->name('users_in_event');
    Route::get('/events/{event_name}/upload_materials/{locale?}', 'AdminController@showUploadMaterialsPage')->name('upload_materials_page');

    Route::post('/events/{event_name}/upload_materials/{locale?}', 'AdminController@uploadMaterials')->name('upload_materials');
    Route::delete('/events/delete_materials', 'AdminController@deleteMaterials')->name('delete_materials');

    Route::get('/applications/{application_id}', 'AdminController@showAppAnswers')->name('show_app_answers');

    Route::get('/users/{user_id}', 'AdminController@showUserInfo')->name('user_info');
    Route::get('/users', 'AdminController@showUsers')->name('users');
    Route::get('/users/edit/{user_id}', 'AdminController@showEditUserForm')->name('show_edit_user_form');
    Route::post('/users/edit/{user_id}', 'AdminController@editUser')->name('edit_user');
    Route::post('/users/delete/{user_id}', 'AdminController@doDeleteUser')->name('delete_user');
    Route::get('/submits/delete/{submits_id}', 'AdminController@doDeleteSubmit')->name('delete_submit');
    Route::get('/submits/unbind/{user_id}/{submits_id}', 'AdminController@doUnbindUserFromSubmit')->name('unbind_from_submit');

    Route::post('/teams/edit/{team_id}', 'TeamController@editTeam')->name('edit_team');
    Route::post('/teams/delete/{team_id}', 'AdminController@doDeleteTeam')->name('delete_team');
    Route::post('/teams/users/unbind/{team_id}/{user_id}', 'TeamController@doUnbindUserFromTeam')->name('unbind_user');
    Route::get('/teams/{team_id}', 'TeamController@showEditTeamForm')->name('team_info');
    Route::get('/teams/edit/{team_id}', 'TeamController@showEditTeamForm')->name('show_edit_team_form');

    Route::get('/event_create_form', 'EventController@showEventCreateForm')->name('show_event_create_form');
    Route::get('/event_edit_form/{event_id}', 'EventController@showEventEditForm')->name('show_event_edit_form');
    Route::post('/create_event', 'EventController@doCreateEvent')->name('create_event');
    Route::post('/edit_event/{event_id}', 'EventController@doEditEvent')->name('edit_event');
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

Route::get('test/{locale?}', 'TestController@test')
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
Route::get('/home/event/{event_name}/app/{application_id}/{locale?}', 'ApplicationController@doShowApplicationForm')
    ->where('locale', 'en|ru|cn')
    ->middleware('auth')
    ->middleware('verified')
    ->middleware('check_prev_submit')
    ->name('home_event_app');

Route::post('/add_app_inst/{application_id}/{locale}', 'ApplicationController@doCreateApplicationSubmit')
    ->where('locale', 'en|ru|cn')
    ->middleware('auth')
    ->middleware('verified')
    ->name('add_app_inst');

/**
 * Payment routes
 */
Route::get('payment/{event_name}/{team_id}/{locale?}', 'PaymentController@showPaymentPage')
    ->where('locale', 'en|ru|cn')
    ->name('payment_page');

Route::get('payment_links/{event_name}/{locale?}', 'PaymentController@showPaymentLinks')
    ->middleware('auth')
    ->middleware('verified')
    ->middleware('team_member_only')
    ->where('locale', 'en|ru|cn')
    ->name('payment_links');

Route::get('usd/payment/{event_name}/{team_id}/{locale?}', 'PaymentController@showUSDPaymentPage')
    ->where('locale', 'en|ru|cn')
    ->name('usd_payment_page');

Route::get('succes_payment', function () {
    return "success";
})->name('succes_payment');

Route::get('fail_payment', function () {
    return "fails";
})->name('fail_payment');
