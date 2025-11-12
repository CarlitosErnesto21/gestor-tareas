<script setup>
import { ref } from 'vue';
import { Head, Link, router as Inertia } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const loading = ref('');

function handleNav(target, url) {
    if (loading.value) return;
    loading.value = target;
    Inertia.visit(url, {
        onFinish: () => {
            loading.value = '';
        }
    });
}
</script>

<template>
    <Head title="Perfil" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-center gap-3">
                <FontAwesomeIcon icon="fa-solid fa-user" class="h-10 w-10 text-fuchsia-600 dark:text-blue-400 drop-shadow-lg" />
                <h2
                    class="text-3xl font-extrabold leading-tight text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 drop-shadow-lg text-center"
                >
                    Mi perfil
                </h2>
            </div>
        </template>

        <div class="py-10 flex flex-col items-center min-h-[60vh]">
            <div class="w-full max-w-xl px-4 sm:px-6 lg:px-8">
                <div class="bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 border-4 border-blue-400 dark:border-fuchsia-700 flex flex-col items-center animate-fade-in">
                    <svg class="h-16 w-16 text-fuchsia-600 dark:text-blue-400 mb-4 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <defs>
                            <linearGradient id="icon-gradient-profile" x1="0" y1="0" x2="1" y2="1">
                                <stop offset="0%" stop-color="#f472b6" />
                                <stop offset="100%" stop-color="#3b82f6" />
                            </linearGradient>
                        </defs>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0 4 4 0 018 0zm2 6a8 8 0 10-16 0h16z" stroke="url(#icon-gradient-profile)" />
                    </svg>
                    <div class="text-2xl sm:text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 mb-2 text-center">{{ $page.props.auth.user.name }}</div>
                    <div class="text-gray-700 dark:text-gray-200 text-center text-base sm:text-lg font-medium mb-2">{{ $page.props.auth.user.email }}</div>
                    <div class="mt-8 w-full max-w-md flex flex-col gap-4">
                        <Link
                            :href="route('profile.edit.info')"
                            class="flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-2xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-lg"
                            :disabled="loading && loading !== 'info'"
                            @click.prevent="handleNav('info', route('profile.edit.info'))"
                        >
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/20">
                                    <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                                </span>
                                <span v-if="loading !== 'info'">Editar información del perfil</span>
                                <span v-else class="flex items-center gap-2">
                                    <FontAwesomeIcon icon="fa-solid fa-spinner" spin class="h-5 w-5 animate-spin" />
                                    Procesando...
                                </span>
                            </Link>
                        <Link
                            :href="route('profile.edit.password')"
                            class="flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-cyan-400 to-blue-500 text-white font-bold rounded-2xl shadow-lg hover:from-blue-500 hover:to-cyan-400 hover:scale-105 transition-all duration-200 text-lg"
                            :disabled="loading && loading !== 'password'"
                            @click.prevent="handleNav('password', route('profile.edit.password'))"
                        >
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/20">
                                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 0V7m0 8v-2m0 0H8m4 0h4" /></svg>
                            </span>
                            <span v-if="loading !== 'password'">Cambiar contraseña</span>
                            <span v-else class="flex items-center gap-2">
                                <FontAwesomeIcon icon="fa-solid fa-spinner" spin class="h-5 w-5 animate-spin" />
                                Procesando...
                            </span>
                        </Link>
                        <Link
                            :href="route('profile.edit.delete')"
                            class="flex items-center gap-4 px-6 py-4 bg-gradient-to-r from-red-500 to-pink-500 text-white font-bold rounded-2xl shadow-lg hover:from-pink-500 hover:to-red-500 hover:scale-105 transition-all duration-200 text-lg"
                            :disabled="loading && loading !== 'delete'"
                            @click.prevent="handleNav('delete', route('profile.edit.delete'))"
                        >
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white/20">
                                <svg class="h-7 w-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                            </span>
                            <span v-if="loading !== 'delete'">Eliminar cuenta</span>
                            <span v-else class="flex items-center gap-2">
                                <FontAwesomeIcon icon="fa-solid fa-spinner" spin class="h-5 w-5 animate-spin" />
                                Procesando...
                            </span>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
