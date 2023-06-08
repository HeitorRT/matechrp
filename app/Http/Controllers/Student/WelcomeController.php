<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Content;
use Inertia\Response;

class WelcomeController extends Controller
{
    /**
     * @return Response
     */
    public function form(): Response
    {
        $contents = Content::all()->random(10);

        return inertia('Student/Welcome', [
            'contents' => $contents
        ]);
    }
}
