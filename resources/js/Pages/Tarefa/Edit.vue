<script setup>
import { reactive, onMounted } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import VoltarButton from '@/Components/VoltarButton.vue';
import { router } from '@inertiajs/vue3';
import { QSelect, QInput, QBtn } from 'quasar';

const { props } = usePage();
const form = reactive({
    id: props.tarefa.id,
    categoria_id: props.tarefa.categoria_id,
    titulo: props.tarefa.titulo,
    descricao: props.tarefa.descricao,
    status: props.tarefa.status,
    categorias: props.categorias,
    statusOptions: props.status
});

onMounted(() => {
    // Encontrar e ajustar os valores corretos
    const categoria = form.categorias.find(cat => cat.id === form.categoria_id);
    const status = form.statusOptions.find(st => st.id === form.status);

    if (categoria) {
        form.categoria_id = categoria.id; // ID necessário para v-model
    }

    if (status) {
        form.status = status.id; // ID necessário para v-model
    }
});

function voltar() {
    router.get('/tarefa/index');
}

function submit() {
    const payload = {
        categoria_id: form.categoria_id,
        titulo: form.titulo,
        descricao: form.descricao,
        status: form.status
    };
    router.post(`/tarefa/update/${form.id}`, payload);
}
</script>

<template>
    <Head title="Editar Tarefa"/>

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <div class="flex-1 text-center">
                    <h2 class="text-2xl font-semibold leading-tight text-gray-800">
                        Editar Tarefa
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
                    <div class="flex items-center justify-center px-5 py-4">
                        <form class="flex flex-col items-center" @submit.prevent="submit" enctype="multipart/form-data">
                            <div class="mb-5 mt-5 text-center p-10 shadow-md rounded-xl border border-gray-200 w-96">
                                <label for="categoria" class="block text-xl text-gray-700">Categoria</label>
                                <q-select
                                    v-model="form.categoria_id"
                                    class="mt-2"
                                    :options="form.categorias"
                                    option-label="nome"
                                    option-value="id"
                                    emit-value
                                    map-options
                                    placeholder="Selecione a categoria"
                                    required
                                />

                                <label for="titulo" class="block text-xl mt-10 font-medium text-gray-700">Título</label>
                                <q-input
                                    color="indigo-10"
                                    v-model="form.titulo"
                                    class="mt-2 text-center"
                                    placeholder="Digite o título"
                                    required
                                />

                                <label for="descricao" class="block text-xl mt-10 font-medium text-gray-700">Descrição</label>
                                <q-input
                                    type="textarea"
                                    color="indigo-10"
                                    v-model="form.descricao"
                                    class="mt-2 text-center"
                                    placeholder="Digite a descrição"
                                    required
                                />

                                <label for="status" class="block text-xl mt-10 font-medium text-gray-700">Status</label>
                                <q-select
                                    v-model="form.status"
                                    class="mt-2"
                                    :options="form.statusOptions"
                                    option-label="nome"
                                    option-value="id"
                                    emit-value
                                    map-options
                                    placeholder="Selecione o status"
                                    required
                                />

                                <q-btn type="submit" label="Salvar Alterações" color="primary" class="mt-5" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
