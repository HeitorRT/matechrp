<?php

namespace App\Services\Student;

use App\Mail\Student\ResetPasswordMail;
use App\Mail\Student\StudentCreatedMail;
use App\Models\Student;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class PasswordService
{
    /**
     * @param Student $student
     * @return string
     */
    private function generateToken(Student $student): string
    {
        return app('auth.password.broker')->createToken($student);
    }

    /**
     * @param Student $student
     * @return boolean
     */
    public function sendResetPasswordMail(Student $student): bool
    {
        try {
            Mail::to($student->email)->send(new ResetPasswordMail($student, $this->generateToken($student)));

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

     /**
     * @param Student $student
     * @return boolean
     */
    public function sendCreatedMail(Student $student): bool
    {
        try {
            Mail::to($student->email)->send(new StudentCreatedMail($student, $this->generateToken($student)));

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @param string $password_confirmation
     * @param string $token
     * @return bool
     */
    public function passwordReset(string $email, string $password, string $password_confirmation, string $token): bool
    {
        $status = Password::broker('students')->reset([
                'email' => $email,
                'password' => $password,
                'password_confirmation' => $password_confirmation,
                'token' => $token
            ],
            function (Student $student, $password){
                $student->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($student));

                Auth::guard('student')->login($student);
            }
        );

        return $status == Password::RESET_LINK_SENT;
    }
}
