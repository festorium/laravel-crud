<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Http\Requests\LoginRequest;
use App\Services\userService;
use App\Models\SystemLog;


class ApiController extends Controller
{

    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    // Register API - POST (name, email, password)
    /**
     * Verify email.
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->registerUser($request->validated());

            return apiResponse(
                $user, 
                'User registered successfully. Please check your email for the verification code.', 
                201 
            ); 
        } catch (\Exception $e) {
            \Log::error($e); // Log the exception for debugging

            return apiErrorResponse('Registration failed. Please try again.', 500, [
                'error' => 'An unexpected error occurred.', 
            ]); 
        }
    }

    /**
     * Verify email.
     *
     * @param VerifyEmailRequest $request
     * @return JsonResponse
    */
    public function verifyEmail(VerifyEmailRequest $request): JsonResponse
    {
        $isVerified = $this->userService->verifyEmail($request->validated());

        if (!$isVerified) {
            return apiErrorResponse('Invalid verification code.', 400);
        }

        return apiResponse([], 'Email verified successfully!');
    }

    /**
     * Login user.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        $loginData = $this->userService->login($credentials);

        if (!$loginData) {
            return apiErrorResponse('Invalid login details', 401);
        }

        return apiResponse($loginData, 'User logged in successfully.');
    }

    // Profile API - GET (JWT Auth Token)
    public function profile(): JsonResponse
    {
        $profileData = $this->userService->getProfile();
        return apiResponse($profileData, "Profile data retrieved successfully.");
    }

    /**
     * Refresh the user's authentication token.
     *
     * @return JsonResponse
     */
    public function refreshToken(): JsonResponse
    {
        $tokenData = $this->userService->refreshToken();
        return apiResponse($tokenData, "Token refreshed successfully.");
    }

    /**
     * Logout the authenticated user.
     *
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        $this->userService->logout();
        return response()->json([
            "status" => true,
            "message" => "User logged out successfully.",
        ]);
    }

    /**
     * Get a user by their user_id.
     *
     * @param string $userId
     * @return JsonResponse
     */
    public function getUser(string $userId): JsonResponse
    {
        $user = $this->userService->getUserById($userId);

        if (!$user) {
            return response()->json([
                "status" => false,
                "message" => "User not found.",
            ], 404);
        }

        return response()->json([
            "status" => true,
            "data" => $user,
        ]);
    }

    public function getLogs()
    {
        $logs = SystemLog::with('user')->latest()->get();

        return response()->json([
            'status' => true,
            'data' => $logs
        ]);
    }

}
