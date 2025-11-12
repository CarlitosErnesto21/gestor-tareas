<script setup>
import { ref } from 'vue';
import { Head, Link, router as Inertia } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const returning = ref(false);
function handleReturn(e) {
    if (returning.value) return;
    returning.value = true;
    Inertia.visit(route('profile.edit'), {
        onFinish: () => {
            returning.value = false;
        }
    });
}
</script>

<template>
    <Head title="Eliminar cuenta" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col items-center gap-2">
                <div class="flex items-center justify-center gap-3">
                    <FontAwesomeIcon icon="fa-solid fa-user-xmark" class="h-8 w-8 text-red-500 dark:text-fuchsia-400 drop-shadow-lg" />
                    <h2 class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-pink-500 to-fuchsia-400 dark:from-fuchsia-400 dark:via-pink-400 dark:to-red-400 drop-shadow-lg text-center">
                        Eliminar cuenta
                    </h2>
                </div>
                <div class="flex justify-center mt-2">
                    <Link
                        :href="route('profile.edit')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-blue-500 to-fuchsia-500 text-white font-bold rounded-xl shadow hover:from-fuchsia-500 hover:to-blue-500 hover:scale-105 transition-all duration-200 disabled:opacity-60 disabled:cursor-not-allowed"
                        :disabled="returning"
                        @click.prevent="handleReturn"
                    >
                        <FontAwesomeIcon v-if="!returning" icon="fa-solid fa-arrow-left" class="h-5 w-5" />
                        <FontAwesomeIcon v-else icon="fa-solid fa-spinner" spin class="h-5 w-5 animate-spin" />
                        <span v-if="!returning">Volver al perfil</span>
                        <span v-else>Regresando...</span>
                    </Link>
                </div>
            </div>
        </template>
        <div class="py-10 flex flex-col items-center min-h-[60vh]">
            <div class="w-full max-w-xl px-4 sm:px-6 lg:px-8">
                <DeleteUserForm />
            </div>
        </div>
    </AuthenticatedLayout>
</template>
