<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\Student;

class AuthStudentController extends Controller
{
    /**
     * @param Content $content
     * @return void
     */
    public function toggleContentInsideList(Content $content): void
    {
        /** @var Student */
        $authStudent = auth()->user();

        $isOnTheStudentList = $content->studentList()->wherePivot('student_id', $authStudent->id)->count();

        if ($isOnTheStudentList) {
            $content->studentList()->detach($authStudent->id);
        } else {
            $content->studentList()->attach($authStudent->id);
        }
    }
}
