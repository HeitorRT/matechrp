<?php

return [
    [
        'items' => [
            [
                'route' => 'admin.home',
                'active' => 'admin.home*',
                'label' => 'Dashboard',
                'icon' => 'show_chart',
            ]
        ]
    ],
    [
        'label' => 'EVENTOS',
        'items' => [
            [
                'route' => 'admin.meeting.index',
                'active' => 'admin.meeting*',
                'label' => 'Encontros',
                'icon' => 'chat_bubble_outline',
                'can' => 'meeting_index'
            ],
            [
                'route' => 'admin.live-event.index',
                'active' => 'admin.live-event*',
                'label' => 'Eventos ao vivo',
                'icon' => 'wifi',
                'can' => 'live_event_index'
            ],
            [
                'route' => 'admin.campaign.index',
                'active' => 'admin.campaign*',
                'label' => 'Campanhas',
                'icon' => 'sym_o_import_contacts',
                'can' => 'campaign_index'
            ],
            [
                'route' => 'admin.schedule.index',
                'active' => 'admin.schedule*',
                'label' => 'Agenda',
                'icon' => 'o_calendar_today',
                'can' => 'schedule_index'
            ],
            [
                'route' => 'admin.quizz.index',
                'active' => 'admin.quizz*',
                'label' => 'Quizz',
                'icon' => 'o_edit',
                'can' => 'quizz_index'
            ],
            [
                'route' => 'admin.notification.index',
                'active' => 'admin.notification*',
                'label' => 'Notificações',
                'icon' => 'o_notifications',
                'can' => 'notification_index'
            ],
        ]
    ],
    [
        'label' => 'ADMINISTRATIVO',
        'items' => [
            [
                'route' => 'admin.commercial.index',
                'active' => 'admin.commercial*',
                'label' => 'Comercial',
                'icon' => 'language',
                'can' => 'commercial_index'
            ],
            [
                'route' => 'admin.financial.index',
                'active' => 'admin.financial*',
                'label' => 'Financeiro',
                'icon' => 'attach_money',
                'can' => 'financial_index'
            ],
        ]
    ],
    [
        'label' => 'CADASTROS',
        'items' => [
            [
                'route' => 'admin.content.index',
                'active' => 'admin.content*',
                'label' => 'Conteúdos',
                'icon' => 'o_local_movies',
                'can' => 'content_index'
            ],
            [
                'route' => 'admin.category.index',
                'active' => 'admin.category*',
                'label' => 'Categorias',
                'icon' => 'format_align_left',
                'can' => 'category_index'
            ],
            [
                'route' => 'admin.section.index',
                'active' => 'admin.section*',
                'label' => 'Seções',
                'icon' => 'grid_view',
                'can' => 'section_index'
            ],
            [
                'route' => 'admin.product.index',
                'active' => 'admin.product*',
                'label' => 'Produto',
                'icon' => 'local_mall',
                'can' => 'product_index'
            ],
            [
                'route' => 'admin.item.index',
                'active' => 'admin.item*',
                'label' => 'Brindes',
                'icon' => 'card_giftcard',
                'can' => 'item_index'
            ],
            [
                'route' => 'admin.student.index',
                'active' => 'admin.student*|admin.role*',
                'label' => 'Alunos',
                'icon' => 'o_school',
                'can' => ['student_index', 'group_index']
            ],
            [
                'route' => 'admin.user.index',
                'active' => 'admin.user*|admin.role*',
                'label' => 'Usuários',
                'icon' => 'o_group',
                'can' => ['user_index', 'role_index']
            ],
            [
                'route' => 'admin.job-vacancy.index',
                'active' => 'admin.job-vacancy*',
                'label' => 'Vagas',
                'icon' => 'work_outline',
                'can' => 'job_vacancy_index'
            ],
            [
                'route' => 'admin.indication.index',
                'active' => 'admin.indication*',
                'label' => 'Indicações',
                'icon' => 'alternate_email',
                'can' => 'indication_index'
            ],
            [
                'route' => 'admin.popup.index',
                'active' => 'admin.popup*',
                'label' => 'Pop-ups',
                'icon' => 'dynamic_feed',
                'can' => 'popup_index'
            ],
            [
                'route' => 'admin.common-question.index',
                'active' => 'admin.common-question*',
                'label' => 'F.A.Q.',
                'icon' => 'help_outline',
                'can' => 'common_question_index'
            ],
        ],
    ],
    [
        'label' => 'SISTEMA',
        'items' => [
            [
                'route' => 'admin.system-setting.index',
                'active' => 'admin.system-setting*',
                'label' => 'Configurações',
                'icon' => 'o_settings',
                'can' => 'system_setting_index'
            ]
        ]
    ],
];