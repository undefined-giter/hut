<template>
    <footer v-if="showFooter && allImagesDisplayed">
        <div class="mx-1 sm:mx-2 md:mx-4 lg:mx-2 xl:mx-0">
            <div class="mx-0.5">
                <hr class="border border-orangeTheme h-[3px] bg-orangeTheme rounded-xl max-w-6xl mx-auto " />
            </div>
        </div>
        &copy; {{ new Date().getFullYear() }} - Votre moment de tranquilité
    </footer>
</template>

<script setup>
import { showFooter } from './../../shared/utils';
import { inject } from 'vue';

const allImagesDisplayed = inject('allImagesDisplayed', true);
</script>