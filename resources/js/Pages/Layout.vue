<template class="min-h-screen pb-8">
    <div class="mx-1 sm:mx-2 md:mx-4 lg:mx-2 xl:mx-0 pt-12 md:pt-16 pb-10">
        
        <Header />

        <main class="max-w-6xl mx-auto overflow-hidden p-2 mb-1 rounded-xl shadow-lg border border-orangeTheme transition-all duration-300">
            <slot />
        </main>

        <transition name="fade">
            <Footer />
        </transition>
    </div>
</template>

<script setup>
import Header from './Components/Header.vue'
import Footer from './Components/Footer.vue'
</script>