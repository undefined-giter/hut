<template>
    <Head title="Bienvenue | Cabane" />

    <Layout>
        <h1 class="text-2xl font-semibold mb-6 text-center">Bienvenue</h1>
    
        <img src="/imgs/hut_front.jpg" alt="Photo de la cabane" draggable="false" class="rounded-lg">
        <br>
        <img src="/imgs/hut_side.jpg" alt="Photo de la cabane" draggable="false" class="rounded-lg">
        <br>
        <img src="/imgs/hut_porch.jpg" alt="Photo de la cabane" draggable="false" class="rounded-lg">
        <br><br>
    </Layout>
</template>

<script setup>
import Layout from './Layout.vue';
import { Head } from '@inertiajs/vue3';
</script>
