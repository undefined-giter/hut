<template>
    <Head :title="`Détails de ${user.name} | Admin`" />
    <Layout>
        <h1 style="overflow-wrap: break-word;">À propos de {{ user.name }}</h1>

        <Reservations :reservations="reservations" :connected_user_id="connected_user_id" />

        <div class="bg-light dark:bg-dark shadow-lg rounded-lg p-8 mx-auto hover:scale-105 transform transition-transform duration-300">            
            <h2 class="text-center">Profil</h2>
            <div class="max-w-[384px] mx-auto pt-0">
                <img :src="`${baseUrl}/profiles/${user.picture}`" loading="lazy" alt="Photo de profil" class="mx-auto rounded-full w-[280px] h-[180px]">

                <div class="flex flex-col mt-4 dark:text-white font-semibold">
                    <div class="my-2">
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Nom :</strong>
                            {{ user.name === 'Profil' ? 'Non renseigné' : '' }}
                            <span v-if="user.name !== 'Profil'" class="text-[1.2em] !select-text text-green-400">{{ user.name }}</span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Second :</strong>
                            {{ !user.phone ? 'Non renseigné' : '' }}
                            <span v-if="user.name2 && user.name2 !== ''" class="!select-text text-[1.1em] text-green-400">
                                {{ user.name2 }}
                            </span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Téléphone :</strong>
                            {{ !user.phone ? 'Non renseigné' : '' }}
                            <span v-if="user.phone && user.phone !== 'Profil'" class="!select-text text-[1.2em] text-green-400">
                                {{ user.phone.replace(/(\d{2})(?=\d)/g, '$1 ') }}
                            </span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Email :</strong>
                            <span class="!select-text text-[1.2em] text-green-400">{{ user.email }}</span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Dernière co :</strong>
                            <span>{{ new Date(user.last_login).toLocaleDateString('fr-FR', { day: '2-digit', month: '2-digit', year: 'numeric' }) }} à {{ new Date(user.last_login).toLocaleTimeString('fr-FR', { hour: '2-digit', minute: '2-digit', second: undefined }) }}</span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Mise à jour :</strong>
                            <span>{{ new Date(user.updated_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Inscription :</strong>
                            <span>{{ new Date(user.created_at).toLocaleDateString() }}</span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">Role :</strong>
                            <span>{{ user.role }}</span>
                        </div>
                        <div class="mb-4 flex justify-between">
                            <strong class="font-semibold !text-gray-700">ID :</strong>
                            <span>{{ user.id }}</span>
                        </div>
                    </div>
                </div>
            
                <div class="flex justify-end mt-4">
                    <button @click="deleteUser" class="btn !bg-red-700 mr-4">
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