<?php

namespace App\Services;

use App\Models\User;
use App\Models\PasswordResetToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class AuthService {
    public function generatePasswordResetToken() {
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
            
            return response(['errors' => [
                'error' => [__('errors.change_password.token_expired')]
            ]], 400);
        }

        $user = User::where('email', $passwordResetToken->email)->firstOrFail();

        $user->password = Hash::make($newPassword);
        $user->save();

        $passwordResetToken->delete();
    }
}