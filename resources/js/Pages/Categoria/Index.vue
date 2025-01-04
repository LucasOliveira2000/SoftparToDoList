<script setup>
import { defineProps } from 'vue';
import { router, Head} from '@inertiajs/vue3';
import SubmitButton from '@/Components/SubmitButton.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    categorias: Object, // Alterado para Object pois categorias agora é um objeto de paginação
});

function create() {
    router.get(route('categoria.create'));
}

function edit(id) {
    router.get(route('categoria.edit', id));
}

function deleteCategory(id) {
    if (confirm("Tem certeza que deseja excluir essa categoria?")) {
        router.delete(route('categoria.destroy', id));
    }
}

function ativarCategoria(id) {
    if (confirm("Tem certeza que deseja ativar essa categoria?")) {
        router.post(route('categoria.ativa', id));
    }
}

function desativarCategoria(id) {
    if (confirm("Tem certeza que deseja desativar essa categoria?")) {
        router.post(route('categoria.desativa', id));
    }
}
</script>

<template>
    <Head title="Categoria" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-3xl font-bold text-center leading-tight text-gray-800">
                Categorias
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-lg sm:rounded-lg">

                    <div class="flex items-center justify-center px-5 py-4 mt-5">
                        <SubmitButton @click="create"
                            class="text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg py-2 px-4">
                            Adicionar Categoria
                        </SubmitButton>
                    </div>

                    <div class="q-gutter-md q-mt-md grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-5">
                        <q-card v-for="categoria in props.categorias.data" :key="categoria.id" class="q-pa-md rounded-xl shadow-lg">
                            <q-card-section class="text-center p-4">
                                <h3 class="text-xl font-semibold text-indigo-700 mb-2">ID: {{ categoria.id }}</h3>
                                <p class="text-lg font-medium text-gray-800">Nome: {{ categoria.nome }}</p>
                                <p class="text-lg font-medium text-gray-800">Cor: {{ categoria.cor }}</p>
                                <p class="text-lg font-medium text-gray-800">Situação: {{ categoria.ativo ? "Ativo" : "Inativo" }}</p>
                                <p class="text-lg font-medium text-gray-800">Criado: {{ categoria.created_at }}</p>
                            </q-card-section>

                            <q-card-actions class="flex justify-center gap-4 p-4">
                                <q-btn icon="edit" color="secondary" @click="edit(categoria.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn icon="delete" color="negative" @click="deleteCategory(categoria.id)" class="text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn v-if="categoria.ativo" icon="visibility_off" color="negative" @click="desativarCategoria(categoria.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                                <q-btn v-else icon="visibility" color="positive" @click="ativarCategoria(categoria.id)" class="q-mr-sm text-white rounded-lg py-2 px-4 transition-colors duration-200" />
                            </q-card-actions>
                        </q-card>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
