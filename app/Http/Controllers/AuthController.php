<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\ErrorService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $errorService;

    
    public function __construct(ErrorService $errorService)
    {
        $this->errorService = $errorService;
    }


    public function getLoginPage() {
        return view('login');
    }


    public function getRegisterPage() {
        return view('register');
    }


    public function getMyAccountPage() {
        return view('my_account');
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
            
            if(!Hash::check($requestData['password'], $user->password)) {
                return response()->json(['errors' => [
                    'error' => [__('errors.login.incorrect_password')]
                ]], 400);
            }

            Auth::login($user);

            return response()->json([], 200);
        }
        catch(Exception $e) {
            return $this->errorService->handleExceptionJSON($e);
        }
    }


    public function logOut() {
        Auth::logout();

        return redirect()->route('home');
    }
}