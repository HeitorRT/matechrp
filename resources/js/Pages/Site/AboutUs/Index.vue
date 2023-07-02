<script setup>
    import MainLayout from '@/Layouts/Site/MainLayout.vue';
    import { Head } from '@inertiajs/inertia-vue3';
    import { scroll } from 'quasar'

    const { getScrollTarget, setVerticalScrollPosition } = scroll

    const scrollToElement = (idElement) => {
        const element = document.getElementById(idElement);
        const target = getScrollTarget(element)
        const offset = element.offsetTop
        const duration = 1000
        setVerticalScrollPosition(target, offset, duration)
    }
</script>

<template>
    <Head title="Home"/>

    <MainLayout>
        <div class="row">
            <div class="site-container-core bg-blue column justify-end q-pb-xl" style="height: 300px;">
                <div class="column">
                    <div class="text-white app-fs-40 app-fw-650">
                        QUEM SOMOS
                    </div>

                    <q-breadcrumbs class="text-white" separator="|">
                        <q-breadcrumbs-el 
                            label="Nossa história" 
                            class="text-white text-uppercase cursor-pointer" 
                            @click="scrollToElement('our_story')"
                        />
                        <q-breadcrumbs-el 
                            label="Garantia" 
                            class="text-white text-uppercase cursor-pointer"
                            @click="scrollToElement('guarantee')"
                        />

                        <q-breadcrumbs-el
                            label="Regras da garantia" 
                            class="text-white text-uppercase cursor-pointer"
                            @click="scrollToElement('guarantee_rules')"
                        />
                    </q-breadcrumbs>
                </div>

                <div class="text-white app-fs-18 q-mt-lg">
                    Saiba mais sobre nossa história e nossas parcerias.
                </div>
            </div>

            <div 
                id="our_story"
                class="flex flex-center q-py-xl site-container-our-history site-container-core"
            >
                <div class="q-mb-xl">
                    <div class="text-uppercase text-white app-fs-25 app-fw-650 q-mb-lg">
                        Nossa história
                    </div>
    
                    <div class="text-white app-fs-15 app-fw-200">
                        Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                    </div>
                </div>

                <q-img
                    src="/img/brands/hp.png"
                    class="site-brand"
                />

                <q-img
                    src="/img/brands/acer.png"
                    class="site-brand"
                />

                <q-img
                    src="/img/brands/dell.png"
                    class="site-brand"
                />

                <q-img
                    src="/img/brands/apple.png"
                    class="site-brand"
                />
            </div>

            <div 
                id="guarantee"
                class="site-container-core column flex-center q-py-xl"
            >
                <div class="app-fs-25 app-fw-650 text-center q-mb-xl">
                    1 ANO DE GARANTIA
                </div>

                <div class="app-fs-15 app-fw-300 text-justify">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
            </div>

            <div class="site-container-core site-container-guarantee-banner column flex-center container-with-photo-2 q-py-xl">
                <div class="app-fs-35 app-fw-350 text-center">
                    A garantia de quem confia no que faz
                </div>

                <div class="app-fs-35 app-fw-650 text-center text-uppercase">
                    Só a Matechrp tem!
                </div>
            </div>

            <div 
                id="guarantee_rules"
                class="site-container-core column flex-center q-py-xl"
            >
                <div class="app-fs-25 app-fw-650 text-center q-mb-xl">
                    CONHEÇA AS REGRAS DA NOSSA GARANTIA
                </div>

                <div class="app-fs-15 app-fw-200 text-center">
                    - O cliente não pagará pelos serviços realizados no equipamento durante o período de 1 ano, a partir da data do primeiro reparo.
                </div>

                <div class="app-fs-15 app-fw-300 text-center">
                    - A garantia NÃO inclui peças, somente os serviços (reparos e mão de obra). Caso seja necessária alguma peça de reposição o custo fica por conta do cliente.
                </div>

                <div class="app-fs-15 app-fw-300 text-center">
                    - Para TVs onde o fabricante não produz mais peças a garantia será de apenas 3 meses. Dentro desse prazo, se não houver possibilidade de um novo reparo, o cliente receberá seu dinheiro de volta.
                </div>

                <div class="app-fs-15 app-fw-300 text-center">
                    - Na manutenção de computadores a garantia NÃO inclui a reinstalação do sistema operacional, exceto para trocas de HD.
                </div>

                <div class="app-fs-15 app-fw-300 text-center">
                    - Garantia apenas no balcão, não inclui entrega, coleta ou deslocamento até o local.
                </div>
            </div>
        </div>
    </MainLayout>
</template>
