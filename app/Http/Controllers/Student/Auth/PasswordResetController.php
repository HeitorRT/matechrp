<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Auth\PasswordResetRequest;
use App\Services\Student\PasswordService;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;


class PasswordResetController extends Controller
{
     /**
     * @var PasswordService
     */
    protected PasswordService $passwordService;

    /**
     * @param PasswordService $passwordService
     */
    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function form(Request $request): Response
    {
        return inertia('Student/Auth/ResetPassword', [
            'token' => $request->route('token'),
            'email' => $request->get('email')
        ]);
    }

    /**
     * @param PasswordResetRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(PasswordResetRequest $request): \Illuminate\Http\RedirectResponse
    {
        $responseOk = $this->passwordService->passwordReset(
            $request->get('email'),
            $request->get('password'),
            $request->get('password_confirmation'),
            $request->get('token'),
        );

        if (! $responseOk) {
            throw ValidationException::withMessages([
                'email' => 'Erro ao redefinir a senha.',
            ]);
        }

        return redirect()->route('student.auth.sign-in');
    }
}
