<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>


<template>
    <section class="bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 border-4 border-blue-400 dark:border-fuchsia-700 max-w-lg mx-auto mt-6">
        <header class="mb-6 flex flex-col items-center">
            <svg class="h-12 w-12 text-fuchsia-600 dark:text-blue-400 mb-2 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <defs>
                    <linearGradient id="icon-gradient-password" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#f472b6" />
                        <stop offset="100%" stop-color="#3b82f6" />
                    </linearGradient>
                </defs>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0-1.657 1.343-3 3-3s3 1.343 3 3-1.343 3-3 3-3-1.343-3-3zm0 0V7m0 8v-2m0 0H8m4 0h4" stroke="url(#icon-gradient-password)" />
            </svg>
            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300 text-center">Actualizar contraseña</h2>
            <p class="mt-1 text-gray-700 dark:text-gray-200 text-center text-sm font-medium">Asegúrate de usar una contraseña larga y aleatoria para mantener tu cuenta segura.</p>
        </header>
        <form @submit.prevent="updatePassword" class="space-y-4">
            <div>
                <InputLabel for="current_password" value="Contraseña actual" />
                <TextInput
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                />
                <InputError :message="form.errors.current_password" class="mt-2" />
            </div>
            <div>
                <InputLabel for="password" value="Nueva contraseña" />
                <TextInput
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password" class="mt-2" />
            </div>
            <div>
                <InputLabel for="password_confirmation" value="Confirmar contraseña" />
                <TextInput
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                />
                <InputError :message="form.errors.password_confirmation" class="mt-2" />
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
