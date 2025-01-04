<script setup>
import { defineProps } from 'vue';
import { router, Head, Link } from '@inertiajs/vue3';
import SubmitButton from '@/Components/SubmitButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    tarefas: Object, // Alterado para Object pois tarefas agora é um objeto de paginação
});

function create() {
    router.get(route('tarefa.create'));
}

function edit(id) {
    router.get(route('tarefa.edit', id));
}

function deleteCategory(id) {
    if (confirm("Tem certeza que deseja excluir essa tarefa?")) {
        router.delete(route('tarefa.destroy', id));
    }
}

function avancarStatus(id) {
    if (confirm("Tem certeza que deseja avançar o status da tarefa?")) {
        router.post(route('tarefa.avancaStatus', id));
    }
}

function ativarTarefa(id) {
    if (confirm("Tem certeza que deseja ativar essa tarefa?")) {
        router.post(route('tarefa.ativa', id));
    }
}

function desativarTarefa(id) {
    if (confirm("Tem certeza que deseja desativar essa tarefa?")) {
        router.post(route('tarefa.desativa', id));
    }
}

function getStatusClass(status) {
    switch (status) {
        case 'Pendente':
            return 'text-red-500';
        case 'Em andamento':
            return 'text-yellow-500';
        case 'Concluída':
            return 'text-green-500';
        default:
            return 'text-gray-500';
    }
}
</script>

<template>
    <Head title="Tarefa" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-bold text-center leading-tight text-gray-800">
                Tarefas
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                    <div class="flex items-center justify-center px-5 py-4 mt-5">
                        <SubmitButton @click="create"
                            class="text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg py-2 px-4">
                            Adicionar Tarefa
                        </SubmitButton>
                    </div>

                    <div class="q-gutter-md q-mt-md grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-5">
                        <q-card v-for="tarefa in props.tarefas.data" :key="tarefa.id" class="q-pa-md rounded-xl shadow-lg flex flex-col justify-between">
                            <q-card-section class="text-center p-4 max-w--full">
                                <h3 class="text-xl font-semibold text-indigo-700 mb-2">ID: {{ tarefa.id }}</h3>
                                <p class="text-lg font-medium text-gray-800">Titulo: {{ tarefa.titulo }}</p>
                                <p class="text-lg font-medium text-gray-800">Categoria: {{ tarefa.categoria }}</p>
                                <p :class="getStatusClass(tarefa.status)" class="text-lg font-medium">Status Atual: {{ tarefa.status }}</p>
                                <p class="text-lg font-medium text-gray-800 text-wrap break-all">Descrição: {{ tarefa.descricao }}</p>
                                <p class="text-lg font-medium text-gray-800">Situação: {{ tarefa.ativo ? "Ativo" : "Inativo" }}</p>
                                <p v-if="tarefa.data_conclusao && tarefa.status === 'Concluída'" class="text-lg font-medium text-gray-800">Data de Conclusão: {{ tarefa.data_conclusao }}</p>
                                <p class="text-lg font-medium text-gray-800">Criado: {{ tarefa.created_at }}</p>
                            </q-card-section>

                            <q-card-actions class="flex justify-center gap-4 p-4">
                                <q-btn icon="edit" color="secondary" @click="edit(tarefa.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn icon="autorenew" color="blue" @click="avancarStatus(tarefa.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn icon="delete" color="negative" @click="deleteCategory(tarefa.id)" class="text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn v-if="tarefa.ativo" icon="visibility_off" color="negative" @click="desativarTarefa(tarefa.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn v-else icon="visibility" color="positive" @click="ativarTarefa(tarefa.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                            </q-card-actions>
                        </q-card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
