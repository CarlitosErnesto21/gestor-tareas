
<script setup>

import { Head, Link, useForm } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    task: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    title: props.task.title,
    description: props.task.description,
    due_date: props.task.due_date,
    status: props.task.status,
});

const submit = () => {
    form.put(route('tasks.update', props.task.id));
};
</script>

<template>
    <Head :title="'Editar: ' + props.task.title" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-2 sm:flex-row sm:justify-between sm:items-center w-full">
                <div class="flex items-center gap-2">
                    <FontAwesomeIcon icon="fa-solid fa-pen-to-square" class="text-blue-600 dark:text-fuchsia-400 h-7 w-7 drop-shadow-lg" />
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-fuchsia-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300">Editar Tarea</h1>
                </div>
                <Link :href="route('tasks.index')" class="flex items-center gap-2 px-5 py-2 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200">
                    <FontAwesomeIcon icon="fa-solid fa-list-check" class="text-white" />
                    Volver
                </Link>
            </div>
        </template>
        <div class="w-full max-w-lg mx-auto bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 mt-6 border-4 border-blue-400 dark:border-fuchsia-700">
            <form @submit.prevent="submit" class="space-y-4 animate-fade-in">
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Título</label>
                    <input v-model="form.title" type="text" class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white" required />
                    <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
                </div>
                <div>
                    <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Descripción</label>
                    <textarea v-model="form.description" class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white" rows="3"></textarea>
                    <div v-if="form.errors.description" class="text-red-500 text-xs mt-1">{{ form.errors.description }}</div>
                </div>
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Fecha límite</label>
                        <input v-model="form.due_date" type="date" class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white" />
                        <div v-if="form.errors.due_date" class="text-red-500 text-xs mt-1">{{ form.errors.due_date }}</div>
                    </div>
                    <div class="flex-1">
                        <label class="block text-gray-700 dark:text-gray-200 font-semibold mb-1">Estado</label>
                        <select v-model="form.status" class="w-full rounded border-gray-300 dark:bg-gray-800 dark:text-white">
                            <option value="pendiente">Pendiente</option>
                            <option value="en_progreso">En progreso</option>
                            <option value="completada">Completada</option>
                        </select>
                        <div v-if="form.errors.status" class="text-red-500 text-xs mt-1">{{ form.errors.status }}</div>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition disabled:opacity-50">Actualizar</button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
