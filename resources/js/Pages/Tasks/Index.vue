<script setup>
import { router } from '@inertiajs/vue3';
import { ref, watch } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import DeleteModal from './Delete.vue';

const props = defineProps({
    tasks: {
        type: Array,
        required: true,
    },
    filterStatus: {
        type: String,
        default: '',
    },
});

function updateTaskStatus(taskId, newStatus) {
    // Agregar animación si el nuevo estado es completada
    if (newStatus === 'completada') {
        const taskElement = document.querySelector(`[data-task-id="${taskId}"]`);
        if (taskElement) {
            const icon = taskElement.querySelector('.task-status-icon');
            if (icon) {
                icon.classList.add('animate-completion');
                setTimeout(() => {
                    icon.classList.remove('animate-completion');
                }, 1000);
            }
        }
    }

    // Enviar solicitud PATCH al backend para actualizar el estado
    router.patch(route('tasks.updateStatus', taskId),
        { status: newStatus },
        {
            preserveState: true,
            preserveScroll: true,
            preserveComponent: true,
            onSuccess: () => {
                // Actualizar localmente la tarea en el array
                const taskIndex = tasksLocal.value.findIndex(task => task.id === taskId);
                if (taskIndex !== -1) {
                    tasksLocal.value[taskIndex].status = newStatus;
                }

                // Filtrar las tareas localmente según el filtro activo
                filterTasksLocally();
            },
            onError: (errors) => {
                // Error al actualizar estado
            }
        }
    );
}

function filterTasksLocally() {
    // Filtrar las tareas locales según el filtro activo
    if (selectedStatus.value && selectedStatus.value !== '') {
        // Si hay un filtro activo, quitar las tareas que ya no corresponden
        tasksLocal.value = tasksLocal.value.filter(task => task.status === selectedStatus.value);
    }
    // Si no hay filtro activo (''), no necesitamos hacer nada adicional
    // porque la tarea ya fue actualizada en el array local
}

function setStatus(val) {
    selectedStatus.value = val;
    handleFilterChange();
}

const statusOptions = [
    { value: '', label: 'Todos' },
    { value: 'pendiente', label: 'Pendiente' },
    { value: 'en_progreso', label: 'En progreso' },
    { value: 'completada', label: 'Completada' },
];

let selectedStatus = ref('');
if (typeof props.filterStatus === 'string') {
    selectedStatus.value = props.filterStatus;
}
const showDeleteModal = ref(false);
const taskToDelete = ref(null);

// Copia reactiva local de tareas
const tasksLocal = ref([...props.tasks]);

// Sincronizar tasksLocal cuando cambian los props
watch(() => props.tasks, (newTasks) => {
    tasksLocal.value = [...newTasks];
});

function handleFilterChange() {
    router.get(route('tasks.index'), { status: selectedStatus.value }, {
        preserveState: true,
        preserveScroll: true,
        preserveComponent: true,
        only: ['tasks', 'filterStatus'],
        replace: true,
        onStart: () => {
            // Opcional: mostrar indicador de carga
        },
        onFinish: () => {
            // Opcional: ocultar indicador de carga
        }
    });
}

function openDeleteModal(task) {
    taskToDelete.value = task;
    showDeleteModal.value = true;
}

function closeDeleteModal() {
    showDeleteModal.value = false;
    taskToDelete.value = null;
    // Resetear cualquier estado de carga en el modal
    setTimeout(() => {
        // Forzar re-render del modal para resetear isDeleting
        // Modal cerrado y estado reseteado
    }, 100);
}

