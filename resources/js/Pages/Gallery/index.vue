<template>
  <Head title="Gallerie | Cabane" />

  <Layout :allImagesDisplayed="allImagesDisplayed">
      <h1>Votre Voyage</h1>

      <div class="gallery grid grid-cols-1 md:grid-cols-2 gap-2 px-0 xs:px-2.5 md:px-0">
        <div 
          v-for="(image, index) in displayedImages" 
          :key="index" 
          class="image-item" 
          :class="{'col-span-2 flex justify-center': displayedImages.length % 2 !== 0 && index === displayedImages.length - 1}"
        >
          <img 
            :src="`${baseUrl}/gallery/${image}`"
            loading="lazy"
            :alt="getImageName(image)"
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
import { Head, usePage } from '@inertiajs/vue3';

const props = defineProps({
  images: Array
});

const { baseUrl } = usePage().props;
const displayedImages = ref([]);
const imagesPerLoadInitial = 10;
const imagesPerLoadScroll = 4;
const imagesLoaded = ref(0);
const windowWidth = ref(window.innerWidth);
const loading = ref(false);
const allImagesDisplayed = ref(false);

const loadImages = (initial = false) => {
  if (loading.value || imagesLoaded.value >= props.images.length) return;

  loading.value = true;
  const perLoad = initial ? imagesPerLoadInitial : imagesPerLoadScroll;
  const nextImages = props.images.slice(imagesLoaded.value, imagesLoaded.value + perLoad);
  displayedImages.value.push(...nextImages);
  imagesLoaded.value += perLoad;


  if (imagesLoaded.value >= props.images.length) {
    allImagesDisplayed.value = true;
    loading.value = false;
  } else {
    nextTick(() => {
      loading.value = false;
    });
  }
};

const handleScroll = () => {
  const scrollPosition = window.innerHeight + window.scrollY;
  const bottomOfPage = document.documentElement.scrollHeight;

  if (scrollPosition >= bottomOfPage - 100 && !loading.value && imagesLoaded.value < props.images.length) {
    loadImages();
  }
};

const handleResize = () => {
  windowWidth.value = window.innerWidth;
};

const getTransformOrigin = (index) => {
  if (displayedImages.value.length % 2 !== 0 && index === displayedImages.value.length - 1) {
    return { transformOrigin: 'unset' };
  }

  if (windowWidth.value >= 768) {
    return index % 2 === 0 
      ? { transformOrigin: 'left' }
      : { transformOrigin: 'right' };
  }
  return { transformOrigin: 'center' };
};

function getImageName(image) {
    const decodedImage = decodeURIComponent(image);
    const parts = decodedImage.split('.');
    parts.pop();
    return parts.join('.');
}

onMounted(() => {
  loadImages(true);
  window.addEventListener('scroll', handleScroll);
  window.addEventListener('resize', handleResize);
});

onBeforeUnmount(() => {  
  window.removeEventListener('scroll', handleScroll);
  window.removeEventListener('resize', handleResize);
});
</script>
