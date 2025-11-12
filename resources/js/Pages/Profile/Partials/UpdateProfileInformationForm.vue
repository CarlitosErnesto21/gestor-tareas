<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>


<template>
    <section class="bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 border-4 border-blue-400 dark:border-fuchsia-700 max-w-lg mx-auto mt-6">
        <header class="mb-6 flex flex-col items-center">
            <svg class="h-12 w-12 text-fuchsia-600 dark:text-blue-400 mb-2 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <defs>
                    <linearGradient id="icon-gradient-profile" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#f472b6" />
                        <stop offset="100%" stop-color="#3b82f6" />
                    </linearGradient>
                </defs>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 01-8 0 4 4 0 018 0zm2 6a8 8 0 10-16 0h16z" stroke="url(#icon-gradient-profile)" />
            </svg>
            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 text-center">Información del perfil</h2>
            <p class="mt-1 text-gray-700 dark:text-gray-200 text-center text-sm font-medium">Actualiza la información de tu perfil y dirección de correo electrónico.</p>
        </header>
        <form
            @submit.prevent="form.patch(route('profile.update'))"
            class="space-y-4"
        >
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
            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                    Tu dirección de correo electrónico no está verificada.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-blue-600 underline hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300"
                    >
                        Haz clic aquí para reenviar el correo de verificación.
                    </Link>
                </p>
                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-600"
                >
                    Se ha enviado un nuevo enlace de verificación a tu correo electrónico.
                </div>
            </div>
            <div class="flex items-center gap-4 mt-4">
                <button
                    type="submit"
                    class="flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-lg disabled:opacity-50"
                    :disabled="form.processing"
                >
                    <FontAwesomeIcon icon="fa-solid fa-floppy-disk" class="text-white text-xl" />
                    <span v-if="!form.processing">Guardar</span>
                    <span v-else class="flex items-center gap-2">
                        <FontAwesomeIcon icon="fa-solid fa-spinner" class="animate-spin h-5 w-5 text-white" />
                        Guardando...
                    </span>
                </button>
                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-green-600 dark:text-green-400"
                    >
                        Guardado.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
