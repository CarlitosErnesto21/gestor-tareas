<script setup>
import { ref } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';

const props = defineProps({
    show: {
        type: Boolean,
        default: false,
    },
    task: {
        type: Object,
        default: null,
    },
});

const emit = defineEmits(['close', 'confirm']);

const isDeleting = ref(false);

function handleConfirm() {
    isDeleting.value = true;
    emit('confirm');
}

function handleClose() {
    if (!isDeleting.value) {
        emit('close');
    }
}
</script>

<template>
    <div v-if="show" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 animate-fade-in" @click="handleClose">
        <div class="bg-white/95 dark:bg-gray-900/95 rounded-3xl shadow-2xl p-8 max-w-md mx-4 border-4 border-red-400 dark:border-red-600 animate-scale-in" @click.stop>
            <div class="flex flex-col items-center text-center">
                <FontAwesomeIcon icon="fa-solid fa-trash" class="text-red-500 text-5xl mb-4 animate-pulse" />
                <h3 class="text-2xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-red-600 via-red-500 to-orange-500 mb-2">
                    Confirmar eliminación
                </h3>
                <p class="text-gray-700 dark:text-gray-200 mb-2">
                    ¿Estás seguro de que deseas eliminar la tarea?
                </p>
                <div v-if="task" class="bg-gray-100 dark:bg-gray-800 rounded-xl p-3 mb-4 w-full">
                    <p class="font-semibold text-gray-800 dark:text-white break-words">
                        "{{ task.title }}"
                    </p>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Esta acción no se puede deshacer.
                </p>
                <div class="flex gap-3 w-full">
                    <button
                        @click="handleClose"
                        :disabled="isDeleting"
                        class="flex-1 px-4 py-2 bg-gray-200 text-gray-800 rounded-xl shadow hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 transition disabled:opacity-50"
                    >
                        Cancelar
                    </button>
                    <button
                        @click="handleConfirm"
                        :disabled="isDeleting"
                        class="flex-1 px-4 py-2 bg-red-600 text-white rounded-xl shadow hover:bg-red-700 transition disabled:opacity-50 flex items-center justify-center gap-2"
                    >
                        <FontAwesomeIcon v-if="isDeleting" icon="fa-solid fa-spinner" class="animate-spin" />
                        <span>{{ isDeleting ? 'Eliminando...' : 'Eliminar' }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
@keyframes fade-in {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes scale-in {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.animate-fade-in {
    animation: fade-in 0.2s ease-out;
}

.animate-scale-in {
    animation: scale-in 0.3s ease-out;
}
</style>
