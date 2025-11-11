<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>


<template>
    <Head title="Registrarse" />
    <div class="min-h-screen bg-gradient-to-br from-blue-50 to-blue-200 dark:from-gray-900 dark:to-gray-800 flex flex-col justify-center items-center">
        <div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-xl shadow-lg p-8 mt-12">
            <div class="flex flex-col items-center mb-6">
                <svg class="h-12 w-12 text-blue-500 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Crear cuenta</h2>
                <p class="text-gray-500 dark:text-gray-300 text-center text-sm mt-1">Regístrate para comenzar a gestionar tus tareas</p>
            </div>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <InputLabel for="name" value="Nombre" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>
                <div>
                    <InputLabel for="email" value="Correo electrónico" />
                    <TextInput
                        id="email"
                        type="email"
                        class="mt-1 block w-full"
                        v-model="form.email"
                        required
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
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>
                <div>
                    <InputLabel for="password_confirmation" value="Confirmar contraseña" />
                    <TextInput
                        id="password_confirmation"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password_confirmation"
                        required
                        autocomplete="new-password"
                    />
                    <InputError class="mt-2" :message="form.errors.password_confirmation" />
                </div>
                <div class="flex items-center justify-end gap-2">
                    <Link
                        :href="route('login')"
                        class="text-sm text-blue-600 hover:underline dark:text-blue-400"
                    >
                        ¿Ya tienes cuenta?
                    </Link>
                    <PrimaryButton
                        class="ms-2"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Registrarse
                    </PrimaryButton>
                </div>
            </form>
            <div class="mt-6 text-center text-xs text-gray-400 dark:text-gray-500">
                &copy; {{ new Date().getFullYear() }} Gestor de Tareas
            </div>
        </div>
    </div>
</template>
