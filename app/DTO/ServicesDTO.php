<?php

namespace App\DTO;

use Illuminate\Support\Collection;

/**
 * @property Collection $items
 */
class ServicesDTO
{
    /**
     * @param Collection $items
     */
    public readonly Collection $items;

    public function __construct(){
        $items = (object) [(object) [
            'id' => 1,
            'title' => 'NOTEBOOKS',
            'text' => 'Consertos para notebooks. Executamos troca de carcaça, tela, dobradiça, teclado, HD, SSD, bateria, carregador, dc jack, wireless, touchpad, webcam, microfone, alto-falante.',
            'srcImg' => 'https://techinter.com.br/wp-content/uploads/2023/01/Melhores-notebooks-ate-2000-reais.jpg',
            'icon' => 'laptop_windows'
        ], (object) [
            'id' => 2,
            'title' => 'COMPUTADORES',
            'text' => 'Resolvemos problemas desde placa mãe, processador, memória, placa de vídeo, fonte, cooler, watercooler, hd, ssd, nvme, m2 sata, gabinete, atualização de bios, limpeza de hardware e instalação de sistema operacional.',
            'srcImg' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQwmVVL2DQnoKN66sIjmVRRhmsycOTi5Zo1nQ&usqp=CAU',
            'icon' => 'desktop_windows'
        ], (object) [
            'id' => 3,
            'title' => 'MONTAGEM DE PC GAMER',
            'text' => 'Você tem a opção de trazer suas próprias peças para montagem ou adquirir um pc gamer personalizado conosco. tenha seu computador montando por técnicos experientes e qualificados, obtendo o máximo de desempenho.',
            'srcImg' => 'https://static.wixstatic.com/media/1d9c31_325b8e5c53b34b74a19f6cd6365481b3~mv2.webp',
            'icon' => 'sports_esports'
        ], (object) [
            'id' => 4,
            'title' => 'EQUIPAMENTOS SEMI-NOVOS',
            'text' => 'Todos os nossos equipamentos passam por testes e inspeções realizados por técnicos capacitados, que garante o funcionamento. Equipamentos seminovos com qualidade e segurança, revisados e prontos para uso.',
            'srcImg' => 'https://portalselviria.com.br/wp-content/uploads/2020/08/DSC_0698.jpg',
            'icon' => 'reset_tv'
        ], (object) [
            'id' => 5,
            'title' => 'UPGRADE DE COMPONENTES',
            'text' => 'Se o seu computador não tem o mesmo desempenho de antes, fazer o upgrade de certas peças de sua configuração com certeza trará seu computador de volta a vida. ',
            'srcImg' => 'https://static.wixstatic.com/media/1d9c31_9c4ced0f6e304762aae138c5e32677cd~mv2.webp',
            'icon' => 'trending_up'
        ], (object) [
            'id' => 6,
            'title' => 'LIMPEZA DE HARDWARE',
            'text' => 'A manutenção preventiva garante uma vida útil maior e um melhor funcionamento dos dispositivos, evitando, por exemplo, o mau funcionamento do sistema ou a perda de componentes importantes, como processador, memória, placa de vídeo e fonte de alimentação. Deve ser realizada, independentemente de o computador apresentar problemas ou defeitos, pelo menos, uma vez por ano.',
            'srcImg' => 'https://static.wixstatic.com/media/1d9c31_e1357a383f63495e8633c0292a311443~mv2.jpg/v1/fill/w_517,h_509,al_c,lg_1,q_80,enc_auto/sdfc-758x424.jpg',
            'icon' => 'cleaning_services'
        ]];
        
        $this->items = collect($items);
    }

    public function getAll(){
        return $this->items;
    }

    public function getById(int $id){
        return $this->items->where('id', $id)->first();
    }
}
