<?php

namespace App\Services;

use App\Models\User;
use App\Mail\VerificationCodeMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserService
{
    /**
     * Register a new user.
     *
     * @param array $data
     * @return User
     */
    public function registerUser(array $data): User
    {
        $userId = $this->generateUniqueUserId(); // Helper method
        $verificationCode = rand(100000, 999999);

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => bcrypt($data['password']),
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'state' => $data['state'] ?? null,
            'country' => $data['country'] ?? null,
            'user_id' => $userId,
            'email_verification_code' => $verificationCode,
            'is_verified' => false,
        ]);

        // Send verification email
        Mail::to($user->email)->send(new VerificationCodeMail($verificationCode));

        return $user;
    }

    /**
     * Generate a unique user ID.
     *
     * @return string
     */
    private function generateUniqueUserId(): string
    {
        return 'USER-' . uniqid();
    }

    public function verifyEmail(array $data): bool
    {
        $user = User::where('email', $data['email'])
            ->where('email_verification_code', $data['verification_code'])
            ->first();

        if (!$user) {
            return false;
        }

        $user->update([
            'is_verified' => true,
            'email_verification_code' => null,
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        return true;
    }

    public function login(array $credentials): ?array
    {
        if (!$token = Auth::attempt($credentials)) {
            return null;
        }

        $user = Auth::user();
        $user->update(['last_login' => now()]);

        return [
            'token' => $token,
            'user_id' => $user->user_id,
            'expires_in' => Auth::factory()->getTTL() * 60,
        ];
    }

    /**
     * Get the authenticated user's profile data.
     *
     * @return array
     */
    public function getProfile(): array
    {
        $user = Auth::user();
        return [
            "user" => $user,
            "email" => $user->email,
        ];
    }

    /**
     * Refresh the user's authentication token.
     *
     * @return array
     */
    public function refreshToken(): array
    {
        $token = Auth::refresh();
        return [
            "token" => $token,
            "expires_in" => Auth::factory()->getTTL() * 60,
        ];
    }

    /**
     * Logout the authenticated user.
     *
     * @return void
     */
    public function logout(): void
    {
        Auth::logout();
    }

    /**
     * Fetch a user by their user_id.
     *
     * @param string $userId
     * @return User|null
     */
    public function getUserById(string $userId): ?User
    {
        return User::where('user_id', $userId)->first();
    }
}
