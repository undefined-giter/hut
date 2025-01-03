<template>
    <Head title="Liste des Profils | Admin" />
    <Layout>
        <h1>Liste des Profils</h1>
        
        <table>
            <thead class="border-x border-orangeTheme">
                <tr>
                    <th class="hidden sm:table-cell py-2">Photo</th>
                    <th class="text-left">Nom</th>
                    <th class="text-left">Email</th>
                    <th style="width: 1%;" class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="border-x border-orangeTheme">
                <tr v-for="user in users.data" :key="user.id">
                    <td class="hidden sm:table-cell px-4 py-1 border-b border-orangeTheme table-cell text-center w-[100px]">
                        <img 
                            :src="
                            user.picture ? 
                            user.picture.startsWith('https') ?
                            user.picture 
                            :
                            `${baseUrl}/profiles/` + user.picture 
                            : `${baseUrl}/profiles/default_user.png`"
                            loading="lazy" alt="Profil" class="rounded-full h-8 w-8 mx-auto">
                    </td>
                    <td class="border-b border-orangeTheme max-w-[90px]" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar select-text">
                            {{ user.name ? user.name : 'Non renseigné' }}
                        </div>
                    </td>

                    <td class="border-b max-w-[130px] border-orangeTheme" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar select-text">
                            {{ user.email }}
                        </div>
                    </td>

                    <td class="px-2 py-2 border-b text-center border-orangeTheme w-[80px]" draggable="false">
                        <div class="flex justify-center">
                            <button 
                                @click="goTo(route('admin.details', { id: user.id }))" 
                                class="btn -m-1 text-sm" style="padding: 6px 18px; border-radius: 0.3em;">
                                Détails
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div v-if="users.total > paginateLength" class="flex justify-between">
            <button
                class="py-2 btn rounded-t-none"
                :class="{'btn-disabled': !users.prev_page_url}"
                :disabled="!users.prev_page_url"
                @click="goTo(users.prev_page_url)"
            >
                Précédent
            </button>
            <button
                class="py-2 btn rounded-t-none"
                :class="{'btn-disabled': !users.next_page_url}"
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
                <thead class="border-x border-orangeTheme text-center">
                    <tr>
                        <th class="py-2 md:min-w-[150px]">PanierTT/res</th>
                        <th class="md:min-w-[150px]">Options/res</th>
                        <th class="md:min-w-[150px]">Jours/res</th>
                        <th class="md:min-w-[150px]">Rés/mois</th>
                    </tr>
                </thead>
                <tbody class="border-x border-orangeTheme">
                    <tr>
                        <td class="px-4 py-1 border-b border-orangeTheme text-center">{{ averageTtcBasket }}</td>
                        <td class="px-4 py-1 border-b border-orangeTheme text-center">{{ averageOptionBasket }}</td>
                        <td class="px-4 py-1 border-b border-orangeTheme text-center">{{ averageDaysReserved }}</td>
                        <td class="px-4 py-1 border-b border-orangeTheme text-center">{{ averageReservationsPerMonth }}</td>
                    </tr>
                </tbody>
            </table>
            <p class="text-xs font-light text-gray-800" title="Pour une meilleure représentation des activités du site">
                Les dates de création de réservation sont prises en compte.
            </p>
        </div>
    </Layout>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import Layout from '../Layout.vue';
import { Head, usePage } from '@inertiajs/vue3';

const { baseUrl } = usePage().props;

defineProps({
    users: Object,
    averageTtcBasket: [Number, String],
    averageOptionBasket: [Number, String],
    averageDaysReserved: [Number, String],
    averageReservationsPerMonth: [Number, String],
    paginateLength: [Number, String],
});

const goTo = (url) => {
    Inertia.get(url);
};
</script>
