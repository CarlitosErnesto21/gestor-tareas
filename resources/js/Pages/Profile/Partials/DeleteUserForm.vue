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
    <section class="bg-white dark:bg-gray-900 rounded-xl shadow-lg p-6">
        <header class="mb-4">
            <h2 class="text-xl font-bold text-red-700 dark:text-red-400">Eliminar cuenta</h2>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Antes de eliminar tu cuenta, descarga cualquier información que desees conservar.</p>
        </header>
        <DangerButton @click="confirmUserDeletion">Eliminar cuenta</DangerButton>
        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6 bg-white dark:bg-gray-900 rounded-xl">
                <h2 class="text-lg font-bold text-red-700 dark:text-red-400 mb-2">¿Estás seguro de que deseas eliminar tu cuenta?</h2>
                <p class="text-sm text-gray-500 dark:text-gray-300 mb-4">Una vez que tu cuenta sea eliminada, todos sus recursos y datos serán borrados permanentemente. Ingresa tu contraseña para confirmar que deseas eliminar tu cuenta de forma permanente.</p>
                <div class="mt-4">
                    <InputLabel for="password" value="Contraseña" class="sr-only" />
                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Contraseña"
                        @keyup.enter="deleteUser"
                    />
                    <InputError :message="form.errors.password" class="mt-2" />
                </div>
                <div class="mt-6 flex justify-end gap-2">
                    <SecondaryButton @click="closeModal">
                        Cancelar
                    </SecondaryButton>
                    <DangerButton
                        class="ms-2"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Eliminar cuenta
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
