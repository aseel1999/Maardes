<?php

use App\Http\Controllers\Api\AppController;
use App\Http\Controllers\Api\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
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

Route::group(['middleware' => 'auth:api'], function () {

});

    Route::post('/signUp', [UserController::class, 'signUp']);

Route::post('/signUp', [UserController::class, 'signUp']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/forgotPassword',[UserController::class,'forgotPassword']);
    Route::post('/changePassword',[UserController::class,'changePassword']);
    Route::get('myProfile',[UserController::class,'myProfile']);
    Route::post('/editUserProfile',[UserController::class,'editUserProfile']);
    Route::post('/editViewerAccount/{type}',[UserController::class,'editViewerAccount']);
    Route::post('/contactUs',[ContactController::class,'contactUs']);
    Route::post('/storeBlogs',[AppController::class,'storeBlogs']);
    Route::get('/blog/{blog}',[AppController::class,'Blog']);
    Route::post('/storeCompany',[AppController::class,'storeCompany']);
    Route::post('/storeDays',[AppController::class,'storeDays']);
    Route::post('/storeEvents',[AppController::class,'storeEvents']);
    Route::get('/viewDayEvents',[AppController::class,'viewDayEvents']);
    Route::post('/storeQuestionAnswers',[AppController::class,'storeQuestionAnswers']);
    Route::get('/viewQuestionAnswers',[AppController::class,'viewQuestionAnswers']);
    Route::post('/storeAbout',[AppController::class,'storeAbout']);
    Route::get('/viewAbout',[AppController::class,'viewAbout']);
    Route::post('/storeTicket',[AppController::class,'storeTicket']);
    Route::get('/viewTicketsUser/{user}',[AppController::class,'viewTicketsUser']);
    Route::get('allTickets',[AppController::class,'allTickets']);
    Route::post('/storePackage',[AppController::class,'storePackage']);
   Route::get('/companyUser',[AppController::class,'companyUser']);
   Route::get('/packageUser/{user}',[AppController::class,'packageUser']);
   Route::get('/getMaraad',[AppController::class,'getMaraad']);
   Route::get('/maraadViewrDetails/{user}',[AppController::class,'maraadViewrDetails']);
   Route::get('/organizerDetails',[AppController::class,'organizerDetails']);
   Route::get('/companyViewerDetails',[AppController::class,'companyViewerDetails']);
   Route::get('/companyRaeiDetails',[AppController::class,'companyRaeiDetails']);
   Route::get('/companyOrganizerDetails',[AppController::class,'companyOrganizerDetails']);
   Route::get('/companyPackageViewerDetails',[AppController::class,'companyPackageViewerDetails']);
   Route::get('/companyPackageRaeiDetails',[AppController::class,'companyPackageRaeiDetails']);
   Route::get('/packagesBelongMaared',[AppController::class,'packagesBelongMaared']);
   Route::post('/storeLocationWorks',[AppController::class,'storeLocationWorks']);
   Route::post('/storeLocationMaarad',[AppController::class,'storeLocationMaarad']);

   
   //Route::post('/storePackage',[AppController::class,'storePackage']);


   Route::get('/getMaraad',[AppController::class,'getMaraad']);
