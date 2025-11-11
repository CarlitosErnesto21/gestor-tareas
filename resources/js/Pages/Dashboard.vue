<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Panel" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Panel
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8">
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400 mb-2">¡Has iniciado sesión!</div>
                    <div class="text-gray-700 dark:text-gray-200">Bienvenido a tu gestor de tareas. Desde aquí puedes acceder a tus tareas, perfil y más opciones.</div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
