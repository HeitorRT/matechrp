<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Inertia\Response;

class DownloadController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return inertia('Site/Download/Index');
    }
}
