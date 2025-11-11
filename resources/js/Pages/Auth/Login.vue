<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>


<template>
    <Head title="Iniciar sesión" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-200 dark:from-gray-900 dark:to-gray-800 flex flex-col justify-center items-center">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-12">
            <div class="flex flex-col items-center mb-6">
                <svg class="h-12 w-12 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0 4 4 0 018 0zm2 6a8 8 0 10-16 0h16z" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Iniciar sesión</h2>
                <p class="text-gray-500 dark:text-gray-300 text-center text-sm mt-1">Accede a tu gestor de tareas</p>
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
                <div>
                    <InputLabel for="password" value="Contraseña" />
                    <TextInput
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-300">Recuérdame</span>
                    </label>
                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                    >
                        ¿Olvidaste tu contraseña?
                    </Link>
                </div>
                <PrimaryButton
                    class="w-full mt-2"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Iniciar sesión
                </PrimaryButton>
            </form>
            <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ new Date().getFullYear() }} Gestor de Tareas
            </div>
        </div>
    </div>
</template>
