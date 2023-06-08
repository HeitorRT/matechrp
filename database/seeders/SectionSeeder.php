<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->fixedSections();
    }

    /**
     * Run the fixed sections.
     *
     * @return void
     */
    private function fixedSections()
    {
        Section::create([
            'name' => 'Destaques',
            'identifier' => 'Destaques',
            'can_delete' => false,
            'sort_number' => 1
        ]);

        Section::create([
            'name' => 'Lançamento',
            'identifier' => 'Lançamento',
            'can_delete' => false,
            'sort_number' => 2
        ]);

        Section::create([
            'name' => 'Mais vistos na semana',
            'identifier' => 'Mais vistos na semana',
            'can_delete' => false,
            'sort_number' => 3
        ]);

        Section::create([
            'name' => 'Indicados para você',
            'identifier' => 'Indicados para você',
            'can_delete' => false,
            'sort_number' => 4
        ]);

        Section::create([
            'name' => 'Minha lista',
            'identifier' => 'Minha lista',
            'can_delete' => false,
            'sort_number' => 5
        ]);

        Section::create([
            'name' => 'TOP 10',
            'identifier' => 'TOP 10',
            'can_delete' => false,
            'sort_number' => 6
        ]);

        Section::create([
            'name' => 'Continuar assistindo',
            'identifier' => 'Continuar assistindo',
            'can_delete' => false,
            'sort_number' => 7
        ]);

        Section::create([
            'name' => 'Últimos dias para assistir esse título',
            'identifier' => 'Últimos dias para assistir esse título',
            'can_delete' => false,
            'sort_number' => 8
        ]);

        Section::create([
            'name' => 'Treinamentos',
            'identifier' => 'Treinamentos',
            'can_delete' => false,
            'sort_number' => 9
        ]);
    }
}
