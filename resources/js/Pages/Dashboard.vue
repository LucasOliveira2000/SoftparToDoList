<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { QCard, QCardSection, QCardActions, QBtn, QIcon } from 'quasar';
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl text-center font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-5">
                    <q-card class="q-pa-md rounded-xl shadow-lg">
                        <q-card-section class="text-center p-4">
                            <q-icon name="list" size="48px" class="text-primary" />
                            <h3 class="text-xl font-semibold text-indigo-700 mb-2">Ver Todas as Tarefas</h3>
                            <p class="text-lg font-medium text-gray-800">Visualize todas as suas tarefas em um só lugar.</p>
                        </q-card-section>
                        <q-card-actions class="flex justify-center gap-4 p-4">
                            <q-btn color="primary" @click="indexTarefa()" label="Ver Todas as Tarefas" />
                        </q-card-actions>
                    </q-card>

                    <q-card class="q-pa-md rounded-xl shadow-lg">
                        <q-card-section class="text-center p-4">
                            <q-icon name="hourglass_empty" size="48px" class="text-primary" />
                            <h3 class="text-xl font-semibold text-indigo-700 mb-2">Tarefas Pendentes</h3>
                            <p class="text-lg font-medium text-gray-800">Visualize todas as tarefas que ainda estão pendentes.</p>
                        </q-card-section>
                        <q-card-actions class="flex justify-center gap-4 p-4">
                            <q-btn color="primary" @click="indexTarefa('pendente')" label="Ver Tarefas Pendentes" />
                        </q-card-actions>
                    </q-card>

                    <q-card class="q-pa-md rounded-xl shadow-lg">
                        <q-card-section class="text-center p-4">
                            <q-icon name="autorenew" size="48px" class="text-primary" />
                            <h3 class="text-xl font-semibold text-indigo-700 mb-2">Tarefas em Andamento</h3>
                            <p class="text-lg font-medium text-gray-800">Visualize todas as tarefas que estão em andamento.</p>
                        </q-card-section>
                        <q-card-actions class="flex justify-center gap-4 p-4">
                            <q-btn color="primary" @click="indexTarefa('em_andamento')" label="Ver Tarefas em Andamento" />
                        </q-card-actions>
                    </q-card>

                    <q-card class="q-pa-md rounded-xl shadow-lg">
                        <q-card-section class="text-center p-4">
                            <q-icon name="check_circle" size="48px" class="text-primary" />
                            <h3 class="text-xl font-semibold text-indigo-700 mb-2">Tarefas Concluídas</h3>
                            <p class="text-lg font-medium text-gray-800">Visualize todas as tarefas que foram concluídas.</p>
                        </q-card-section>
                        <q-card-actions class="flex justify-center gap-4 p-4">
                            <q-btn color="primary" @click="indexTarefa('concluida')" label="Ver Tarefas Concluídas" />
                        </q-card-actions>
                    </q-card>

                    <q-card class="q-pa-md rounded-xl shadow-lg">
                        <q-card-section class="text-center p-4">
                            <q-icon name="edit" size="48px" class="text-primary" />
                            <h3 class="text-xl font-semibold text-indigo-700 mb-2">Edite suas listas de tarefas</h3>
                            <p class="text-lg font-medium text-gray-800">Mantenha suas listas de tarefas atualizadas e organizadas.</p>
                        </q-card-section>
                        <q-card-actions class="flex justify-center gap-4 p-4">
                            <q-btn color="primary" @click="indexTarefa()" label="Editar Lista" />
                        </q-card-actions>
                    </q-card>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script >

import { router } from '@inertiajs/vue3';
import { Head } from '@inertiajs/vue3';

function indexTarefa(status = '') {
    let route = '/tarefa/index';
    if (status) {
        route += `?status=${status}`;
    }
    router.get(route);
}

</script>
