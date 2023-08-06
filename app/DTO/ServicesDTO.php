<?php

namespace App\DTO;

use Illuminate\Support\Collection;

/**
 * @property string $label
 * @property Collection $items
 * @property int $count
 */
class ServicesDTO
{
    public readonly Collection $items;

    public function __construct(){
        $items = (object) [(object) [
            'id' => 1,
            'title' => 'TELEVISORES E MONITORES',
            'text' => 'Conserto de TVs LED, LCD e Plasma. Atendemos: Samsung, LG, AOC, Philips e mais.',
            'srcImg' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTsKEby5TqpefnA9W9HynmMfxyxZLob_9nubA&usqp=CAU',
            'icon' => 'desktop_windows'
        ], (object) [
            'id' => 2,
            'title' => 'NOTEBOOKS E DESKTOPS',
            'text' => 'Formatação, limpeza e assistência completa para seu notebook ou desktop.',
            'srcImg' => 'https://c4.wallpaperflare.com/wallpaper/645/332/956/notebook-service-wallpaper-preview.jpg',
            'icon' => 'devices'
        ], (object) [
            'id' => 3,
            'title' => 'Limpeza',
            'text' => 'A limpeza e a troca de pasta térmica são fundamentais para garantir a vida útil e o bom funcionamento da sua máquina.',
            'srcImg' => 'https://static.wixstatic.com/media/1d9c31_e1357a383f63495e8633c0292a311443~mv2.jpg/v1/fill/w_517,h_509,al_c,lg_1,q_80,enc_auto/sdfc-758x424.jpg',
            'icon' => 'cleaning_services'
        ], (object) [
            'id' => 4,
            'title' => 'Upgrades de componentes',
            'text' => 'Realizamos upgrades em sua máquina, como a troca de HDD por SSD, aumento de memória RAM e substituição de placas de vídeo.',
            'srcImg' => 'https://static.wixstatic.com/media/1d9c31_9c4ced0f6e304762aae138c5e32677cd~mv2.webp',
            'icon' => 'trending_up'
        ], (object) [
            'id' => 5,
            'title' => 'Soluções para de notebook',
            'text' => 'Realizamos a troca e reparos de teclados, telas, touchpads e carcaças de notebooks.',
            'srcImg' => 'https://media.istockphoto.com/id/182470801/photo/smashed-laptop.jpg?s=612x612&w=0&k=20&c=LgJIhsvkMvIn08NES-G7lbM5zj8yrSTevoFoQkauWB4=',
            'icon' => 'laptop_windows'
        ], (object) [
            'id' => 6,
            'title' => ' Montagem de pc gamer',
            'text' => 'Você tem a opção de trazer suas próprias peças para montagem ou adquirir uma build personalizada conosco.',
            'srcImg' => 'https://static.wixstatic.com/media/1d9c31_325b8e5c53b34b74a19f6cd6365481b3~mv2.webp',
            'icon' => 'sports_esports'
        ]];
        
        $this->items = collect($items);
    }

    public function getAll(){
        return $this->items;
    }
}
