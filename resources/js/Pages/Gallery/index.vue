<template>
  <Head title="Gallerie | Cabane" />

  <Layout>
      <h1>Votre Voyage</h1>

      <div class="gallery grid grid-cols-1 md:grid-cols-2 gap-2 px-0 xs:px-2.5 md:px-0">
          <div v-for="(image, index) in displayedImages" :key="index" class="image-item">
              <img 
                  :src="`/storage/gallery/${image}`" 
                  alt="Photo de la cabane" 
                  :title="image.name"
                  :style="getTransformOrigin(index)"
                  class="w-full h-64 object-cover rounded-lg mb-1 shadow-md transition-transform transform hover:scale-110 hover:z-40 relative"
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
const windowWidth = ref(window.innerWidth);

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

const handleResize = () => {
  windowWidth.value = window.innerWidth;
};

const getTransformOrigin = (index) => {
  if (windowWidth.value >= 768) {
    return index % 2 === 0 
      ? { transformOrigin: 'left' }
      : { transformOrigin: 'right' };
  }
  return { transformOrigin: 'center' };
};

onMounted(() => {
  loadImages();
  window.addEventListener('scroll', handleScroll);
  window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {  
  window.removeEventListener('scroll', handleScroll);
  window.removeEventListener('resize', handleResize);
});
</script>

<style scoped>
.gallery img {transition: transform 0.3s ease;}
</style>
