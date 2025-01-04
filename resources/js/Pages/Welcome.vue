<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';

const { props } = usePage();
</script>

<template>
    <Head title="ToDoList" />

    <div class="relative flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
                <h1 class="text-4xl font-bold text-gray-800 dark:text-white">ToDoList</h1>
            </div>

            <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-center">
                        <div class="ml-4 text-center text-lg leading-7 font-semibold">
                            <a href="/tarefa/index" class="underline text-gray-900">Gerencie suas Tarefas</a>
                        </div>
                    </div>

                    <div class="flex items-center justify-center">
                        <div class="mt-2  text-center text-gray-600 dark:text-gray-400 text-sm">
                            Organize suas tarefas de forma eficiente e produtiva.
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-4 sm:items-center sm:justify-between">
                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    <nav class="flex justify-end space-x-4">
                        <Link
                            v-if="props.auth.user"
                            :href="route('dashboard')"
                            class="rounded-md px-3 py-2 bg-blue-600 text-white hover:bg-blue-700 transition"
                        >
                            Dashboard
                        </Link>
                        <Link
                            v-else
                            :href="route('login')"
                            class="rounded-md px-3 py-2 bg-blue-600 text-white hover:bg-blue-700 transition"
                        >
                            Login
                        </Link>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</template>
