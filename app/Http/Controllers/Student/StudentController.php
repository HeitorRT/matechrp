<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StudentUpdatePhotoRequest;
use App\Http\Resources\Student\StudentResource;
use App\Models\Student;
use App\Services\Student\AuthService;
use App\Services\Student\StudentService;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * @var StudentService
     */
    private StudentService $studentService;

    /**
     * @var AuthService
     */
    private AuthService $authService;

    /**
     * @param StudentService $studentService
     * @param AuthService $authService
     */
    public function __construct(StudentService $studentService, AuthService $authService)
    {
        $this->studentService = $studentService;
        $this->authService = $authService;
    }

    /**
     * @return Response
     */
    public function edit(): Response
    {
        /** @var Student $student */
        $student = Auth::guard('student')->user();

        return inertia('Student/Profile/Edit', [
            'student' => new StudentResource($student)
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resetPassword(): \Illuminate\Http\RedirectResponse
    {
        /** @var Student $student */
        $student = Auth::guard('student')->user();

        $url = url(config('app.url').route('student.password.reset', [
            'token' => app('auth.password.broker')->createToken($student),
            'email' => $student->email
        ], false));

        $this->authService->logout();

        return redirect()->to($url);
    }

    /**
     * @param StudentUpdatePhotoRequest $studentUpdatePhotoRequest
     * @return \Illuminate\Http\RedirectResponse
     */
    public function uploadPhoto(StudentUpdatePhotoRequest $studentUpdatePhotoRequest): \Illuminate\Http\RedirectResponse
    {
        /** @var Student $student */
        $student = Auth::guard('student')->user();

        $this->studentService->updatePhoto($student, $studentUpdatePhotoRequest->validated());

        return redirect()->route('student.edit-profile');
    }
}
