<script setup>
    import { ref, computed, onMounted, watch } from 'vue';
    import { date } from 'quasar'
    import axios from "axios";
    import { usePage } from '@inertiajs/inertia-vue3';

    const authUser = computed(() => usePage().props.value.auth.user)

    const showNotifications = ref(false)

    const notifications = ref(false);

    const pusher = new Pusher('d115b284a9d9df8fddca', {
        cluster: 'us2'
    });

    var channel = pusher.subscribe(`pusher-notification-${authUser.value.id}`);

    channel.bind(`meu-evento-${authUser.value.id}`, function (data) {
        getNotifications();
    });

    const notShowMeThisNotification = (id) => {
        axios.put(route('student.notification.not-show-me-notification', id)).then(response => {
            markAsRead(id);
        });
    }

    const markAsRead = (id) => {
        axios.put(route('student.notification.make-notification-as-read', id)).then(response => {
            getNotifications();
        });
    }

    const markAllAsRead = () => {
        axios.put(route('student.notification.make-all-notification-as-read')).then(response => {
            getNotifications();
        });
    }

    const getNotifications = () => {
        axios.get(route('student.notification.index')).then(response => {
            notifications.value = [];

            response.data.notifications.forEach(element => {
                notifications.value.push({
                    id: element.id,
                    title: element.title,
                    text: element.text,
                    send_at_by_pusher: element.send_at_by_pusher ?? new Date(),
                    send_at_by_pusher_format: calculateDateDiff(element.send_at_by_pusher ?? new Date())
                });
            });
        });
    }

    const calculateDateDiff = (dateString) => {
        if (! dateString) {
            return '';
        }

        let diffInMinutes = date.getDateDiff(new Date(), new Date(dateString), 'minutes')

        if (diffInMinutes < 60) {
            return `Enviado a ${diffInMinutes} ${diffInMinutes === 1 ? 'minuto' : 'minutos'}`;
        }

        let diffInHours = date.getDateDiff(new Date(), new Date(dateString), 'hours')

        if (diffInHours < 24) {
            return `Enviado a ${diffInHours} ${diffInHours === 1 ? 'hora' : 'horas'}`;
        }

        let diffInDays = date.getDateDiff(new Date(), new Date(dateString), 'days')

        return `Enviado a ${diffInDays} ${diffInDays === 1 ? 'dia' : 'dias'}`;
    }

    watch(() => showNotifications.value, (show, prevShow) => {
        if (show) notifications.value.forEach(element => element.send_at_by_pusher_format = calculateDateDiff(element.send_at_by_pusher));
    })

    onMounted(() => {
        getNotifications();
        window.addEventListener('scroll', () => showNotifications.value = false);
    })

</script>

<template>
    <q-icon
        class="q-mx-sm cursor-pointer"
        size="28px"
        color="white"
        name="o_notifications"
    >
        <q-badge v-if="notifications.length > 0" rounded color="red" floating transparent>
            {{ notifications.length }}
        </q-badge>

        <q-menu
            v-model="showNotifications"
            :offset="[0, 5]"
            class="app-br-16 student-bg-dark"
            style="width: 674px;"
        >
            <div class="column q-pa-md">
                <div class="row justify-between q-pb-md q-px-md">
                    <div class="text-white app-fs-19 app-fw-700 app-lh-24">
                        Suas noticações
                    </div>

                    <q-icon
                        name="o_cancel"
                        size="24px"
                        color="white"
                        @click="showNotifications = false"
                        class="cursor-pointer"
                    />
                </div>

                <q-virtual-scroll v-if="notifications.length > 0"
                    style="max-height: 300px;"
                    :items="notifications"
                    separator
                    dark
                    v-slot="{ item: notification, index }"
                >
                    <q-item class="q-px-none cursor-pointer ">
                        <q-card class="transparent fit row" flat>
                            <q-card-section class="q-py-lg col-11" @click="markAsRead(notification.id)">
                                <div class="text-white app-fs-19 app-fw-700 app-lh-24 row justify-between">
                                    {{ notification.title }}
                                </div>
                                <div class="text-white app-fs-19 app-fw-400 app-lh-24 q-my-sm">
                                    {{ notification.text }}
                                </div>
                                <div class="student-text-grey app-fs-19 app-fw-400 app-lh-24">
                                    {{ notification.send_at_by_pusher_format }}
                                </div>
                            </q-card-section>

                            <q-card-section v-if="!notification.mandatory" class="flex justify-center cursor-pointer col-1">
                                <q-icon
                                    name="more_vert"
                                    size="24px"
                                    color="white"
                                >
                                    <q-menu
                                        :offset="[0, 5]"
                                        class="app-br-16 student-bg-purple"
                                        style="width: 460px;"
                                    >
                                        <div class="column q-pa-md">
                                            <div class="row q-px-md cursor-pointer" @click="notShowMeThisNotification(notification.id)" >
                                                <div class="text-white app-fs-19 app-fw-700 app-lh-24" >
                                                    Não receber mais este tipo de notificação.
                                                </div>
                                            </div>
                                        </div>
                                    </q-menu>
                                </q-icon>
                            </q-card-section>
                        </q-card>
                    </q-item>
                </q-virtual-scroll>

                <q-card v-else class="transparent fit row" flat>
                    <q-card-section class="q-py-lg cursor-pointer col-11">
                        <div class="text-white app-fs-19 app-fw-700 app-lh-24 row justify-center">
                            Sem notificação no momento.
                        </div>
                    </q-card-section>
                </q-card>

                <q-card v-if="notifications.length > 0" class="transparent fit row" flat>
                    <q-card-section class="q-py-lg col-11">
                        <small class="text-white cursor-pointer" @click="markAllAsRead()">
                            marcar todas como lido
                        </small>
                    </q-card-section>
                </q-card>
            </div>
        </q-menu>
    </q-icon>
</template>
