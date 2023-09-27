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
            'title' => 'Atendimento',
            'text' => 'Acesso ao técnico para detalhes. Orçamento Express. Profissionais capacitados'
        ])->push([
            'title' => 'Orçamento',
            'text' => 'Realizamos o orçamento gratuito e sem compromisso para todos os serviços de conserto e manutenção de computadores e notebooks.'
        ])->push([
            'title' => 'Garantia',
            'text' => 'Oferecemos garantia em todos os nossos serviços e produtos. Código de Defesa do Consumidor - Lei nº 8.078, de 11 de setembro de 1990.'
        ])->push([
            'title' => 'Pense Verde',
            'text' => 'Repare seus eletrônicos ao invés de descartá-los. Ajude a natureza.'
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
