<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>


<template>
    <div class="flex min-h-screen flex-col items-center justify-center bg-gradient-to-br from-blue-50 to-blue-200 dark:from-gray-900 dark:to-gray-800 py-8">
        <div>
            <Link href="/">
                <ApplicationLogo class="h-20 w-20 fill-current text-blue-600 dark:text-blue-400" />
            </Link>
        </div>
        <div class="mt-6 w-full max-w-md bg-white dark:bg-gray-900 rounded-xl shadow-lg px-8 py-6">
            <slot />
        </div>
    </div>
</template>
