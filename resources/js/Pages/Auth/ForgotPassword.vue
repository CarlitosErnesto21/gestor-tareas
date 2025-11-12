<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>


<template>
    <Head title="¿Olvidaste tu contraseña?" />
    <div class="min-h-screen flex flex-col justify-center items-center bg-gradient-to-br from-fuchsia-400 via-blue-400 to-cyan-300 dark:from-indigo-900 dark:via-blue-900 dark:to-gray-900 transition-colors duration-500">
        <div class="w-full max-w-md bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 mt-12 border-4 border-blue-400 dark:border-fuchsia-700">
            <div class="flex flex-col items-center mb-6">
                <svg class="h-14 w-14 text-fuchsia-600 dark:text-blue-400 mb-2 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <defs>
                        <linearGradient id="icon-gradient-forgot" x1="0" y1="0" x2="1" y2="1">
                            <stop offset="0%" stop-color="#f472b6" />
                            <stop offset="100%" stop-color="#3b82f6" />
                        </linearGradient>
                    </defs>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 0V7m0 8v-2m0 0H8m4 0h4" stroke="url(#icon-gradient-forgot)" />
                </svg>
                <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 text-center">¿Olvidaste tu contraseña?</h2>
                <p class="text-gray-700 dark:text-gray-200 text-center text-sm mt-1 font-medium">Indícanos tu correo y te enviaremos un enlace para restablecerla.</p>
            </div>
            <div v-if="status" class="mb-4 text-sm font-medium text-green-600 text-center">
                {{ status }}
            </div>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <InputLabel for="email" value="Correo electrónico" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-base mt-2 disabled:opacity-50"
                    :disabled="form.processing"
                >
                    <FontAwesomeIcon icon="fa-solid fa-envelope" class="text-white text-xl" />
                    <span v-if="!form.processing">Enviar enlace de restablecimiento</span>
                    <span v-else>Cargando...</span>
                    <svg v-if="form.processing" class="animate-spin ml-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                </button>
            </form>
            <div class="mt-4 text-center flex flex-col gap-2">
                <Link
                    :href="form.processing ? undefined : route('login')"
                    class="text-sm text-blue-600 hover:underline dark:text-blue-400 font-semibold"
                    :class="{ 'pointer-events-none opacity-50': form.processing }"
                    tabindex="-1"
                >Volver a iniciar sesión</Link>
                <Link
                    :href="form.processing ? undefined : '/'"
                    class="text-xs text-gray-500 hover:underline dark:text-gray-400"
                    :class="{ 'pointer-events-none opacity-50': form.processing }"
                    tabindex="-1"
                >Volver a la página principal</Link>
            </div>
            <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ new Date().getFullYear() }} Gestor de Tareas
            </div>
        </div>
    </div>
</template>
