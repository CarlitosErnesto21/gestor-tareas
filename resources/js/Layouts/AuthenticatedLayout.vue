<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
    <div class="min-h-screen flex flex-col bg-gradient-to-br from-fuchsia-100 via-blue-100 to-cyan-100 dark:from-indigo-900 dark:via-blue-900 dark:to-gray-900 transition-colors duration-500">
            <nav
                class="border-b border-blue-300 dark:border-fuchsia-700 bg-white/90 dark:bg-gray-900/90 shadow-lg backdrop-blur-md sticky top-0 z-50"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between items-center gap-2">
                        <div class="flex items-center gap-2">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <svg class="block h-12 w-auto text-fuchsia-600 dark:text-blue-400 drop-shadow-lg hover:scale-105 transition-transform duration-200" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <defs>
                                            <linearGradient id="task-gradient" x1="0" y1="0" x2="1" y2="1">
                                                <stop offset="0%" stop-color="#f472b6" />
                                                <stop offset="100%" stop-color="#3b82f6" />
                                            </linearGradient>
                                        </defs>
                                        <rect x="6" y="10" width="36" height="28" rx="6" fill="url(#task-gradient)"/>
                                        <rect x="13" y="17" width="22" height="3" rx="1.5" fill="white"/>
                                        <rect x="13" y="24" width="14" height="3" rx="1.5" fill="white"/>
                                        <circle cx="36" cy="25.5" r="2.5" fill="white"/>
                                        <rect x="13" y="31" width="10" height="3" rx="1.5" fill="white"/>
                                        <circle cx="36" cy="32.5" r="2.5" fill="white"/>
                                    </svg>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div
                                class="hidden space-x-4 sm:-my-px sm:ms-6 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                    class="text-lg font-extrabold bg-gradient-to-r from-fuchsia-500 via-blue-500 to-cyan-400 bg-clip-text text-transparent drop-shadow-md hover:from-blue-600 hover:to-fuchsia-400 hover:text-white dark:hover:text-white transition-all duration-200"
                                >
                                    <span class="text-shadow">Tablero</span>
                                </NavLink>
                                <NavLink
                                    :href="route('tasks.index')"
                                    :active="route().current('tasks.*')"
                                    class="text-lg font-extrabold bg-gradient-to-r from-blue-600 via-fuchsia-500 to-cyan-400 bg-clip-text text-transparent drop-shadow-md hover:from-fuchsia-600 hover:to-blue-400 hover:text-white dark:hover:text-white transition-all duration-200"
                                >
                                    <span class="text-shadow">Tareas</span>
                                </NavLink>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <!-- Settings Dropdown -->
                            <div class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center rounded-xl border border-blue-300 dark:border-fuchsia-700 bg-gradient-to-r from-blue-100 to-fuchsia-100 dark:from-gray-800 dark:to-gray-900 px-4 py-2 text-base font-bold leading-4 text-blue-700 dark:text-fuchsia-400 shadow hover:from-fuchsia-200 hover:to-blue-200 dark:hover:from-blue-900 dark:hover:to-fuchsia-900 transition-all duration-200"
                                            >
                                                <span class="bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 bg-clip-text text-transparent dark:from-fuchsia-400 dark:via-blue-400 dark:to-cyan-300">
                                                    {{ $page.props.auth.user.name }}
                                                </span>
                                                <svg
                                                    class="-me-0.5 ms-2 h-4 w-4 text-blue-400 dark:text-fuchsia-400"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <DropdownLink
                                            :href="route('profile.edit')"
                                        >
                                                Perfil
                                        </DropdownLink>
                                        <DropdownLink
                                            :href="route('logout')"
                                            method="post"
                                            as="button"
                                        >
                                                Cerrar sesión
                                        </DropdownLink>
                                    </template>
                                </Dropdown>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="showingNavigationDropdown = !showingNavigationDropdown"
                                class="inline-flex items-center justify-center rounded-lg p-2 text-fuchsia-600 dark:text-blue-400 bg-white/80 dark:bg-gray-800/80 shadow hover:bg-fuchsia-100 hover:text-blue-700 dark:hover:bg-blue-900 dark:hover:text-fuchsia-400 focus:outline-none focus:ring-2 focus:ring-fuchsia-400 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900 transition-all duration-200"
                                aria-label="Abrir menú de navegación"
                            >
                                <svg
                                    class="h-7 w-7"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{ hidden: showingNavigationDropdown, 'inline-flex': !showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{ hidden: !showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden w-full bg-white/95 dark:bg-gray-900/95 shadow-lg border-b-2 border-fuchsia-400 dark:border-blue-700 animate-fade-in"
                >
                    <!-- Menú de navegación responsivo -->
                    <div class="space-y-1 pb-3 pt-2 px-2">
                        <ResponsiveNavLink
                            :href="route('dashboard')"
                            :active="route().current('dashboard')"
                            class="text-base font-bold bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 bg-clip-text text-transparent drop-shadow hover:from-blue-600 hover:to-fuchsia-400 hover:text-white dark:hover:text-white transition-all duration-200"
                        >
                            <span class="text-shadow">Tablero</span>
                        </ResponsiveNavLink>
                        <ResponsiveNavLink
                            :href="route('tasks.index')"
                            :active="route().current('tasks.*')"
                            class="text-base font-bold bg-gradient-to-r from-blue-600 via-fuchsia-500 to-cyan-400 bg-clip-text text-transparent drop-shadow hover:from-fuchsia-600 hover:to-blue-400 hover:text-white dark:hover:text-white transition-all duration-200"
                        >
                            <span class="text-shadow">Tareas</span>
                        </ResponsiveNavLink>
                    </div>
                    <!-- Opciones de usuario responsivas -->
                    <div class="border-t border-fuchsia-200 dark:border-blue-800 pb-1 pt-4 px-4">
                        <div class="mb-2">
                            <div class="text-base font-bold text-fuchsia-700 dark:text-blue-300 truncate">
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-xs font-medium text-gray-500 dark:text-gray-400 truncate">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>
                        <div class="mt-2 space-y-1">
                            <ResponsiveNavLink :href="route('profile.edit')"
                                class="text-base font-bold bg-gradient-to-r from-fuchsia-600 via-blue-500 to-cyan-400 bg-clip-text text-transparent drop-shadow hover:from-blue-600 hover:to-fuchsia-400 hover:text-white dark:hover:text-white transition-all duration-200"
                            >
                                <span class="text-shadow">Perfil</span>
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                                class="text-base font-bold bg-gradient-to-r from-blue-600 via-fuchsia-500 to-cyan-400 bg-clip-text text-transparent drop-shadow hover:from-fuchsia-600 hover:to-blue-400 hover:text-white dark:hover:text-white transition-all duration-200"
                            >
                                <span class="text-shadow">Cerrar sesión</span>
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white/90 dark:bg-gray-900/90 shadow-lg border-b-4 border-blue-400 dark:border-fuchsia-700"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 flex flex-col">
                <slot />
            </main>
            <footer class="w-full mt-auto py-4 bg-gradient-to-r from-blue-600 via-fuchsia-500 to-cyan-400 dark:from-fuchsia-700 dark:via-blue-800 dark:to-cyan-700 text-white text-center text-xs sm:text-sm font-semibold shadow-inner">
                &copy; {{ new Date().getFullYear() }} Gestor de Tareas &mdash; Desarrollado por Carlos Ernesto
            </footer>
        </div>
    </div>
</template>
