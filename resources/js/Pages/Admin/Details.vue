<template>
    <Head :title="`Détails de ${user.name} | Admin`" />
    <Layout>
        <div class="bg-[#181a1b] shadow-lg rounded-lg p-8 max-w-2xl mx-auto">
            <h1>À propos de {{ user.name }}</h1>
            
            <h2>Profile</h2>
            <img :src="`/storage/profiles/${user.picture}`" alt="Photo de profil" class="mx-auto rounded-full w-[280px] h-[180px]">
            <div class="mt-2">
                <div class="ml-48">
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
                </div>
            
                <div class="flex justify-end">
                    <button @click="deleteUser" class="btn !bg-red-500 text-white mr-4">
                        Supprimer
                    </button>
                    <button @click="goBack" class="btn mr-4 py-2">
                        Retour
                    </button>
                </div>
            </div>
        </div>

        <div v-if="reservations.length > 0" class="bg-[#181a1b] shadow-lg rounded-lg p-8 max-w-2xl mx-auto mt-4">
            <h2>Réservations</h2>

            <div style="max-height: 350px; overflow-y: auto;">

                <h3 class="text-center" v-if="currentReservations.length > 0">Réservation Actuelle !</h3>
                <ul v-if="currentReservations.length > 0">
                    <li v-for="reservation in currentReservations" :key="reservation.id">
                        {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : 
                        Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                        pour {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                    </li>
                </ul>

                <h3 class="text-center mt-2" v-if="upcomingReservations.length > 0">Réservations à venir</h3>
                <ul v-if="upcomingReservations.length > 0">
                    <li v-for="reservation in upcomingReservations" :key="reservation.id">
                        {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : 
                        Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                        pour {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                    </li>
                </ul>

                <h3 class="mt-2 text-center" v-if="pastReservations.length > 0">Réservations passées</h3>
                <ul v-if="pastReservations.length > 0">
                    <li v-for="reservation in pastReservations" :key="reservation.id">
                        {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : 
                        Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                        pour {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                    </li>
                </ul>

            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from '../Layout.vue';
import { Inertia } from '@inertiajs/inertia';
import { Head } from '@inertiajs/vue3';
import { defineProps } from 'vue';

const props = defineProps({
    user: Object,
    reservations: Array,
});

const goBack = () => {
    window.history.back();
};

const deleteUser = () => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
        Inertia.delete(route('user.delete', props.user.id));
    }
};

const formatDateShort = (date) => {
  return date.toLocaleDateString('fr-FR', {
    year: '2-digit',
    month: '2-digit',
    day: '2-digit',
  });
};

const formatDate = (date) => {
  return date.toLocaleDateString('fr-FR', {
    weekday: 'long',
    month: 'long',
    day: 'numeric',
  });
};

const today = new Date();

const currentReservations = props.reservations.filter((reservation) => {
  const startDate = new Date(reservation.start_date);
  const endDate = new Date(reservation.end_date);
  return startDate <= today && endDate >= today;
});

const upcomingReservations = props.reservations.filter((reservation) => {
  return new Date(reservation.start_date) > today;
});

const pastReservations = props.reservations.filter((reservation) => {
  return new Date(reservation.end_date) < today;
});
</script>
