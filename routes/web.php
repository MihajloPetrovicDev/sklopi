<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuilderController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/my-builds', [BuilderController::class, 'getMyBuildsPage']);

Route::get('/login', [AuthController::class, 'getLoginPage'])->middleware('guest')->name('login');

Route::get('/register', [AuthController::class, 'getRegisterPage'])->middleware('guest');

Route::get('/my-account', [AuthController::class, 'getMyAccountPage'])->middleware('auth');

Route::get('/create-new-build', [BuilderController::class, 'getCreateNewBuildPage'])->middleware('auth');

Route::get('/build/{id}', [BuilderController::class, 'getBuild'])->middleware('auth');

Route::get('/guest-build', [BuilderController::class, 'getGuestBuild'])->middleware('guest');

Route::get('/add-build-component', [BuilderController::class, 'getAddBuildComponent'])->middleware('auth');

Route::get('/build-component/{id}', [BuilderController::class, 'getBuildComponentPage'])->middleware('auth');

Route::post('/api/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/api/login', [AuthController::class, 'login'])->middleware('guest');

Route::post('/api/log-out', [AuthController::class, 'logOut'])->middleware('auth');

Route::post('/api/create-new-build', [BuilderController::class, 'createNewBuild'])->middleware('auth');

Route::post('/api/get-build-delivery-groups', [BuilderCOntroller::class, 'getBuildDeliveryGroups'])->middleware('auth');

Route::post('/api/add-new-build-component', [BuilderController::class, 'addNewBuildComponent'])->middleware('auth');

Route::post('/api/create-new-delivery-group', [BuilderController::class, 'createNewDeliveryGroup'])->middleware('auth');

Route::post('/api/delete-build-component', [BuilderController::class, 'deleteBuildComponent'])->middleware('auth');

Route::post('/api/update-build-component', [BuilderController::class, 'updateBuildComponent'])->middleware('auth');