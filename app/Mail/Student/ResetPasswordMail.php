<?php

namespace App\Mail\Student;

use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Student
     */
    public Student $student;

    /**
     * @param string $token
     */
    public string $token;

    /**
     * Create a new message instance.
     *
     * @param Student $student
     * @param string $token
     * @return void
     */
    public function __construct(Student $student, string $token)
    {
        $this->student = $student;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $parameters = [
            'token' => $this->token,
            'email' => $this->student->email
        ];

        $url = url(config('app.url').route('student.password.reset', $parameters, false));

        return $this->subject('Redefinição de senha')
            ->markdown('student.mail.password.reset', [
                'url' => $url,
                'count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')
            ]);
    }
}
