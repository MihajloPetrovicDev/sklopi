<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\ChangeEmailMail;
use App\Services\AuthService;
use App\Mail\RegistrationMail;
use App\Services\ErrorService;
use App\Mail\ChangePasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    protected $errorService;
    protected $authService;

    
    public function __construct(ErrorService $errorService, AuthService $authService)
    {
        $this->errorService = $errorService;
        $this->authService = $authService;
    }


    public function getLoginPage() {
        return view('login');
    }


    public function getRegisterPage() {
        return view('register');
    }


    public function getMyAccountPage() {
        $user = Auth::user();

        return view('my_account', compact('user'));
    }


    public function register(Request $request) {
        if($request['password'] !== $request['confirmPassword']) {
            return response()->json(['errors' => [
                'error' => [__('errors.register.passwords_dont_match')]
            ]], 400);
        }

        $requestData = $request->validate([
            'username' => ['required', 'min: 3', 'max: 20', 'unique:users,username'],
            'email' => ['required', 'email', 'max: 80', 'unique:users,email'],
            'password' => ['required', 'min: 5', 'max: 80', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
            'tosPrivacyPolicyCheck' => ['accepted'],
        ], 
        [
            'username.unique' => __('errors.register.username_taken'),
            'email.unique' => __('errors.register.email_already_in_use'),
            'username.min' => __('errors.register.username_min'),
            'username.max' => __('errors.register.username_max'),
            'email.max' => __('errors.register.email_max'),
            'password.min' => __('errors.register.password_min'),
            'password.max' => __('errors.register.password_max'),
            'email.email' => __('errors.register.email_email'),
            'username.required' => __('errors.register.username_required'),
            'email.required' => __('errors.register.email_required'),
            'password.required' => __('errors.register.password_required'),
            'password.regex' => __('errors.register.password_regex'),
            'tosPrivacyPolicyCheck.accepted' => __('errors.register.tos_privacy_policy_check_accepted'),
        ]);

        try {
            $user = new User();
            $user->username = $requestData['username'];
            $user->email = $requestData['email'];
            $user->password = Hash::make($requestData['password']);
            $user->save();

            Auth::login($user);

            Mail::to($user->email)->send(new RegistrationMail($user));

            return response()->json([], 201);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function login(Request $request) {
        $requestData = $request->validate([
            'email' => ['required', 'email', 'max: 80', 'exists:users,email'],
            'password' => ['required', 'min: 5', 'max: 80'],
            'redirectTo' => ['nullable'],
        ], 
        [
            'email.max' => __('errors.login.email_isnt_in_use'),
            'email.email' => __('errors.login.email_isnt_in_use'),
            'email.required' => __('errors.login.email_required'),
            'email.exists' => __('errors.login.email_isnt_in_use'),
            'password.min' => __('errors.login.incorrect_password'),
            'password.max' => __('errors.login.incorrect_password'),
            'password.required' => __('errors.login.password_required'),
        ]);

        try {
            $user = User::where('email', $requestData['email'])->first();
            $redirectTo = $requestData['redirectTo'] ?? '/';
            
            if(!Hash::check($requestData['password'], $user->password)) {
                return response()->json(['errors' => [
                    'error' => [__('errors.login.incorrect_password')]
                ]], 400);
            }

            Auth::login($user);

            return response()->json([
                'redirectTo' => $redirectTo
            ], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function logOut() {
        $this->authService->logOut();

        return redirect()->route('home');
    }


    public function getForgotYourPasswordPage() {
        return view('forgot_your_password');
    }


    public function getChangePasswordPage() {
        return view('change_password');
    }


    public function generateAndSendPasswordResetLink(Request $request) {
        
        $requestData = $request->validate([
            'email' => ['required', 'email', 'max: 80', 'exists:users,email'],
        ], 
        [
            'email.max' => __('errors.forgot_your_password.email_isnt_in_use'),
            'email.email' => __('errors.forgot_your_password.email_email'),
            'email.required' => __('errors.forgot_your_password.email_required'),
            'email.exists' => __('errors.forgot_your_password.email_exists'),
        ]);

        try {
            $user = User::where('email', $requestData['email'])->first();
            $passwordResetToken = $this->authService->generateToken();

            DB::beginTransaction();

            $passwordResetTokenObject = $this->authService->createPasswordResetToken($user->email, $passwordResetToken);

            $changePasswordUrl = config('app.url').'/change-password/'.$passwordResetTokenObject->token;
            Mail::to($user->email)->send(new ChangePasswordMail($user, $changePasswordUrl));

            DB::commit();
            return response()->json([], 200);
        }
        catch(Exception $e) {
            DB::rollback();
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function changePassword(Request $request) {
        if($request['newPassword'] !== $request['confirmNewPassword']) {
            return response()->json(['errors' => [
                'error' => [__('errors.change_password.new_passwords_dont_match')]
            ]], 400);
        }

        $requestData = $request->validate([
            'newPassword' => ['required', 'min: 5', 'max: 80', 'regex:/[a-zA-Z]/', 'regex:/[0-9]/'],
            'passwordResetToken' => ['required', 'min:64', 'max:64', 'exists:password_reset_tokens,token'],   //64 is the length of the HMAC password reset token
        ],
        [
            'newPassword.min' => __('errors.change_password.new_password_min'),
            'newPassword.max' => __('errors.change_password.new_password_max'),
            'newPassword.required' => __('errors.change_password.new_password_required'),
            'newPassword.regex' => __('errors.change_password.new_password_regex'),
            'passwordResetToken.required' => __('errors.change_password.password_reset_token_required'),
            'passwordResetToken.min' => __('errors.change_password.password_reset_token_min'),
            'passwordResetToken.max' => __('errors.change_password.password_reset_token_max'),
            'passwordResetToken.exists' => __('errors.change_password.password_reset_token_exists'),
        ]);

        DB::beginTransaction();

        try {
            $this->authService->changePassword($requestData['passwordResetToken'], $requestData['newPassword']);

            DB::commit();

            Auth::logoutOtherDevices($requestData['newPassword']);
            $this->authService->logOut();

            return response([], 200);
        }
        catch(Exception $e) {
            DB::rollback();
            $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getChangeEmailPage() {
        return view('change_email');
    }


    public function generateAndSendChangeEmailVerificationLink(Request $request) {
        $requestData = $request->validate([
            'newEmail' => ['required', 'email', 'max: 80', 'unique:users,email'],
        ],
        [
            'newEmail.required' => __('errors.generate_and_send_change_email_verification_link.new_email_required'),
            'newEmail.email' => __('errors.generate_and_send_change_email_verification_link.new_email_email'),
            'newEmail.max' => __('errors.generate_and_send_change_email_verification_link.new_email_max'),
            'newEmail.unique' => __('errors.generate_and_send_change_email_verification_link.new_email_unique'),
        ]);

        try {
            $user = Auth::user();
            $emailChangeToken = $this->authService->generateToken();

            DB::beginTransaction();

            $emailChangeTokenObject = $this->authService->createEmailChangeToken($requestData['newEmail'], $emailChangeToken, $user->id);

            $emailChangeVerificationLink = config('app.url').'/email-change-verification/'.$emailChangeTokenObject->token;
            Mail::to($user->email)->send(new ChangeEmailMail($user, $emailChangeVerificationLink));

            DB::commit();
            return response()->json([], 200);
        }
        catch(Exception $e) {
            DB::rollback();
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function getChangeEmailVerificationPage($token) {
        return view('change_email_verification');
    }


    public function changeEmail(Request $request) {
        $requestData = $request->validate([
            'emailChangeToken' => ['required', 'min:64', 'max:64', 'exists:email_change_tokens,token'],   //64 is the length of the HMAC email change token
        ],
        [
            'emailChangeToken.required' => __('errors.change_email.email_change_token_required'),
            'emailChangeToken.min' => __('errors.change_email.email_change_token_min'),
            'emailChangeToken.max' => __('errors.change_email.email_change_token_max'),
            'emailChangeToken.exists' => __('errors.change_email.email_change_token_exists'),
        ]);

        try {
            return $this->authService->changeEmail($requestData['emailChangeToken']);

            return response()->json([], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }
}