<template>
    <Head :title="`Détails ${user.name} | Admin`" />
    <Layout>
        <div class="bg-white shadow-lg rounded-lg p-8 max-w-2xl mx-auto">
            <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-4 text-center">Détails de l'utilisateur</h1>
            
            <div class="mb-4">
                <p class="text-gray-700 break-words w-full max-w-[70ch]"><strong class="font-semibold">Nom :</strong> {{ user.name }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 break-words w-full max-w-[70ch]">
                    <strong class="font-semibold">Téléphone :</strong>
                    {{ user.phone ? user.phone.replace(/(\d{2})(?=\d)/g, '$1 ') : 'Non renseigné' }}
                </p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700 break-words w-full max-w-[70ch]">
                    <strong class="font-semibold">Email :</strong> {{ user.email }}
                </p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700"><strong class="font-semibold">Date d'inscription :</strong> {{ new Date(user.created_at).toLocaleDateString() }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700"><strong class="font-semibold">Date de mise à jour :</strong> {{ new Date(user.updated_at).toLocaleDateString() }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700"><strong class="font-semibold">Role :</strong> {{ user.role }}</p>
            </div>
            <div class="mb-4">
                <p class="text-gray-700"><strong class="font-semibold">ID :</strong> {{ user.id }}</p>
            </div>

            <div class="flex justify-end">
                <button @click="goBack" class="btn mr-4 py-2">
                    Retour
                </button>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../Layout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';

defineProps({
    user: Object,
});

const goBack = () => {
    Inertia.get('/list');
};
</script>
