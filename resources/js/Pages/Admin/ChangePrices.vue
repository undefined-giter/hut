<template>
    <Head title="Modifier les Prix | Admin" />
    <Layout>
        <h1>Modifier les prix</h1>

        <form @submit.prevent="updatePrices" class="max-w-sm mx-auto bg-light dark:bg-dark rounded-lg p-4">

            <div class="mb-4">
                <label for="price_per_night" class="label">Prix par nuit :</label>
                <input 
                    v-model="form.price_per_night"
                    type="number"
                    step="1"
                    min="0"
                    id="price_per_night"
                    class="w-full"
                />
                <div v-if="errors.price_per_night" class="text-red-500">
                    {{ errors.price_per_night }}
                </div>
            </div>

            <div class="mb-4">
                <label for="price_per_night_for_2_and_more_nights" class="label">Prix par nuit pour 2 nuits et + :</label>
                <input 
                    v-model="form.price_per_night_for_2_and_more_nights"
                    type="number"
                    step="1"
                    min="0"
                    id="price_per_night_for_2_and_more_nights"
                    class="w-full px-4 py-2"
                />
                <div v-if="errors.price_per_night_for_2_and_more_nights" class="text-red-500">
                    {{ errors.price_per_night_for_2_and_more_nights }}
                </div>
            </div>

            <div class="mb-2">
                <label for="percent_reduced_week" 
                    title="Les valeurs négatives augmentent le prix (des nuits de lundi à vendredi)"
                    class="label"
                >Pourcentage de réduction de lundi 14h à vendredi 12h :</label>
                <input 
                    v-model="form.percent_reduced_week"
                    type="number"
                    step="1"
                    max="100"
                    id="percent_reduced_week"
                    class="w-full px-4 py-2"
                />
                <div v-if="errors.percent_reduced_week" class="text-red-500">
                    {{ errors.percent_reduced_week }}
                </div>
            </div>
            
            <div class="flex justify-between mb-6">
                <button type="button" @click="goBack();" class="btn">Retour</button>
                
                <button type="submit" class="btn">Enregistrer</button>
            </div>

            <div>
                <div @click="toggleUnroll(5)" class="flex cursor-pointer">
                    <h3 class="underline !text-orangeTheme text-lg">{{ isUnrolled(5) ? 'Cacher' : 'Afficher' }} les Dates Spéciales</h3>
                    <h3 style="transform: translateY(4px); text-decoration: none; font-size: 0.9em;">{{ isUnrolled(5) ? '🔼' : '🔽' }}</h3>
                </div>
    
                <transition name="fade">
                    <SpecialsDatesPrices v-if="isUnrolled(5)" />
                </transition>
            </div>

            <div>
                <div @click="toggleUnroll(7)" class="flex cursor-pointer">
                    <h3 class="underline !text-orangeTheme text-lg">{{ isUnrolled(7) ? 'Cacher' : 'Afficher' }} les Dates Limites</h3>
                    <h3 style="transform: translateY(4px); text-decoration: none; font-size: 0.9em;">{{ isUnrolled(5) ? '🔼' : '🔽' }}</h3>
                </div>
    
                <transition name="fade">
                    <LimitesDates v-if="isUnrolled(7)" />
                </transition>
            </div>
        </form>
    </Layout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import Layout from './../Layout.vue';
import { useUnroll } from './../../shared/utils';
import SpecialsDatesPrices from './SpecialsDatesPrices.vue';
import LimitesDates from './LimitesDates.vue';

const props = defineProps(['errors', 'price_per_night', 'price_per_night_for_2_and_more_nights', 'percent_reduced_week']);

const form = useForm({
    price_per_night: props.price_per_night,
    price_per_night_for_2_and_more_nights: props.price_per_night_for_2_and_more_nights,
    percent_reduced_week: props.percent_reduced_week,
});

const updatePrices = () => {
    form.post(route('admin.prices.update'));
};

const { isUnrolled, toggleUnroll } = useUnroll();


const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        Inertia.visit(route('options.index'));
    }
};
</script>
