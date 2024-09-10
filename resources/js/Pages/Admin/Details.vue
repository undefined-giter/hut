<template>
    <Layout>
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-6">Détails de l'utilisateur</h1>

            <div class="mb-4">
                <strong>ID :</strong> {{ user.id }}
            </div>
            <div class="mb-4">
                <strong>Nom :</strong> {{ user.name }}
            </div>
            <div class="mb-4">
                <strong>Email :</strong> {{ user.email }}
            </div>
            <div class="mb-4">
                <strong>Date d'inscription :</strong> {{ new Date(user.created_at).toLocaleDateString() }}
            </div>
            <div class="mb-4">
                <strong>Date de mise à jour :</strong> {{ new Date(user.updated_at).toLocaleDateString() }}
            </div>
            <div class="mb-4">
                <strong>Role :</strong> {{ user.role }}
            </div>

            <button @click="goBack" class="px-4 py-2 bg-gray-500 text-white rounded">
                Retour
            </button>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../Layout.vue';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    user: Object,
});

const goBack = () => {
    Inertia.get('/list');
};
</script>
