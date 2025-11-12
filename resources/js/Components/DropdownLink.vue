<script setup>
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: {
        type: String,
        required: true,
    },
    method: {
        type: String,
        default: undefined,
    },
    as: {
        type: String,
        default: undefined,
    },
});
</script>

<template>
    <Link
        :href="href"
        :method="method"
        :as="as"
        class="block w-full px-4 py-2 text-start text-base font-semibold leading-5 text-gray-800 dark:text-gray-100 transition-all duration-200 ease-in-out rounded-lg hover:bg-gradient-to-r hover:from-fuchsia-500 hover:to-blue-500 hover:text-white focus:bg-gradient-to-r focus:from-blue-500 focus:to-fuchsia-500 focus:text-white focus:outline-none shadow-none"
    >
        <slot />
    </Link>
</template>