function confirmDelete() {
    if (taskToDelete.value) {
        const taskId = taskToDelete.value.id;
        router.delete(route('tasks.destroy', taskId), {
            preserveState: true,
            preserveScroll: true,
            preserveComponent: true,
            replace: true,
            onStart: () => {
                // Iniciando eliminación
            },
            onSuccess: () => {
                // Remover la tarea del array local
                const taskIndex = tasksLocal.value.findIndex(task => task.id === taskId);
                if (taskIndex !== -1) {
                    tasksLocal.value.splice(taskIndex, 1);
                }

                closeDeleteModal();
            },
            onFinish: () => {
                // Asegurar que el modal se resetee
                if (showDeleteModal.value) {
                    closeDeleteModal();
                }
            },
            onError: (errors) => {
                // Error al eliminar tarea
            }
        });
    }
}
</script>

<template>
    <Head title="Mis Tareas" />
    <AuthenticatedLayout>
        <template #header>
            <div class="flex flex-col gap-4">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 sm:gap-0 flex-wrap w-full">
                    <div class="flex items-center gap-2 flex-wrap justify-center sm:justify-start w-full sm:w-auto">
                        <FontAwesomeIcon icon="fa-solid fa-list-check" class="text-fuchsia-600 dark:text-blue-400 h-8 w-8 drop-shadow-lg animate-bounce" />
                        <h1 class="text-2xl sm:text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300">Mis Tareas</h1>
                    </div>
                    <Link :href="route('tasks.create')" class="flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-blue-600 to-fuchsia-500 text-white font-bold rounded-xl shadow-lg hover:from-fuchsia-500 hover:to-blue-600 hover:scale-105 transition-all duration-200 text-lg w-full sm:w-auto justify-center">
                        <FontAwesomeIcon icon="fa-solid fa-plus" class="text-white text-xl" />
                        Nueva tarea
                    </Link>
                </div>
                <div class="flex items-center justify-center sm:justify-start w-full">
                    <span class="text-gray-500 dark:text-gray-300 text-center sm:text-left">Aquí puedes gestionar tus tareas personales.</span>
                </div>
                <!-- Filtro tipo tabs -->
                <div class="flex flex-row gap-2 justify-center sm:justify-start mt-2 flex-wrap">
                    <button
                        v-for="opt in statusOptions"
                        :key="opt.value"
                        @click="setStatus(opt.value)"
                        :class="[
                            'flex items-center gap-2 px-4 py-2 rounded-full font-semibold border transition-all duration-200',
                            selectedStatus.value === opt.value
                                ? 'bg-blue-600 text-white border-blue-600 shadow-lg scale-105'
                                : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200 border-gray-300 hover:bg-gray-900 hover:scale-105'
                        ].filter(c => !(selectedStatus.value === opt.value && c.includes('bg-gray'))).join(' ')"
                    >
                        <FontAwesomeIcon
                                :icon="
                                    opt.value === 'pendiente' ? 'fa-solid fa-clock'
                                    : opt.value === 'en_progreso' ? 'fa-solid fa-spinner'
                                    : opt.value === 'completada' ? 'fa-solid fa-check-circle'
                                    : 'fa-solid fa-list-check'
                                "
                                :class="[
                                    selectedStatus === opt.value
                                        ? (opt.value === 'completada' ? 'animate-check-bounce'
                                          : opt.value === 'en_progreso' ? 'text-blue-300 animate-spin'
                                          : opt.value === 'pendiente' ? 'text-yellow-300 animate-clock-tick'
                                          : 'text-white')
                                        : opt.value === 'pendiente' ? 'text-yellow-500'
                                        : opt.value === 'en_progreso' ? 'text-blue-500'
                                        : opt.value === 'completada' ? 'text-green-500'
                                        : 'text-fuchsia-500'
                                ]"
                        />
                        {{ opt.label }}
                    </button>
                </div>
            </div>
        </template>
        <div class="w-full max-w-2xl mx-auto bg-white/90 dark:bg-gray-900/90 rounded-3xl shadow-2xl p-4 sm:p-8 mt-4 sm:mt-6 border-4 border-blue-400 dark:border-fuchsia-700">
            <!-- Filtro desplegable eliminado, solo filtro tipo tabs arriba -->
            <div v-if="tasksLocal.length === 0" class="text-gray-500 dark:text-gray-300 text-center py-8">
                <FontAwesomeIcon icon="fa-solid fa-circle-info" class="text-blue-400 text-3xl mb-2" />
                <div>No tienes tareas registradas.</div>
            </div>
            <div v-else class="mb-2 text-xs text-blue-500 dark:text-blue-300 text-center">
                Haz clic en cualquier tarjeta para ver los detalles de la tarea.
            </div>
            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                <li v-for="task in tasksLocal" :key="task.id" :data-task-id="task.id" class="py-4 flex flex-col gap-2 sm:gap-1 cursor-pointer group relative" @click="router.get(route('tasks.show', task.id), {}, { preserveState: true })">
                    <!-- Botones editar y eliminar en la esquina superior derecha, con margen para no superponerse -->
                    <div class="absolute top-4 right-4 flex flex-row gap-2 z-10" @click.stop>
                        <Link :href="route('tasks.edit', task.id)" class="flex items-center px-3 py-2 bg-blue-600 text-white rounded-xl shadow hover:bg-blue-700 text-sm font-semibold justify-center">
                            <FontAwesomeIcon icon="fa-solid fa-pen-to-square" class="text-white" />
                        </Link>
                        <button @click="openDeleteModal(task)" class="flex items-center px-3 py-2 bg-red-600 text-white rounded-xl shadow hover:bg-red-700 text-sm font-semibold justify-center">
                            <FontAwesomeIcon icon="fa-solid fa-trash" class="text-white" />
                        </button>
                    </div>
                    <div class="flex flex-col gap-1 mt-2">
                        <div class="flex items-center gap-2 flex-wrap">
                            <FontAwesomeIcon :icon="task.status === 'completada' ? 'fa-solid fa-check-circle' : (task.status === 'en_progreso' ? 'fa-solid fa-spinner' : 'fa-solid fa-clock')" :class="{
                                'text-green-500': task.status === 'completada',
                                'text-blue-500 animate-spin': task.status === 'en_progreso',
                                'text-yellow-500': task.status === 'pendiente',
                            }" class="h-5 w-5 task-status-icon transition-all duration-300" />
                            <span class="font-semibold text-gray-800 dark:text-white break-words max-w-[60vw] sm:max-w-xs">{{ task.title }}</span>
                        </div>
                        <span :class="{
                            'bg-yellow-100 text-yellow-800': task.status === 'pendiente',
                            'bg-blue-100 text-blue-800': task.status === 'en_progreso',
                            'bg-green-100 text-green-800': task.status === 'completada',
                        }" class="px-2 py-1 rounded text-xs font-bold whitespace-nowrap mt-1 w-fit">
                            {{ task.status.replace('_', ' ').toUpperCase() }}
                        </span>
                    </div>
                    <div class="text-gray-600 dark:text-gray-300 text-sm break-words max-w-full">{{ task.description }}</div>
                    <div class="text-xs text-gray-400 mt-1 flex items-center gap-2 flex-wrap">
                        <FontAwesomeIcon icon="fa-solid fa-calendar-days" class="text-blue-400" />
                        <span class="break-words">Fecha límite: {{ task.due_date || 'Sin fecha' }}</span>
                    </div>
                    <div class="flex flex-row flex-nowrap gap-2 mt-2 w-full justify-start overflow-x-auto" @click.stop>
                        <!-- Botones de cambio de estado -->
                        <template v-if="task.status === 'pendiente'">
                            <button @click="updateTaskStatus(task.id, 'en_progreso')" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-xl shadow hover:bg-blue-600 text-sm font-semibold w-full sm:w-auto justify-center">
                                <FontAwesomeIcon icon="fa-solid fa-spinner" class="text-white" />
                                Marcar en progreso
                            </button>
                            <button @click="updateTaskStatus(task.id, 'completada')" class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-xl shadow hover:bg-green-600 text-sm font-semibold w-full sm:w-auto justify-center">
                                <FontAwesomeIcon icon="fa-solid fa-check-circle" class="text-white" />
                                Marcar completada
                            </button>
                        </template>
                        <template v-else-if="task.status === 'en_progreso'">
                            <button @click="updateTaskStatus(task.id, 'pendiente')" class="flex items-center gap-2 px-4 py-2 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600 text-sm font-semibold w-full sm:w-auto justify-center">
                                <FontAwesomeIcon icon="fa-solid fa-clock" class="text-white" />
                                Marcar pendiente
                            </button>
                            <button @click="updateTaskStatus(task.id, 'completada')" class="flex items-center gap-2 px-4 py-2 bg-green-500 text-white rounded-xl shadow hover:bg-green-600 text-sm font-semibold w-full sm:w-auto justify-center">
                                <FontAwesomeIcon icon="fa-solid fa-check-circle" class="text-white" />
                                Marcar completada
                            </button>
                        </template>
                        <template v-else-if="task.status === 'completada'">
                            <button @click="updateTaskStatus(task.id, 'pendiente')" class="flex items-center gap-2 px-4 py-2 bg-yellow-500 text-white rounded-xl shadow hover:bg-yellow-600 text-sm font-semibold w-full sm:w-auto justify-center">
                                <FontAwesomeIcon icon="fa-solid fa-clock" class="text-white" />
                                Marcar pendiente
                            </button>
                            <button @click="updateTaskStatus(task.id, 'en_progreso')" class="flex items-center gap-2 px-4 py-2 bg-blue-500 text-white rounded-xl shadow hover:bg-blue-600 text-sm font-semibold w-full sm:w-auto justify-center">
                                <FontAwesomeIcon icon="fa-solid fa-spinner" class="text-white" />
                                Marcar en progreso
                            </button>
                        </template>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Modal de confirmación de eliminación -->
        <DeleteModal
            :key="taskToDelete?.id || 'modal'"
            :show="showDeleteModal"
            :task="taskToDelete"
            @close="closeDeleteModal"
            @confirm="confirmDelete"
        />
    </AuthenticatedLayout>
