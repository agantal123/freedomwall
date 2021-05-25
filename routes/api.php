<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FWuserController;
use App\Http\Controllers\FWmobileController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


//Route::post('/loginfwuser', [FWmobileController::class, 'loginfWuser']);

//API ROUTE FOR AUTH
Route::post('/loginFWuser', [FWmobileController::class, 'loginFWuser']);
Route::post('/registerFWuser', [FWmobileController::class, 'registerFWuser']);
Route::post('/change_password', [FWmobileController::class, 'change_password']);

//API ROUTE FOR POST
Route::get('/getRecentPost', [FWmobileController::class, 'getRecentPost']);
Route::get('/getTrendingPost', [FWmobileController::class, 'getTrendingPost']);
Route::post('/store_post', [FWmobileController::class, 'store_post']);
Route::post('/deleteMyPost', [FWmobileController::class, 'deleteMyPost']);

//API ROUTE FOR USER PAGE
// Route::post('/viewcomment', 'mobileController@viewcomment');
// Route::post('/view_my_post', 'mobileController@store');
// Route::get('/view_my_post2', 'mobileController@store');

//API ROUTE FOR COMMENTS
Route::post('/viewFullpost', [FWmobileController::class, 'viewFullpost']);
Route::get('/view_comment', [FWmobileController::class, 'view_comment']);
Route::post('/store_comment', [FWmobileController::class, 'store_comment']);
Route::post('/deleteMyComment', [FWmobileController::class, 'deleteMyComment']);

//API ROUTE FOR VOTE
Route::get('/checkUpvotePost', [FWmobileController::class, 'checkUpvotePost']);
Route::get('/checkDownvotePost', [FWmobileController::class, 'checkDownvotePost']);
Route::post('/mobileUpvotePost', [FWmobileController::class, 'mobileUpvotePost']);
Route::post('/mobileDownvotePost', [FWmobileController::class, 'mobileDownvotePost']);

//ROUTE FOR NOTIFICATION
Route::get('/mobileUnreadNotificationCount', [FWmobileController::class, 'mobileUnreadNotificationCount']);
Route::get('/view_my_notification', [FWmobileController::class, 'view_my_notification']);
Route::post('/seen_notification', [FWmobileController::class, 'seen_notification']);

//Notificatioin Token
Route::post('/addTokenToUser', [FWmobileController::class, 'addTokenToUser']);
Route::post('/deleteMyToken', [FWmobileController::class, 'deleteMyToken']);


//Route::get('/test', 'mobileController@test');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

