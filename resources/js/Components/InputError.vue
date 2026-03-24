<script setup>
defineProps({
    message: {
        type: String,
    },
});
</script>

<template>
    <div v-show="message">
        <p class="text-sm  mt-2 text-red-600 dark:text-red-400">
            {{ message }}
        </p>
    </div>
</template>
