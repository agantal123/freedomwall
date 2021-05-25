<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FWuserController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ViewFullPostController;
use App\Models\FWuser;

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

// Route::get('/', function () {
//     return view('pages.home');
// })->middleware(['auth'])->name('home');


// Route::get('/home', function () {
//     return view('pages.home');
// })->middleware(['auth'])->name('home');

// Route::get('/manageUser', function () {
//     return view('pages.manageUser');
// })->middleware(['auth'])->name('manageUser');



Route::get('/welcome', function () {
    return view('welcome');
})->middleware(['auth'])->name('welcome');

require __DIR__.'/auth.php';


//Routes for Manage User Page
// Route::get('/manageUser', [FWuserController::class, 'index'])->middleware(['auth'])->name('manageUser'); 
// Route::prefix('/manageUser')->group( function(){
//     Route::post('/store', [FWuserController::class, 'store'])->middleware(['auth']);
//     Route::delete('/{id}', [FWuserController::class, 'destroy'])->middleware(['auth']);
//     Route::get('/{id}', [FWuserController::class, 'viewUser'])->middleware(['auth']);
// });


Route::group(['middleware' => 'auth'], function()
{

//Route for Dashboard
Route::get('/', [dashboardController::class, 'index'])->name('home');
Route::get('/home', [dashboardController::class, 'index'])->name('home');
Route::resource('getposts', PostController::class)->middleware(['auth']);
Route::get('/filter', [dashboardController::class, 'dashboardsearch'])->name('dashboardsearch');


//Route for view full post
Route::get('post/{postData}', [ViewFullPostController::class, 'userpost'])->where('postData', '.*')->name('viewpost'); 
Route::get('trending/post/{postData}', [ViewFullPostController::class, 'viewPost_Notification'])->name('viewPost_Notification'); 
Route::post('deletePost/{id}', [ViewFullPostController::class, 'deletePost'])->name('deletePost');
Route::patch('approvePost/{id}', [ViewFullPostController::class, 'approvePost'])->name('approvePost');

//Route for Add new user in manage user page
Route::get('/manageUser/{any}', [FWuserController::class, 'view_user_page'])->middleware(['auth'])->where('any', '.*');
Route::get('/manageUser', [FWuserController::class, 'veiwPage'])->middleware(['auth'])->name('manageUser'); 
Route::resource('manageuserData', FWuserController::class)->middleware(['auth']);
Route::post('searchUser', [FWuserController::class, 'searchUser'])->middleware(['auth']); 

//Route for User page
Route::get('user/{userData}', [FWuserController::class, 'getUserdetails'])->where('userData', '.*')->middleware(['auth']); 
Route::patch('manageUser/updateUserpost/{userData}', [FWuserController::class, 'updateUserpost']); 
Route::delete('manageUser/destroyUserpost/{userData}', [FWuserController::class, 'destroyUserpost']); 

//Route for Notification
Route::get('adminNotification', [dashboardController::class, 'adminNotification'])->name('route.myNotification');
Route::get('getnotifications', [dashboardController::class, 'adminNotification'])->name('getmynotification');

});


