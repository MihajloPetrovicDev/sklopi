<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\GuestBuilderController;
use App\View\Components\GuestBuilder;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/my-builds', [BuilderController::class, 'getMyBuildsPage']);

Route::get('/login', [AuthController::class, 'getLoginPage'])->middleware('guest')->name('login');

Route::get('/register', [AuthController::class, 'getRegisterPage'])->middleware('guest');

Route::get('/my-account', [AuthController::class, 'getMyAccountPage'])->middleware('auth');

Route::get('/create-new-build', [BuilderController::class, 'getCreateNewBuildPage'])->middleware('auth');

Route::get('/build/{id}', [BuilderController::class, 'getBuild'])->middleware('auth');

Route::get('/guest-build', [GuestBuilderController::class, 'getGuestBuild'])->middleware('guest');

Route::get('/add-build-component', [BuilderController::class, 'getAddBuildComponent'])->middleware('auth');

Route::get('/build-component/{id}', [BuilderController::class, 'getBuildComponentPage'])->middleware('auth');

Route::get('/manage-delivery-groups', [BuilderController::class, 'manageDeliveryGroups'])->middleware('auth');

Route::get('/builds', [BuilderController::class, 'getBuildsPage']);

Route::get('/discussions', [BuilderController::class, 'getDiscussionsPage']);

Route::get('/add-guest-build-component', [GuestBuilderController::class, 'getAddGuestBuildComponentPage'])->middleware('guest');

Route::post('/api/register', [AuthController::class, 'register'])->middleware('guest');

Route::post('/api/login', [AuthController::class, 'login'])->middleware('guest');

Route::post('/api/log-out', [AuthController::class, 'logOut'])->middleware('auth');

Route::post('/api/create-new-build', [BuilderController::class, 'createNewBuild'])->middleware('auth');

Route::post('/api/get-build-delivery-groups', [BuilderCOntroller::class, 'getBuildDeliveryGroups'])->middleware('auth');

Route::post('/api/add-new-build-component', [BuilderController::class, 'addNewBuildComponent'])->middleware('auth');

Route::post('/api/create-new-delivery-group', [BuilderController::class, 'createNewDeliveryGroup'])->middleware('auth');

Route::post('/api/delete-build-component', [BuilderController::class, 'deleteBuildComponent'])->middleware('auth');

Route::post('/api/update-build-component', [BuilderController::class, 'updateBuildComponent'])->middleware('auth');

Route::delete('/api/delete-build/{id}', [BuilderController::class, 'deleteBuild'])->middleware('auth');

Route::post('/api/save-build-name', [BuilderController::class, 'saveBuildName'])->middleware('auth');

Route::post('/api/update-delivery-groups', [BuilderController::class, 'updateDeliveryGroups'])->middleware('auth');