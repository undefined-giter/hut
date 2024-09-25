<template>
    <Head :title="`Détails de ${user.name} | Admin`" />
    <Layout>
        <h1 style="overflow-wrap: break-word;">À propos de {{ user.name }}</h1>

        <Reservations :reservations="reservations" />

        <div class="bg-[#131516] shadow-lg rounded-lg p-8 mx-auto">            
            <h2>Profile</h2>
            <div class="max-w-2xl mx-auto p-8 pt-0">
                <img :src="`/storage/profiles/${user.picture}`" alt="Photo de profil" class="mx-auto rounded-full w-[280px] h-[180px]">
                <div class="mt-2">
                    <div class="ml-48">
                        <div class="mb-4">
                            <p class="text-gray-700 break-words w-full max-w-[28ch]"><strong class="font-semibold">Nom : </strong><span class="!select-text">{{ user.name }}</span></p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-700 break-words w-full max-w-[28ch]"><strong class="font-semibold">Second : </strong> 
                                <span v-if="user.phone" class="!select-text">
                                    {{ user.name2 ? user.name2 : 'non renseigné' }}
                                </span>
                                <span v-else class="!select-none">
                                    Non renseigné
                                </span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-700 break-words w-full max-w-[28ch]">
                                <strong class="font-semibold">Téléphone : </strong>
                                <span v-if="user.phone" class="!select-text">
                                    {{ user.phone.replace(/(\d{2})(?=\d)/g, '$1 ') }}
                                </span>
                                <span v-else class="!select-none">
                                    Non renseigné
                                </span>
                            </p>
                        </div>
                        <div class="mb-4">
                            <p class="text-gray-700 break-words w-full max-w-[28ch]">
                                <strong class="font-semibold">Email :</strong> <span class="!select-text">{{ user.email }}</span>
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
                    </div>
                
                    <div class="flex justify-end">
                        <button @click="deleteUser" class="btn !bg-red-700 text-white mr-4">
                            Supprimer
                        </button>
                        <button @click="window.history.back();" class="btn mr-4 py-2">
                            Retour
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../Layout.vue';
import Reservations from './../Components/Reservations.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';

const props = defineProps({
  user: Object,
  reservations: Array,
});

const deleteUser = () => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
    Inertia.delete(route('user.delete', props.user.id));
  }
};
</script>