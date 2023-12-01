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
        dd('aqui');
        
        $services = (new ServicesDTO)->getAll();

        // $topCarrouselImage = 'https://images.unsplash.com/photo-1614624532983-4ce03382d63d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxzZWFyY2h8Mnx8c2V0dXB8ZW58MHx8MHx8fDA%3D&w=1000&q=80';
        $topCarrouselImage = '/img/matechrp-logo.png';

        $ourProcesses = collect()->push([
            'title' => 'Atendimento',
            'text' => 'Acesso ao técnico para detalhes.<br><br> Orçamento Express.<br><br> Profissionais capacitados',
            'class' => 'text-center'
        ])->push([
            'title' => 'Orçamento',
            'text' => 'Realizamos o orçamento gratuito e sem compromisso para todos os serviços de conserto e manutenção de computadores e notebooks.',
            'class' => 'q-ml-sm text-left'
        ])->push([
            'title' => 'Garantia',
            'text' => 'Oferecemos garantia em todos os nossos serviços e produtos. Código de Defesa do Consumidor - Lei nº 8.078, de 11 de setembro de 1990.',
            'class' => 'q-ml-sm text-left'
        ])->push([
            'title' => 'Pense Verde',
            'text' => 'Repare seus eletrônicos ao invés de descartá-los. Ajude a natureza.',
            'class' => 'text-center'
        ]);

        return inertia('Site/Home/Index', [
            'services' => $services,
            'topCarrouselImage' => $topCarrouselImage,
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
