<template>
    <Head :title="`Détails de ${user.name} | Admin`" />
    <Layout>
        <h1 style="overflow-wrap: break-word;">À propos de {{ user.name }}</h1>

        <Reservations :reservations="reservations" :connected_user_id="connected_user_id" />

        <div class="bg-light dark:bg-dark shadow-lg rounded-lg p-8 mx-auto hover:scale-105 transform transition-transform duration-300">            
            <h2>Profil</h2>
            <div class="max-w-2xl mx-auto p-8 pt-0">
                <img :src="`${baseUrl}/profiles/${user.picture}`" loading="lazy" alt="Photo de profil" class="mx-auto rounded-full w-[280px] h-[180px]">

                <div class="flex justify-center">
                    <div class="my-2 pl-20 mx-auto">
                        <div class="mb-4 flex">
                            <p class="break-words w-full max-w-[28ch] flex">
                                <strong class="font-semibold !text-gray-700 w-32">Nom :</strong>
                                <span class="!select-text">{{ user.name }}</span>
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="break-words w-full max-w-[28ch] flex">
                                <strong class="font-semibold !text-gray-700 w-32">Second :</strong> 
                                <span v-if="user.phone" class="!select-text">
                                    {{ user.name2 ? user.name2 : 'non renseigné' }}
                                </span>
                                <span v-else class="!select-none">
                                    Non renseigné
                                </span>
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="break-words w-full max-w-[28ch] flex">
                                <strong class="font-semibold !text-gray-700 w-32">Téléphone :</strong>
                                <span v-if="user.phone" class="!select-text">
                                    {{ user.phone.replace(/(\d{2})(?=\d)/g, '$1 ') }}
                                </span>
                                <span v-else class="!select-none">
                                    Non renseigné
                                </span>
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="break-words w-full max-w-[28ch] flex">
                                <strong class="font-semibold !text-gray-700 w-32">Email :</strong>
                                <span class="!select-text">{{ user.email }}</span>
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="flex">
                                <strong class="font-semibold !text-gray-700 w-32">Dernière co :</strong>
                                {{ new Date(user.last_login).toLocaleDateString('fr-FR', { 
                                    day: '2-digit', 
                                    month: '2-digit', 
                                    year: 'numeric'
                                }) }} à {{ new Date(user.last_login).toLocaleTimeString('fr-FR', {
                                    hour: '2-digit', 
                                    minute: '2-digit',
                                    second: undefined
                                }) }}
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="flex">
                                <strong class="font-semibold !text-gray-700 w-32">Mise à jour :</strong>
                                {{ new Date(user.updated_at).toLocaleDateString() }}
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="flex">
                                <strong class="font-semibold !text-gray-700 w-32">Inscription :</strong> 
                                {{ new Date(user.created_at).toLocaleDateString() }}
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="flex">
                                <strong class="font-semibold !text-gray-700 w-32">Role :</strong> 
                                {{ user.role }}
                            </p>
                        </div>
                        <div class="mb-4 flex">
                            <p class="flex">
                                <strong class="font-semibold !text-gray-700 w-32">ID :</strong>
                                {{ user.id }}
                            </p>
                        </div>
                    </div>
                </div>
            
                <div class="flex justify-end">
                    <button @click="deleteUser" class="btn !bg-red-700 text-white mr-4">
                        Supprimer
                    </button>
                    <button type="button" @click="goBack();" class="btn mr-4 py-2">
                        Retour
                    </button>
                </div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Reservations from './../Components/Reservations.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head, usePage } from '@inertiajs/vue3';
import Layout from '../Layout.vue';

const { baseUrl } = usePage().props;

const props = defineProps({
  user: Object,
  reservations: Array,
  connected_user_id: Number,
});

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        Inertia.visit('/list');
    }
};

const deleteUser = () => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
    Inertia.delete(route('user.delete', props.user.id));
  }
};
</script>