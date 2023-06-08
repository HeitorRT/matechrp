<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    const COMMOM_PERMISSIONS = [
        'index' => 'Listar',
        'store' => 'Cadastrar',
        'update' => 'Editar',
        'destroy' => 'Excluir'
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->commonPermission('conteúdos', 'content');
        $this->commonPermission('campanhas', 'campaign');
        $this->commonPermission('categorias', 'category');
        $this->commonPermission('usuários', 'user');
        $this->commonPermission('grupos', 'group');
        $this->commonPermission('brindes', 'item');
        $this->commonPermission('seções', 'section');
        $this->commonPermission('vagas', 'job_vacancy');
        $this->commonPermission('indicações', 'indication');
        $this->commonPermission('perguntas frenquêntes', 'common_question');
        $this->commonPermission('encontros', 'meeting');
        $this->commonPermission('eventos ao vivo', 'live_event');
        $this->commonPermission('quizz', 'quizz');
        $this->commonPermission('grupos de permissão', 'role');
        $this->commonPermission('alunos', 'student');
        $this->commonPermission('produtos', 'product');
        $this->commonPermission('popups', 'popup');
        $this->commonPermission('notificações', 'notification', ['index', 'update']);
        $this->commonPermission('configurações do sistema', 'system_setting', ['index', 'update']);
        $this->commonPermission('agenda', 'schedule', 'index');
        $this->commonPermission('financeiro', 'financial', 'index');
        $this->commonPermission('comercial', 'commercial', 'index');
        $this->commonPermission('pedidos', 'order', ['index', 'store', 'update']);

        Permission::query()->updateOrCreate([
            "key" => "order_cancel"
        ], [
            'label' => "Cancelar pedido",
            "key" => "order_cancel",
            "level" => 'Pedidos'
        ]);

        Permission::query()->updateOrCreate([
            "key" => "meeting_start_finish"
        ], [
            'label' => "Iniciar/finalizar encontro",
            "key" => "meeting_start_finish",
            "level" => 'Encontros'
        ]);

        Permission::query()->updateOrCreate([
            "key" => "meeting_detach_student"
        ], [
            'label' => "Retirar aluno do encontro",
            "key" => "meeting_detach_student",
            "level" => 'Encontros'
        ]);

        Permission::query()->updateOrCreate([
            "key" => "meeting_individual_view"
        ], [
            'label' => "Visualizar agendamentos individuais",
            "key" => "meeting_individual_view",
            "level" => 'Encontros'
        ]);
    }

    /**
     * @param string $name
     * @param string $partOfKey
     * @param array $except
     * @return void
     */
    private function commonPermission(string $name, string $partOfKey, array|string|null $only = null): void
    {
        foreach ($only ? Arr::only(self::COMMOM_PERMISSIONS, $only) : self::COMMOM_PERMISSIONS as $key => $label) {
            Permission::query()->updateOrCreate([
                "key" => "{$partOfKey}_{$key}",
            ],[
                'label' => "{$label} {$name}",
                "key" => "{$partOfKey}_{$key}",
                "level" => Str::ucfirst($name)
            ]);
        }
    }
}
