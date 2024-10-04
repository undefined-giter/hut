<template>
    <span 
        @click="toggleDarkMode"
        :class="['text-2xl -ml-3 transform hover:scale-105 origin-top-left cursor-pointer transition-all ease-in-out duration-1000', {'mr-0': windowWidth < 768, 'mr-4': windowWidth >= 768 && auth.user }]" >
        {{ isDarkMode ? '☀️' : '🌑' }}
    </span>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
const { auth } = usePage().props;

const isDarkMode = ref(true);
const windowWidth = ref(window.innerWidth);

const handleResize = () => {
    windowWidth.value = window.innerWidth;
};

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
    window.addEventListener('resize', handleResize);
});

onUnmounted(() => {
    window.removeEventListener('resize', handleResize);
});
</script>
