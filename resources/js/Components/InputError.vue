<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message" class="relative">
        <p class="absolute text-sm text-red-700 dark:text-red-400 -mt-1.5 right-1">
            {{ message }}
        </p>
    </div>
</template>
