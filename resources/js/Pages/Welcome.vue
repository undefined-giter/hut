<template>
    <Head title="Bienvenue | Cabane" />

    <Layout>
        <h1 class="text-5xl">Bienvenue dans Votre Cabane Relaxante avec Jacuzzi</h1>

        <div class="flex justify-between">
            <div class="text-right opacity-0 hidden lg:block"> <!--- decoy to center phone part -->
                <p class="oleoScript">
                    Ou par mail : <span class="text-lg ml-3">moelleux@gmail.com</span>
                </p>
            </div>

            <div class="text-center">
                <p class="oleoScript pl-3 lg:pl-0">
                    Réservez directement au <span class="text-xl text-orangeTheme select-text">06 XX XX XX XX</span>
                </p>
            </div>

            <div class="text-right">
                <p class="oleoScript">
                    Ou par mail : <span class="text-lg text-orangeTheme select-text mr-4">moelleux@gmail.com</span>
                </p>
            </div>
        </div>
        <div class="relative inset-0 h-[50vh] overflow-hidden mb-4 max-h-[630px] sm:h-[70vh]">

            <div class="eyes-container">
                <div class="eyes">
                    <div><i></i></div>
                    <div><i></i></div>
                </div>
            </div>

            <div 
                v-for="(image, index) in images" 
                :key="index" 
                class="absolute inset-0 bg-cover bg-center transition-opacity duration-[1500ms] ease-in-out rounded-2xl"
                :style="{ backgroundImage: `url(${image})`, opacity: currentImageIndex === index ? 1 : 0 }">
            </div>
        </div>

        <div class="relative w-full pb-[56.25%] mb-4">
            <iframe 
                src="https://www.google.com/maps/embed?pb=!1m17!1m12!1m3!1d1201.9776837990648!2d5.830602617608928!3d44.832094151869775!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m2!1m1!2zNDTCsDQ5JzU1LjgiTiA1wrA0OSc1MC42IkU!5e1!3m2!1sen!2sfr!4v1727200749894!5m2!1sen!2sfr" 
                class="absolute inset-0 w-full h-full rounded-2xl border-0"
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Layout from './Layout.vue';

const images = [
    `${baseUrl}/gallery/hut_front.jpg`,
    `${baseUrl}/gallery/hut_porch.jpg`,
    `${baseUrl}/gallery/hut_side.jpg`
];

const currentImageIndex = ref(0);

let timeoutId;
let intervalId;

const changeImage = () => {
    currentImageIndex.value = (currentImageIndex.value + 1) % images.length;
};

onMounted(() => {
    timeoutId = setTimeout(() => {
        changeImage();
        intervalId = setInterval(() => {
            changeImage();
        }, 6500);
    }, 4000);
});

onUnmounted(() => {
    clearTimeout(timeoutId);
    clearInterval(intervalId);
});


document.addEventListener('mousemove', (e) => {
    const eyesContainer = document.querySelector('.eyes');
    const eyes = document.querySelectorAll('.eyes > div');
    
    if (!eyesContainer || eyes.length !== 2) return;
    
    const containerRect = eyesContainer.getBoundingClientRect();
    const containerCenterX = containerRect.left + containerRect.width / 2;
    const containerCenterY = containerRect.top + containerRect.height / 2;


    const angle = Math.atan2(e.clientY - containerCenterY, e.clientX - containerCenterX);
    const distance = Math.min(
        eyes[0].offsetWidth / 4,
        Math.sqrt(Math.pow(e.clientX - containerCenterX, 2) + Math.pow(e.clientY - containerCenterY, 2))
    );


    const moveX = Math.cos(angle) * distance;
    const moveY = Math.sin(angle) * distance;


    eyes.forEach(eye => {
        const eyeBall = eye.querySelector('i');
        eyeBall.style.transform = `translate(${moveX}px, ${moveY}px)`;
    });
});
</script>
