<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const deleteUser = () => {
    form.delete(route('profile.destroy'), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.clearErrors();
    form.reset();
};
</script>


<template>
    <section class="bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-8 border-4 border-blue-400 dark:border-fuchsia-700 max-w-lg mx-auto mt-6">
        <header class="mb-6 flex flex-col items-center">
            <svg class="h-12 w-12 text-red-600 dark:text-red-400 mb-2 drop-shadow-lg animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <defs>
                    <linearGradient id="icon-gradient-delete" x1="0" y1="0" x2="1" y2="1">
                        <stop offset="0%" stop-color="#f472b6" />
                        <stop offset="100%" stop-color="#3b82f6" />
                    </linearGradient>
                </defs>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" stroke="url(#icon-gradient-delete)" />
            </svg>
            <h2 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-fuchsia-500 to-blue-400 dark:from-red-400 dark:via-fuchsia-400 dark:to-blue-400 text-center">Eliminar cuenta</h2>
            <p class="mt-1 text-gray-700 dark:text-gray-200 text-center text-sm font-medium">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, descarga cualquier información que desees conservar.</p>
        </header>
        <DangerButton @click="confirmUserDeletion" class="w-full flex items-center justify-center gap-2 px-8 py-3 bg-gradient-to-r from-red-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-red-600 hover:scale-105 transition-all duration-200 text-lg mb-2">Eliminar cuenta</DangerButton>
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 bg-white dark:bg-gray-900 rounded-3xl border-2 border-red-400 dark:border-fuchsia-700">
                <h2 class="text-xl font-bold text-red-700 dark:text-red-400 mb-2 text-center">¿Estás seguro de que deseas eliminar tu cuenta?</h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mb-4 text-center">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.</p>
                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" class="sr-only" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-full"
                        placeholder="Contraseña"
                        @keyup.enter="deleteUser"
                        :disabled="form.processing"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <SecondaryButton @click="closeModal" :disabled="form.processing">
                        <span v-if="!form.processing">Cancelar</span>
                        <span v-else class="flex items-center gap-2">
                            <FontAwesomeIcon icon="fa-solid fa-spinner" class="animate-spin h-4 w-4 text-gray-400" />
                            Cancelando...
                        </span>
                    </SecondaryButton>
                    <DangerButton
                        class="ms-2 flex items-center gap-2 px-6 py-2 text-lg"
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        <FontAwesomeIcon icon="fa-solid fa-user-xmark" class="text-white text-xl" />
                        <span v-if="!form.processing">Eliminar cuenta</span>
                        <span v-else class="flex items-center gap-2">
                            <FontAwesomeIcon icon="fa-solid fa-spinner" class="animate-spin h-5 w-5 text-white" />
                            Eliminando...
                        </span>
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
