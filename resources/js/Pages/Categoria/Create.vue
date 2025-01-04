<script setup>
    import { ref } from 'vue';
    import SubmitButton from '@/Components/SubmitButton.vue';
    import ImputQuasar from '@/Components/InputQuasar.vue';
    import PrimaryButton from '@/Components/PrimaryButton.vue';
    import VoltarButton from '@/Components/VoltarButton.vue';
    import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
    import { Head } from '@inertiajs/vue3';
    import { router } from '@inertiajs/vue3';
    import { defineProps } from 'vue';
    import { reactive } from 'vue';

    const props = defineProps({
        nome: String,
        cor: String
    });

    const form = reactive({
        nome: props.nome,
        cor: props.cor
    })

    function voltar() {
        router.get('/categoria/index');
    }

    function submit() {
        router.post("/categoria/store", form);
    }

</script>

<template>
    <Head title="Criar Categoria"/>

    <AuthenticatedLayout>

        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">
                    <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                        Criar Categoria
                    </h2>
                </div>
                <div class="flex-shrink-0">
                    <VoltarButton @click="voltar()" ></VoltarButton>
                </div>
            </div>
        </template>

        <div class="py-10">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="flex items-center b justify-center px-5 py-4">
                        <form class="flex justify-between items-center" @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="mb-5 mt-5 text-center p-10 shadow-md rounded-xl border border-gray-200 w-96">

                                <label for="text" class="block text-xl text-gray-700">Nome</label>
                                <q-input color="indigo-10" v-model="form.nome" class="mt-2 text-center" placeholder="Digite o nome"/>

                                <label for="text" class="block text-xl mt-10 font-medium text-gray-700">Cor</label>
                                <q-input type="text" v-model="form.cor" class="mt-2 w-full"  placeholder="#0000FF"/>

                                <SubmitButton color="primary" name="submit" label="Criar" class="mt-8"/>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
