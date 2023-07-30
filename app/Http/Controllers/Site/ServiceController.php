<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return inertia('Site/Services/Index');
    }

    /**
     * @return Response
     */
    public function show(): Response
    {
        return inertia('Site/Services/Index');
    }
}
