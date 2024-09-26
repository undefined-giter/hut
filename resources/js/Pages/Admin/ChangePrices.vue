<template>
    <div>
        <Head title="Modifier les Prix | Admin" />
        <Layout>
            <h1 class="text-2xl font-bold text-blue-700 dark:text-blue-500 mb-6">Modifier les prix</h1>
            
            <form @submit.prevent="updatePrices" class="p-6 rounded-lg shadow-md border border-[#EA580C]">
                <div class="mb-4">
                    <label for="price_per_night" class="block text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Prix par nuit :
                    </label>
                    <input 
                        v-model="form.price_per_night"
                        type="number"
                        step="1"
                        min="0"
                        id="price_per_night"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 font-semibold bg-gray-400 dark:bg-gray-800 dark:text-gray-200"
                    />
                </div>

                <div class="mb-6">
                    <label for="price_per_night_for_2_and_more_nights" class="block text-lg font-semibold text-gray-700 dark:text-gray-200 mb-2">
                        Prix par nuit (2 nuits et plus) :
                    </label>
                    <input 
                        v-model="form.price_per_night_for_2_and_more_nights"
                        type="number"
                        step="1"
                        min="0"
                        id="price_per_night_for_2_and_more_nights"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:border-blue-600 focus:ring-1 focus:ring-blue-600 font-semibold bg-gray-400 dark:bg-gray-800 dark:text-gray-200"
                    />
                </div>

                <div class="flex justify-between">
                    <button type="button" @click="goBack();" class="btn bg-gray-500 hover:bg-gray-600 text-white font-bold px-6 py-2 rounded-lg shadow focus:outline-none focus:ring focus:ring-gray-300">
                        Retour
                    </button>

                    <button type="submit" class="btn">Enregistrer</button>
                </div>
            </form>
        </Layout>
    </div>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import Layout from './../Layout.vue';

const props = defineProps(['price_per_night', 'price_per_night_for_2_and_more_nights']);
const form = useForm({
    price_per_night: props.price_per_night,
    price_per_night_for_2_and_more_nights: props.price_per_night_for_2_and_more_nights,
});

const updatePrices = () => {
    form.post('/prices/update');
};

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        Inertia.visit('/options');
    }
};
</script>

