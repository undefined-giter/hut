<template>
    <Head :title="option ? 'Modifier Option' : 'Créer Option'" />
    <Layout>
        <div class="max-w-2xl mx-auto mt-8 bg-light dark:bg-dark p-6 rounded-lg shadow-lg">
            <h1 class="text-xl font-bold text-blue-500 dark:text-blue-200 text-center mb-6">
                {{ option ? 'Modifier l\'Option' : 'Créer une Nouvelle Option' }}
            </h1>

            <form @submit.prevent="submitForm" class="space-y-6 max-w-sm mx-auto mt-8">
                
                <div class="mb-4">
                    <label for="name" class="block text-blue-500 dark:text-blue-200 font-mirza mb-2">Nom<span class="text-xs text-red-700">*</span></label>
                    <input v-model="form.name" type="text" id="name" class="input w-full p-2 border border-orange-500 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-dark dark:text-white" required />
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-blue-500 dark:text-blue-200 font-mirza mb-2">Description<span class="text-xs text-red-700">*</span></label>
                    <textarea v-model="form.description" id="description" rows="4" class="input w-full p-2 border border-orange-500 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-dark dark:text-white"></textarea>
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-blue-500 dark:text-blue-200 font-mirza mb-2">Prix (€)</label>
                    <input v-model="form.price" type="number" step="0.01" id="price" class="input w-full p-2 border border-orange-500 rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-300 dark:bg-dark dark:text-white" />
                    <p class="text-xs text-blue-600 dark:text-blue-200 mt-1">
                        Insérer "0" (zéro) pour afficher "Offert" aux utilisateurs sur la page de réservation.<br>
                        Laisser vide pour ne rien afficher.<br>
                        Format "12.34". Les réductions (prix négatifs) sont permis.
                    </p>
                </div>

                <div class="flex items-center mb-4">
                    <input v-model="form.available" type="checkbox" id="available" class="form-checkbox h-4 w-4 text-blue-600 border-orange-500 rounded focus:ring focus:ring-blue-300 dark:bg-dark dark:text-white" />
                    <label for="available" class="ml-2 text-blue-500 dark:text-blue-200 font-mirza">Disponible</label>
                </div>

                <div class="flex items-center mb-4">
                    <input v-model="form.preselected" type="checkbox" id="preselected" class="form-checkbox h-4 w-4 text-blue-600 border-orange-500 rounded focus:ring focus:ring-blue-300 dark:bg-dark dark:text-white" />
                    <label for="preselected" class="ml-2 text-blue-500 dark:text-blue-200 font-mirza">Présélectionnée</label>
                </div>

                <div class="flex justify-between">
                    <button @click="window.history.back();" class="btn bg-gray-500 hover:bg-gray-600 text-white font-bold px-6 py-2 rounded-lg shadow focus:outline-none focus:ring focus:ring-gray-300">
                            Retour
                        </button>

                    <button type="submit" class="btn bg-blue-700 hover:bg-blue-600 text-white font-bold px-6 py-2 rounded-lg shadow focus:outline-none focus:ring focus:ring-blue-300">
                        {{ option ? 'Modifier' : 'Ajouter' }} l'Option
                    </button>
                </div>
            </form>
        </div>
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
    available: props.option ? Boolean(props.option.available) : false,
    preselected: props.option ? Boolean(props.option.preselected) : false
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
onMounted(() => {
    window.addEventListener('keydown', handleKeyDown);
});
onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleKeyDown);
});
</script>
