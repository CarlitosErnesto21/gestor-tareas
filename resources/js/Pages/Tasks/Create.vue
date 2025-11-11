
<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    title: '',
    description: '',
    due_date: '',
    status: 'pendiente',
});

const submit = () => {
    form.post(route('tasks.store'));
};
</script>

<template>
    <Head title="Nueva Tarea" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Nueva Tarea</h1>
                <Link :href="route('tasks.index')" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">Volver</Link>
            </div>
        </template>
        <div class="w-full max-w-lg mx-auto bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-6">
            <form @submit.prevent="submit" class="space-y-4">
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
                    <button type="submit" :disabled="form.processing" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition disabled:opacity-50">Guardar</button>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
