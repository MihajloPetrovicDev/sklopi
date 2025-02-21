<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\BuilderController;
use App\Http\Controllers\GuestBuilderController;

Route::get('/', [PagesController::class, 'getHomePage'])->name('home');

Route::get('/my-builds', [BuilderController::class, 'getMyBuildsPage']);

Route::get('/login', [AuthController::class, 'getLoginPage'])->middleware('guest')->name('login');

Route::get('/register', [AuthController::class, 'getRegisterPage'])->middleware('guest');

Route::get('/my-account', [AuthController::class, 'getMyAccountPage'])->middleware('auth');

Route::get('/create-new-build', [BuilderController::class, 'getCreateNewBuildPage'])->middleware('auth');

Route::get('/build/{id}', [BuilderController::class, 'getBuild']);

Route::get('/guest-build', [GuestBuilderController::class, 'getGuestBuild'])->middleware('guest');

Route::get('/add-build-component', [BuilderController::class, 'getAddBuildComponent'])->middleware('auth');

Route::get('/build-component/{id}', [BuilderController::class, 'getBuildComponentPage'])->middleware('auth');

Route::get('/manage-delivery-groups', [BuilderController::class, 'manageDeliveryGroups'])->middleware('auth');

Route::get('/builds', [BuilderController::class, 'getBuildsPage']);

Route::get('/discussions', [BuilderController::class, 'getDiscussionsPage']);

Route::get('/add-guest-build-component', [GuestBuilderController::class, 'getAddGuestBuildComponentPage'])->middleware('guest');

Route::get('/guest-build-component', [GuestBuilderController::class, 'getGuestBuildComponentPage'])->middleware('guest');

Route::get('/terms-of-service', [PagesController::class, 'getTermsOfServicePage']);

Route::get('/privacy-policy', [PagesController::class, 'getPrivacyPolicyPage']);

Route::get('/forgot-your-password', [AuthController::class, 'getForgotYourPasswordPage'])->middleware('guest');

Route::get('/change-password/{token}', [AuthController::class, 'getChangePasswordPage']);

Route::get('/change-email', [AuthController::class, 'getChangeEmailPage'])->middleware('auth');

Route::get('/email-change-verification/{token}', [AuthController::class, 'getChangeEmailVerificationPage'])->middleware('auth');

Route::get('/redirect-to-buy-link', [PagesController::class, 'getRedirectToBuyLinkPage']);

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

Route::post('/api/generate-and-send-password-reset-link', [AuthController::class, 'generateAndSendPasswordResetLink']);

Route::post('/api/change-password', [AuthController::class, 'changePassword']);

Route::post('/api/generate-and-send-email-change-link', [AuthController::class, 'generateAndSendChangeEmailVerificationLink']);

Route::post('/api/change-email', [AuthController::class, 'changeEmail'])->middleware('auth');