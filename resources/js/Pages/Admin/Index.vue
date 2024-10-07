<template>
    <Head title="Liste des Profils | Admin" />
    <Layout>
        <h1>Liste des Profils</h1>
        
        <table>
            <thead class="border-x border-[#EA580C]">
                <tr>
                    <th class="py-2">Photo</th>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Email</th>
                    <th style="width: 1%;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="border-x border-[#EA580C]">
                <tr v-for="user in users.data" :key="user.id">
                    <td class="px-4 py-1 border-b border-[#EA580C] table-cell text-center w-[100px]">
                        <img :src="`/storage/profiles/${user.picture}`" alt="Photo de profil" class="rounded-full h-8 w-8 mx-auto">
                    </td>
                    <td class="border-b border-[#EA580C] max-w-[150px]" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar select-text">
                            {{ user.name }}
                        </div>
                    </td>

                    <td class="border-b max-w-[150px] border-[#EA580C]" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar select-text">
                            {{ user.email }}
                        </div>
                    </td>

                    <td class="px-2 py-2 border-b text-center border-[#EA580C] w-[80px]" draggable="false">
                        <div class="flex justify-center">
                            <button 
                                @click="goTo(`/user/${user.id}`)" 
                                class="btn -m-1 text-sm rounded-xs" style="padding: 6px 18px;">
                                Détails
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-1 flex justify-between">
            <button
                class="py-2 disabled:opacity-50 btn"
                :disabled="!users.prev_page_url"
                @click="goTo(users.prev_page_url)"
            >
                Précédent
            </button>
            <button
                class="py-2 disabled:opacity-50 btn"
                :disabled="!users.next_page_url"
                @click="goTo(users.next_page_url)"
            >
                Suivant
            </button>
        </div>

        <h2 class="text-xl font-bold underline mb-2 mt-8">Statistiques Moyennes</h2>
        <p class="text-lg font-semibold text-center">Réservation demandées ces 12 derniers mois</p>
        <div class="mx-auto text-left mt-2" style="max-width: fit-content;">
            <table class="mx-auto">
                <thead class="border-x border-[#EA580C] text-center">
                    <tr>
                        <th class="py-2 md:min-w-[150px]">PanierTT/res</th>
                        <th class="md:min-w-[150px]">Options/res</th>
                        <th class="md:min-w-[150px]">Jours/res</th>
                        <th class="md:min-w-[150px]">Rés/mois</th>
                    </tr>
                </thead>
                <tbody class="border-x border-[#EA580C]">
                    <tr>
                        <td class="px-4 py-1 border-b border-[#EA580C] text-center">{{ averageTtcBasket }}</td>
                        <td class="px-4 py-1 border-b border-[#EA580C] text-center">{{ averageOptionBasket }}</td>
                        <td class="px-4 py-1 border-b border-[#EA580C] text-center">{{ averageDaysReserved }}</td>
                        <td class="px-4 py-1 border-b border-[#EA580C] text-center">{{ averageReservationsPerMonth }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-xs font-light text-gray-800" title="Pour une meilleure représentation des activités du site">
                Ce qui est pris en compte sont les dates où l'utilisateur a demandé une réservation<span class="flex md:hidden"></span> - pas les réservations passées.
            </p>
        </div>
    </Layout>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import Layout from '../Layout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    users: Object,
    averageTtcBasket: [Number, String],
    averageOptionBasket: [Number, String],
    averageDaysReserved: [Number, String],
    averageReservationsPerMonth: [Number, String],
});

const goTo = (url) => {
    Inertia.get(url);
};
</script>
