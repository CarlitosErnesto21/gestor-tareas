
<script setup>

import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    task: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <Head :title="task.title" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-2 sm:flex-row sm:justify-between sm:items-center w-full">
                <div class="flex items-center gap-2">
                    <FontAwesomeIcon icon="fa-solid fa-eye" class="text-blue-600 dark:text-fuchsia-400 h-7 w-7 drop-shadow-lg" />
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-fuchsia-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300">Detalle de Tarea</h1>
                </div>
                <Link :href="route('tasks.index')" class="flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200">
                    <FontAwesomeIcon icon="fa-solid fa-list-check" class="text-white" />
                    Volver
                </Link>
            </div>
        </template>
        <div class="w-full max-w-lg mx-auto bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 mt-6 border-4 border-blue-400 dark:border-fuchsia-700 animate-fade-in">
            <div class="mb-4 text-gray-600 dark:text-gray-300 text-lg font-semibold flex items-center gap-2">
                <FontAwesomeIcon icon="fa-solid fa-list-check" class="text-fuchsia-600 dark:text-blue-400 h-5 w-5" />
                {{ task.title }}
            </div>
            <div class="mb-2 text-gray-500 dark:text-gray-400 text-sm flex items-center gap-2">
                <FontAwesomeIcon icon="fa-solid fa-calendar-days" class="text-blue-400" />
                Fecha límite: {{ task.due_date || 'Sin fecha' }}
            </div>
            <div class="mb-2 text-sm">
                <span :class="{
                    'bg-yellow-100 text-yellow-800': task.status === 'pendiente',
                    'bg-blue-100 text-blue-800': task.status === 'en_progreso',
                    'bg-green-100 text-green-800': task.status === 'completada',
                }" class="px-2 py-1 rounded text-xs font-bold">
                    {{ task.status.replace('_', ' ').toUpperCase() }}
                </span>
            </div>
            <div class="mb-4 text-gray-600 dark:text-gray-300">{{ task.description }}</div>
            <div class="flex gap-2 mt-6">
                <Link :href="route('tasks.edit', task.id)" class="flex items-center gap-2 px-5 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 transition">
                    <FontAwesomeIcon icon="fa-solid fa-pen-to-square" class="text-white" />
                    Editar
                </Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
