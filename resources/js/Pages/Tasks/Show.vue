
<script setup>
import { Head, Link } from '@inertiajs/vue3';
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
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">{{ task.title }}</h1>
                <Link :href="route('tasks.index')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">Volver</Link>
            </div>
        </template>
        <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-6">
            <div class="mb-4 text-gray-600 dark:text-gray-300">{{ task.description }}</div>
            <div class="mb-2 text-sm text-gray-500 dark:text-gray-400">Fecha límite: {{ task.due_date || 'Sin fecha' }}</div>
            <div class="mb-2 text-sm">
                <span :class="{
                    'bg-yellow-100 text-yellow-800': task.status === 'pendiente',
                    'bg-blue-100 text-blue-800': task.status === 'en_progreso',
                    'bg-green-100 text-green-800': task.status === 'completada',
                }" class="px-2 py-1 rounded text-xs font-bold">
                    {{ task.status.replace('_', ' ').toUpperCase() }}
                </span>
            </div>
            <div class="flex gap-2 mt-6">
                <Link :href="route('tasks.edit', task.id)" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">Editar</Link>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
