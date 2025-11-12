<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Panel" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-3xl font-extrabold leading-tight text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 drop-shadow-lg text-center"
            >
                Panel principal
            </h2>
        </template>

        <div class="py-10 flex flex-col items-center min-h-[60vh]">
            <div class="w-full max-w-2xl px-4 sm:px-6 lg:px-8">
                <div class="bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 border-4 border-blue-400 dark:border-fuchsia-700 flex flex-col items-center animate-fade-in">
                    <svg class="h-16 w-16 text-fuchsia-600 dark:text-blue-400 mb-4 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <defs>
                            <linearGradient id="icon-gradient-dashboard" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#f472b6" />
                                <stop offset="100%" stop-color="#3b82f6" />
                            </linearGradient>
                        </defs>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 13h2a2 2 0 002-2V7a2 2 0 012-2h6a2 2 0 012 2v4a2 2 0 002 2h2m-6 4v4m-4-4v4" stroke="url(#icon-gradient-dashboard)" />
                    </svg>
                    <div class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 mb-2 text-center">¡Has iniciado sesión!</div>
                    <div class="text-gray-700 dark:text-gray-200 text-center text-base sm:text-lg font-medium mb-2">Bienvenido a tu gestor de tareas.<br>Desde aquí puedes acceder a tus tareas, perfil y más opciones.</div>
                    <div class="bg-gradient-to-r from-blue-100 via-fuchsia-100 to-cyan-100 dark:from-indigo-900 dark:via-blue-900 dark:to-gray-900 rounded-2xl shadow p-6 mb-6 w-full mt-4">
                        <h3 class="text-lg font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 mb-2 text-center">¿Cómo aprovechar el panel?</h3>
                        <ul class="list-disc list-inside text-gray-700 dark:text-gray-200 text-base space-y-2">
                            <li>Revisa tus tareas pendientes y en progreso rápidamente.</li>
                            <li>Accede a la edición de tu perfil para mantener tu información actualizada.</li>
                            <li>Utiliza los accesos directos para navegar entre tareas y perfil sin perder tiempo.</li>
                            <li>Disfruta de una experiencia fluida y segura en cualquier dispositivo.</li>
                        </ul>
                        <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                            ¡Gestiona tu productividad y mantén el control de tus pendientes!
                        </div>
                    </div>
                    <div class="mt-6 flex flex-col sm:flex-row gap-3 w-full justify-center">
                        <a :href="route('tasks.index')" class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-base text-center">Ir a mis tareas</a>
                        <a :href="route('profile.edit')" class="flex-1 px-6 py-3 bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold rounded-xl shadow-lg hover:from-blue-500 hover:to-cyan-400 hover:scale-105 transition-all duration-200 text-base text-center">Editar perfil</a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
