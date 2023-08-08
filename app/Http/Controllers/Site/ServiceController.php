<?php

namespace App\Http\Controllers\Site;

use App\DTO\ServicesDTO;
use App\Http\Controllers\Controller;
use Inertia\Response;

class ServiceController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        $services = (new ServicesDTO)->getAll();

        return inertia('Site/Services/Index', ['services' => $services]);
    }

    /**
     * @return Response
     */
    public function show(int $id): Response
    {
        return inertia('Site/Services/Show');
    }
}
