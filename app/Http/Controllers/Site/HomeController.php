<?php

namespace App\Http\Controllers\Site;

use App\DTO\ServicesDTO;
use App\Http\Controllers\Controller;
use Inertia\Response;

class HomeController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $services = (new ServicesDTO)->getAll();

        return inertia('Site/Home/Index', ['services' => $services]);
    }
}
