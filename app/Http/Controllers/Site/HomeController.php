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

        $topCarrousel = collect()->push([
            'image' => 'https://images.unsplash.com/photo-1614624532983-4ce03382d63d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2V0dXB8ZW58MHx8MHx8fDA%3D&w=1000&q=80'
        ])->push([
            'image' => 'https://images.unsplash.com/photo-1542315192-1f61a1792f33?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
        ])->push([
            'image' => 'https://images.unsplash.com/photo-1590212151175-e58edd96185b?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80',
        ])->push([
            'image' => 'https://images.unsplash.com/photo-1594636797501-ef436e157819?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80',
        ]);

        $ourProcesses = collect()->push([
            'title' => 'Como solicitar orçamento',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt nibh eget porta rhoncus. Vestibulum egestas vel nibh pretium dictum. Ut consequat ligula neque, non pulvinar ipsum blandit sed. Mauris sit amet nunc magna. Aenean sed volutpat ligula. Morbi gravida orci in nisl finibus rhoncus. Sed facilisis eros non justo imperdiet, id aliquam neque sagittis. Aliquam euismod sollicitudin lorem at mattis.'
        ])->push([
            'title' => 'Como solicitar orçamento',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt nibh eget porta rhoncus. Vestibulum egestas vel nibh pretium dictum. Ut consequat ligula neque, non pulvinar ipsum blandit sed. Mauris sit amet nunc magna. Aenean sed volutpat ligula. Morbi gravida orci in nisl finibus rhoncus. Sed facilisis eros non justo imperdiet, id aliquam neque sagittis. Aliquam euismod sollicitudin lorem at mattis.'
        ])->push([
            'title' => 'Como solicitar orçamento',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec tincidunt nibh eget porta rhoncus. Vestibulum egestas vel nibh pretium dictum. Ut consequat ligula neque, non pulvinar ipsum blandit sed. Mauris sit amet nunc magna. Aenean sed volutpat ligula. Morbi gravida orci in nisl finibus rhoncus. Sed facilisis eros non justo imperdiet, id aliquam neque sagittis. Aliquam euismod sollicitudin lorem at mattis.'
        ]);

        return inertia('Site/Home/Index', [
            'services' => $services,
            'topCarrousel' => $topCarrousel,
            'ourProcesses' => $ourProcesses
        ]);
    }

    /**
     * @return Response
     */
    public function soon(): Response
    {
        return inertia('Site/Home/Soon');
    }
}
