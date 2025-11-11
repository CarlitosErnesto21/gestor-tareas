<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>


<template>
    <Head title="Verificación de correo" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-200 dark:from-gray-900 dark:to-gray-800 flex flex-col justify-center items-center">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-12">
            <div class="flex flex-col items-center mb-6">
                <svg class="h-12 w-12 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0 4 4 0 018 0zm2 6a8 8 0 10-16 0h16z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Verificación de correo</h2>
                <p class="text-gray-500 dark:text-gray-300 text-center text-sm mt-1">¡Gracias por registrarte! Antes de comenzar, verifica tu correo electrónico haciendo clic en el enlace que te enviamos. Si no lo recibiste, puedes solicitar otro.</p>
            </div>
            <div v-if="verificationLinkSent" class="mb-4 text-sm font-medium text-green-600 text-center">
                Se ha enviado un nuevo enlace de verificación al correo que proporcionaste durante el registro.
            </div>
            <form @submit.prevent="submit">
                <PrimaryButton
                    class="w-full mt-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Reenviar correo de verificación
                </PrimaryButton>
            </form>
            <div class="mt-4 text-center">
                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                >Cerrar sesión</Link>
            </div>
            <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ new Date().getFullYear() }} Gestor de Tareas
            </div>
        </div>
    </div>
</template>
