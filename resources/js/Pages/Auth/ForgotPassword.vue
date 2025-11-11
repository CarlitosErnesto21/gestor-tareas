<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';

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
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-200 dark:from-gray-900 dark:to-gray-800 flex flex-col justify-center items-center">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-12">
            <div class="flex flex-col items-center mb-6">
                <svg class="h-12 w-12 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 0V7m0 8v-2m0 0H8m4 0h4" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">¿Olvidaste tu contraseña?</h2>
                <p class="text-gray-500 dark:text-gray-300 text-center text-sm mt-1">Indícanos tu correo y te enviaremos un enlace para restablecerla.</p>
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
                <PrimaryButton
                    class="w-full mt-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Enviar enlace de restablecimiento
                </PrimaryButton>
            </form>
            <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ new Date().getFullYear() }} Gestor de Tareas
            </div>
        </div>
    </div>
</template>
