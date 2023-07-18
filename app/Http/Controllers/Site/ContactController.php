<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Inertia\Response;

class ContactController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return inertia('Site/Contact/Index');
    }
}
