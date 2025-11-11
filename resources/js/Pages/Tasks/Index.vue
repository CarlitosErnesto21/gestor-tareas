
<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    tasks: {
        type: Array,
        required: true,
    },
});
</script>

<template>
    <Head title="Mis Tareas" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Mis Tareas</h1>
                    <Link :href="route('tasks.create')" class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Nueva tarea</Link>
                </div>
                <div class="flex items-center">
                    <span class="text-gray-500 dark:text-gray-300">Aquí puedes gestionar tus tareas personales.</span>
                </div>
            </div>
        </template>
        <div class="w-full max-w-2xl mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-6">
            <div v-if="tasks.length === 0" class="text-gray-500 dark:text-gray-300 text-center py-8">
                No tienes tareas registradas.
            </div>
            <ul v-else class="divide-y divide-gray-200 dark:divide-gray-700">
                <li v-for="task in tasks" :key="task.id" class="py-4 flex flex-col gap-1">
                    <div class="flex justify-between items-center">
                        <span class="font-semibold text-gray-800 dark:text-white">{{ task.title }}</span>
                        <span :class="{
                            'bg-yellow-100 text-yellow-800': task.status === 'pendiente',
                            'bg-blue-100 text-blue-800': task.status === 'en_progreso',
                            'bg-green-100 text-green-800': task.status === 'completada',
                        }" class="px-2 py-1 rounded text-xs font-bold">
                            {{ task.status.replace('_', ' ').toUpperCase() }}
                        </span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 text-sm">{{ task.description }}</div>
                    <div class="text-xs text-gray-400 mt-1">Fecha límite: {{ task.due_date || 'Sin fecha' }}</div>
                    <div class="flex gap-2 mt-2">
                        <Link :href="route('tasks.show', task.id)" class="px-3 py-1 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 text-xs">Ver</Link>
                        <Link :href="route('tasks.edit', task.id)" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs">Editar</Link>
                        <form :action="route('tasks.destroy', task.id)" method="post" @submit.prevent="$inertia.delete(route('tasks.destroy', task.id))" class="inline">
                            <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-xs">Eliminar</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </AuthenticatedLayout>
</template>
