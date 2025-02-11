<?php

namespace App\Services;

use App\Models\User;
use App\Models\EmailChangeToken;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function generateToken() {
        $rawPasswordResetToken = bin2hex(random_bytes(32)).time();
        $passwordResetToken = hash_hmac('sha256', $rawPasswordResetToken, config('app.key'));

        return $passwordResetToken;
    }


    public function createPasswordResetToken($email, $token) {
        PasswordResetToken::where('email', $email)->delete();

        $passwordResetToken = new PasswordResetToken();
        $passwordResetToken->email = $email;
        $passwordResetToken->token = $token;
        $passwordResetToken->save();

        return $passwordResetToken;
    }


    public function changePassword($passwordResetToken, $newPassword) {
        $passwordResetToken = PasswordResetToken::where('token', $passwordResetToken)->first();

        if(now()->greaterThan($passwordResetToken->created_at->addMinutes(120))) {
            $passwordResetToken->delete();
            
            return response()->json(['errors' => [
                'error' => [__('errors.change_password.token_expired')]
            ]], 400);
        }

        $user = User::where('email', $passwordResetToken->email)->firstOrFail();
        $user->password = Hash::make($newPassword);
        $user->save();

        $passwordResetToken->delete();
    }


    public function createEmailChangeToken($newEmail, $token, $userId) {
        $existingEmailChangeToken = EmailChangeToken::where('user_id', $userId)->first();

        if($existingEmailChangeToken) {
            $existingEmailChangeToken->is_disabled = true;
            $existingEmailChangeToken->save();
        }

        $emailChangeToken = new EmailChangeToken();
        $emailChangeToken->new_email = $newEmail;
        $emailChangeToken->token = $token;
        $emailChangeToken->user_id = $userId;
        $emailChangeToken->save();

        return $emailChangeToken;
    }


    public function logOut() {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }


    public function changeEmail($token) {
        $emailChangeToken = EmailChangeToken::where('token', $token)->where('is_disabled', '!=', true)->firstOrFail();
        $user = User::find(Auth::id());

        if($emailChangeToken->user_id != $user->id) {
            return response()->json(['errors' => [
                'error' => [__('errors.change_email.access_forbiden')]
            ]], 400);
        }


        if(now()->greaterThan($emailChangeToken->created_at->addMinutes(120))) {
            $emailChangeToken->is_disabled = true;
            $emailChangeToken->save();
            
            return response()->json(['errors' => [
                'error' => [__('errors.change_email.token_expired')]
            ]], 400);
        }

        $emailChangeToken->is_disabled = true;
        $emailChangeToken->save();

        $user->email = $emailChangeToken->new_email;
        $user->save();
    }
}