</template>

<style scoped>
@keyframes completion-bounce {
    0% {
        transform: scale(1);
        filter: brightness(1);
    }
    25% {
        transform: scale(1.3) rotate(15deg);
        filter: brightness(1.5) drop-shadow(0 0 10px #10b981);
    }
    50% {
        transform: scale(1.5) rotate(-10deg);
        filter: brightness(2) drop-shadow(0 0 15px #10b981);
    }
    75% {
        transform: scale(1.2) rotate(5deg);
        filter: brightness(1.3) drop-shadow(0 0 8px #10b981);
    }
    100% {
        transform: scale(1);
        filter: brightness(1);
    }
}

.animate-completion {
    animation: completion-bounce 1s ease-in-out;
}

@keyframes check-bounce {
  0% { transform: scale(1) rotate(0deg); }
  25% { transform: scale(1.2) rotate(-5deg); }
  50% { transform: scale(1.4) rotate(5deg); }
  75% { transform: scale(1.1) rotate(-2deg); }
  100% { transform: scale(1) rotate(0deg); }
}

.animate-check-bounce {
  animation: check-bounce 1s ease-in-out infinite !important;
  filter: drop-shadow(0 0 10px #10b981) brightness(1.8) !important;
  color: #10b981 !important;
}

@keyframes clock-tick {
  0% { transform: rotate(0deg) scale(1); }
  25% { transform: rotate(5deg) scale(1.1); }
  50% { transform: rotate(-5deg) scale(1.2); }
  75% { transform: rotate(3deg) scale(1.1); }
  100% { transform: rotate(0deg) scale(1); }
}

.animate-clock-tick {
  animation: clock-tick 2s ease-in-out infinite !important;
  filter: drop-shadow(0 0 8px #f59e0b) brightness(1.6) !important;
  color: #f59e0b !important;
}
</style>
