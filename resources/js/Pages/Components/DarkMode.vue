<template>
    <span @click="toggleDarkMode" class="text-2xl cursor-pointer">
        {{ isDarkMode ? '☀️' : '🌑' }}
    </span>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const isDarkMode = ref(true);

const toggleDarkMode = () => {
    isDarkMode.value = !isDarkMode.value;
    document.documentElement.classList.toggle('dark', isDarkMode.value);
    localStorage.setItem('theme', isDarkMode.value ? 'dark' : 'light');
};

onMounted(() => {
    const savedTheme = localStorage.getItem('theme');
    if (savedTheme === 'dark') {
        isDarkMode.value = true;
        document.documentElement.classList.add('dark');
    } else {
        isDarkMode.value = false;
        document.documentElement.classList.remove('dark');
    }
});
</script>
