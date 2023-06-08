<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use Inertia\Response;


class ChapterController extends Controller
{
    /**
     * @return Response
     */
    public function show(Chapter $chapter): Response
    {
        return inertia('Student/Chapter/Show', [
            'chapter' => $chapter
        ]);
    }
}
