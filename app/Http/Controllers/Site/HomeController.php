<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return inertia('Site/Home/Index');
    }
}
