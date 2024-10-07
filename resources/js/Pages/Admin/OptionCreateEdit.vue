<template>
    <Head :title="(option ? 'Modifier Option' : 'Créer Option') + ' | Admin'" />
    <Layout>
        <h1>{{ option ? 'Modifier l\'Option' : 'Créer une Nouvelle Option' }}</h1>

        <form @submit.prevent="submitForm" class="max-w-sm mx-auto">
            
            <div class="mb-4">
                <label for="name" class="block !-mb-0.5">Nom<span class="text-xs text-red-700">*</span></label>
                <input v-model="form.name" type="text" id="name" class="input w-full p-2" required />
            </div>

            <div class="mb-4">
                <label for="description" class="block !-mb-0.5">Description<span class="text-xs text-red-700">*</span></label>
                <textarea v-model="form.description" id="description" rows="4" class="input w-full p-2"></textarea>
            </div>

            <div class="mb-4" title='Insérer "0" (zéro) pour afficher "Inclu" aux utilisateurs sur la page de réservation.
Laisser vide pour ne rien afficher.
Format "12.34". Les réductions (prix négatifs) sont permis.'>
                <label for="price" class="block !-mb-0.5">Prix (€)</label>
                <input v-model="form.price" type="number" step="0.01" id="price" class="input w-full p-2" />
            </div>

            <div class="flex justify-between space-x-6">
                <div>
                    <div class="flex items-center mb-4">
                        <input v-model="form.available" type="checkbox" id="available" />
                        <label for="available" class="ml-2">Disponible</label>
                    </div>
    
                    <div class="flex items-center mb-4">
                        <input v-model="form.preselected" type="checkbox" id="preselected" />
                        <label for="preselected" class="ml-2">Présélectionnée</label>
                    </div>
                </div>
                <div>
                    <!-- <div class="flex items-center mb-4">
                        <input v-model="form.by_day" type="checkbox" id="by_day" />
                        <label for="by_day" class="ml-2">Par Jour</label>
                    </div> -->
    
                    <div class="flex items-center mb-4">
                        <input v-model="form.by_day_preselected" type="checkbox" id="by_day_preselected" />
                        <label for="by_day_preselected" class="ml-2">Présélectionnée Par Jour</label>
                    </div>
                </div>
            </div>

            <div class="flex justify-between">
                <button type="button" @click="goBack();" class="btn">Retour</button>

                <button type="submit" class="btn">{{ option ? 'Modifier' : 'Ajouter' }} l'Option</button>
            </div>
        </form>
    </Layout>
</template>

<script setup>
import { reactive, onMounted, onBeforeUnmount } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3'; 
import Layout from '../Layout.vue';

const props = defineProps({
    option: {
        type: Object,
        default: null
    }
});

const form = reactive({
    name: props.option ? props.option.name : '',
    description: props.option ? props.option.description : '',
    price: props.option ? props.option.price : '',
    available: props.option ? Boolean(props.option.available) : true,
    preselected: props.option ? Boolean(props.option.preselected) : false,
    by_day: props.option ? Boolean(props.option.by_day) : false,
    by_day_preselected: props.option ? Boolean(props.option.by_day_preselected) : false,
});

const submitForm = () => {
    if (props.option) {
        Inertia.put(`/options/${props.option.id}`, form);
    } else {
        Inertia.post('/options', form);
    }
};

const handleKeyDown = (event) => {
    if (event.ctrlKey && event.key === 's') {
        event.preventDefault();
        submitForm();
    }
};

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        Inertia.visit('/options');
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleKeyDown);
});
onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeyDown);
});
</script>
