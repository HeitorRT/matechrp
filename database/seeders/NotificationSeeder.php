<?php

namespace Database\Seeders;

use App\Models\Notification;
use Illuminate\Database\Seeder;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notification::create([
            'identifier' => 'Agendamento cancelado',
            'name' => 'Agendamento cancelado',
            'mandatory' => true,
            'send_by_email' => true,
            'send_by_whatsapp' => true,
            'send_by_sms' => true,
            'send_by_pusher' => true,
            'content_pusher' => 'Conteúdo para enviar via pusher',
            'content_email' => 'Conteúdo para enviar via email',
            'content_sms' => 'Conteúdo para enviar via sms',
            'content_whatsapp' => 'Conteúdo para enviar via WhatsApp',
        ]);

        Notification::create([
            'identifier' => 'Agendamento próximo',
            'name' => 'Agendamento próximo',
            'mandatory' => true,
            'send_by_email' => true,
            'send_by_whatsapp' => true,
            'send_by_sms' => true,
            'send_by_pusher' => true,
            'content_pusher' => 'Conteúdo para enviar via pusher',
            'content_email' => 'Conteúdo para enviar via email',
            'content_sms' => 'Conteúdo para enviar via sms',
            'content_whatsapp' => 'Conteúdo para enviar via WhatsApp',
        ]);

        Notification::create([
            'identifier' => 'Novo agendamento',
            'name' => 'Novo agendamento',
            'mandatory' => true,
            'send_by_email' => true,
            'send_by_whatsapp' => true,
            'send_by_sms' => true,
            'send_by_pusher' => true,
            'content_pusher' => 'Conteúdo para enviar via pusher',
            'content_email' => 'Conteúdo para enviar via email',
            'content_sms' => 'Conteúdo para enviar via sms',
            'content_whatsapp' => 'Conteúdo para enviar via WhatsApp',
        ]);

        Notification::create([
            'identifier' => 'Pagamento realizado',
            'name' => 'Pagamento realizado',
            'mandatory' => true,
            'send_by_email' => true,
            'send_by_whatsapp' => true,
            'send_by_sms' => true,
            'send_by_pusher' => true,
            'content_pusher' => 'Conteúdo para enviar via pusher',
            'content_email' => 'Conteúdo para enviar via email',
            'content_sms' => 'Conteúdo para enviar via sms',
            'content_whatsapp' => 'Conteúdo para enviar via WhatsApp',
        ]);

        Notification::create([
            'identifier' => 'Pagamento atrasado',
            'name' => 'Pagamento atrasado',
            'mandatory' => true,
            'send_by_email' => true,
            'send_by_whatsapp' => true,
            'send_by_sms' => true,
            'send_by_pusher' => true,
            'content_pusher' => 'Conteúdo para enviar via pusher',
            'content_email' => 'Conteúdo para enviar via email',
            'content_sms' => 'Conteúdo para enviar via sms',
            'content_whatsapp' => 'Conteúdo para enviar via WhatsApp',
        ]);

    }
}
