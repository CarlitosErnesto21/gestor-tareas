<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>


<template>
    <Head title="Gestor de Tareas" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-200 dark:from-gray-900 dark:to-gray-800 flex flex-col justify-center items-center">
        <div class="w-full max-w-2xl bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-12">
            <div class="flex flex-col items-center mb-8">
                <svg class="h-16 w-16 text-blue-500 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" />
                </svg>
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-2">Gestor de Tareas</h1>
                <p class="text-gray-500 dark:text-gray-300 text-center">Organiza tus tareas, mantente productivo y nunca olvides tus pendientes.</p>
            </div>
            <div class="flex flex-col gap-4">
                <div v-if="$page.props.auth.user" class="flex flex-col items-center gap-2">
                    <span class="text-lg text-gray-700 dark:text-gray-200">¡Bienvenido, {{ $page.props.auth.user.name }}!</span>
                    <Link :href="route('tasks.index')" class="mt-2 px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Ir a mis tareas</Link>
                    <Link :href="route('dashboard')" class="mt-2 px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">Panel</Link>
                </div>
                <div v-else class="flex flex-col items-center gap-2">
                    <Link :href="route('login')" class="px-6 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Iniciar sesión</Link>
                    <Link v-if="canRegister" :href="route('register')" class="px-6 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 transition">Registrarse</Link>
                </div>
            </div>
            <div class="mt-10 text-center text-xs text-gray-400 dark:text-gray-500">
                Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
            </div>
        </div>
    </div>
</template>
