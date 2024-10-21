<template>
    <Head title="Bienvenue | Cabane" />

    <Layout>
        <h1 class="text-5xl">Bienvenue dans Votre Cabane Relaxante avec Jacuzzi</h1>

        <div class="flex justify-between oleoScript font-bold">

            <p class="ml-4">Réservez directement au <span class="text-2xl text-orangeTheme select-text">06 XX XX XX XX</span></p>

            <Link :href="route('book')" class="mr-4 text-right"><p>Réservez votre séjour dans notre cabane dès maintenant</p></Link>
            
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
                class="lazyload absolute inset-0 bg-cover bg-center transition-opacity duration-[1500ms] ease-in-out rounded-2xl"
                :style="{ backgroundImage: `url(${image})`, opacity: currentImageIndex === index ? 1 : 0 }">
            </div>
        </div>

        <div class="relative w-full pb-[56.25%] mb-4">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d76894.95095827775!2d5.810677613083541!3d44.81160184397263!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x12cb2c55c34b1d6d%3A0x439021acadf94417!2zQ29yZMOpYWMsIDM4NzEwIENow6J0ZWwtZW4tVHJpw6h2ZXM!5e1!3m2!1sen!2sfr!4v1729516566125!5m2!1sen!2sfr"class="absolute inset-0 w-full h-full rounded-2xl border-0"
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
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
