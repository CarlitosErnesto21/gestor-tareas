<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { ref } from 'vue';
// El componente ya está registrado globalmente en app.js, así que no es necesario importarlo aquí
import { faUser } from '@fortawesome/free-solid-svg-icons';
import { faUserPlus } from '@fortawesome/free-solid-svg-icons';

const props = defineProps({
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

const loadingLogin = ref(false);
const loadingRegister = ref(false);

function handleLoginClick(e) {
    loadingLogin.value = true;
    setTimeout(() => {
        e.target.closest('a').click();
    }, 1000);
}

function handleRegisterClick(e) {
    loadingRegister.value = true;
    setTimeout(() => {
        e.target.closest('a').click();
    }, 1000);
}

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>


<template>
    <Head title="Gestor de Tareas" />
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-fuchsia-400 via-blue-400 to-cyan-300 dark:from-indigo-900 dark:via-blue-900 dark:to-gray-900 transition-colors duration-500">
        <div class="w-full max-w-2xl mx-2 sm:mx-auto bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-6 sm:p-10 mt-8 sm:mt-16 border-4 border-blue-400 dark:border-fuchsia-700">
            <div class="flex flex-col items-center mb-8">
                <svg class="h-20 w-20 text-fuchsia-600 dark:text-blue-400 mb-4 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <defs>
                        <linearGradient id="icon-gradient" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#f472b6" />
                            <stop offset="100%" stop-color="#3b82f6" />
                        </linearGradient>
                    </defs>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2l4-4m5 2a9 9 0 11-18 0a9 9 0 0118 0z" stroke="url(#icon-gradient)" />
                </svg>
                <h1 class="text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 mb-2 text-center drop-shadow">Gestor de Tareas</h1>
                <p class="text-lg sm:text-xl text-gray-700 dark:text-gray-200 text-center font-medium">Organiza tus tareas, mantente productivo y nunca olvides tus pendientes.</p>
            </div>
            <div class="flex flex-col gap-4 w-full">
                <div v-if="$page.props.auth.user" class="flex flex-col items-center gap-3">
                    <span class="text-xl text-gray-800 dark:text-white font-semibold">¡Bienvenido, {{ $page.props.auth.user.name }}!</span>
                    <Link :href="route('tasks.index')" class="w-full sm:w-auto mt-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-lg">Ir a mis tareas</Link>
                    <Link :href="route('dashboard')" class="w-full sm:w-auto mt-2 px-8 py-3 bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold rounded-xl shadow-lg hover:from-blue-500 hover:to-cyan-400 hover:scale-105 transition-all duration-200 text-lg">Panel</Link>
                </div>
                    <div v-else class="w-full grid grid-cols-2 gap-3">
                        <Link
                            :href="route('login')"
                            class="w-full px-8 py-3 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-lg flex items-center justify-center gap-2"
                            @click.prevent="handleLoginClick"
                        >
                            <FontAwesomeIcon :icon="faUser" class="text-white text-xl" />
                            <span v-if="!loadingLogin.value">Iniciar sesión</span>
                            <span v-else>Cargando...</span>
                            <svg v-if="loadingLogin.value" class="animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </Link>
                        <Link
                            v-if="props.canRegister"
                            :href="route('register')"
                            class="w-full px-8 py-3 bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold rounded-xl shadow-lg hover:from-blue-500 hover:to-cyan-400 hover:scale-105 transition-all duration-200 text-lg flex items-center justify-center gap-2"
                            @click.prevent="handleRegisterClick"
                        >
                            <FontAwesomeIcon :icon="faUserPlus" class="text-white text-xl" />
                            <span v-if="!loadingRegister.value">Registrarse</span>
                            <span v-else>Cargando...</span>
                            <svg v-if="loadingRegister.value" class="animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                        </Link>
                    </div>
            </div>
            <div class="mt-10">
                <div class="bg-gradient-to-r from-blue-100 via-fuchsia-100 to-cyan-100 dark:from-indigo-900 dark:via-blue-900 dark:to-gray-900 rounded-2xl shadow p-6 mb-6">
                    <h3 class="text-xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 mb-2 text-center">¿Qué puedes hacer aquí?</h3>
                    <ul class="list-disc list-inside text-gray-700 dark:text-gray-200 text-base space-y-2">
                        <li>Organiza tus tareas personales y laborales en un solo lugar.</li>
                        <li>Establece fechas límite y visualiza el estado de cada tarea.</li>
                        <li>Actualiza, elimina y marca tareas como completadas fácilmente.</li>
                        <li>Tu información está protegida y solo tú puedes ver tus tareas.</li>
                        <li>Interfaz moderna, rápida y adaptada a cualquier dispositivo.</li>
                    </ul>
                    <div class="mt-4 text-center text-sm text-gray-500 dark:text-gray-400">
                        ¡Empieza creando una cuenta o inicia sesión para gestionar tus pendientes!
                    </div>
                </div>
                <div class="text-center text-xs text-gray-500 dark:text-gray-400">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </div>
            </div>
        </div>
    </div>
</template>
