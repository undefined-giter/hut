<template>
    <Head title="Gallerie | Cabane" />

    <Layout>
        <h1>Votre voyage</h1>
    
        <div class="gallery grid grid-cols-2 gap-4">
            <div v-for="(image, index) in displayedImages" :key="index" class="image-item">
                <img 
                    :src="`/storage/gallery/${image}`" 
                    alt="Photo de la cabane" 
                    draggable="false" 
                    class="w-full h-64 object-cover rounded-lg mb-1 shadow-md transition-transform transform hover:scale-110 hover:z-50 relative"
                >
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount, nextTick } from 'vue';
import Layout from './../Layout.vue';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  images: Array
});

const displayedImages = ref([]);
const imagesPerLoad = 2;
const imagesLoaded = ref(0);

const loadImages = () => {
  if (imagesLoaded.value >= props.images.length) return;

  const nextImages = props.images.slice(imagesLoaded.value, imagesLoaded.value + imagesPerLoad);
  displayedImages.value.push(...nextImages);
  imagesLoaded.value += imagesPerLoad;

  nextTick(() => {
    if (document.documentElement.scrollHeight <= window.innerHeight) {
      loadImages();
    }
  });
};

const handleScroll = () => {
  const scrollPosition = window.innerHeight + window.scrollY;
  const bottomOfPage = document.documentElement.offsetHeight;

  if (scrollPosition >= bottomOfPage - 100) {
    loadImages();
  }
};

onMounted(() => {
  loadImages();
  window.addEventListener('scroll', handleScroll);
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
