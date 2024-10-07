<template>
    <Head title="Modifier les Prix | Admin" />
    <Layout>
        <h1>Modifier les prix</h1>

        <form @submit.prevent="updatePrices" class="max-w-sm mx-auto">
            
            <div class="mb-4">
                <label for="price_per_night"> Prix par nuit :</label>
                <input 
                    v-model="form.price_per_night"
                    type="number"
                    step="1"
                    min="0"
                    id="price_per_night"
                    class="w-full"
                />
            </div>

            <div class="mb-6">
                <label for="price_per_night_for_2_and_more_nights">Prix par nuit pour 2 nuits et + :</label>
                <input 
                    v-model="form.price_per_night_for_2_and_more_nights"
                    type="number"
                    step="1"
                    min="0"
                    id="price_per_night_for_2_and_more_nights"
                    class="w-full px-4 py-2"
                />
            </div>

            <div class="flex justify-between -mt-4">
                <button type="button" @click="goBack();" class="btn">Retour</button>

                <button type="submit" class="btn">Enregistrer</button>
            </div>
        </form>
    </Layout>
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

