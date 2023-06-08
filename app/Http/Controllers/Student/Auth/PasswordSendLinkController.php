<?php

namespace App\Http\Controllers\Student\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\Auth\PasswordSendLinkRequest;
use App\Models\Student;
use App\Services\Student\PasswordService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class PasswordSendLinkController extends Controller
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
     * @return Response
     */
    public function form(): Response
    {
        return inertia('Student/Auth/ForgotPassword');
    }

    /**
     * @param PasswordSendLinkRequest $request
     * @return RedirectResponse
     */
    public function sendLink(PasswordSendLinkRequest $request) : RedirectResponse
    {
        $student = Student::where('email', $request->get('email'))->first();

        if (! $student) {
            throw ValidationException::withMessages([
                'email' => 'E-mail não encontrado.',
            ]);
        }

        if (! $this->passwordService->sendResetPasswordMail($student)) {
            throw ValidationException::withMessages([
                'send_reset_password_mail' => 'Erro ao enviar email. Tente novamente.',
            ]);
        }

        return redirect()->back();
    }
}
