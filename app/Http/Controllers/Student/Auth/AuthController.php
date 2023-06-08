<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use App\Services\Student\AuthService;
use Inertia\Response;

class AuthController extends Controller
{
    /**
     * @var AuthService
     */
    protected AuthService $authService;

    /**
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * @return Response
     */
    public function form(): Response
    {
        return inertia('Student/Auth/Login', [
            'status' => session('status'),
        ]);
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->authService->login($request->validated());

        return redirect()->route(RouteServiceProvider::STUDENT_HOME);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(): \Illuminate\Http\RedirectResponse
    {
        $this->authService->logout();

        return redirect()->route('student.auth.sign-in');
    }

    /**
     * @return Response
     */
    public function forgot(): Response
    {
        return inertia('Student/Auth/ForgotPassword');
    }


}
