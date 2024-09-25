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
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar">
                            {{ user.name }}
                        </div>
                    </td>

                    <td class="border-b max-w-[150px] border-[#EA580C]" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar">
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
    </Layout>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import Layout from '../Layout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    users: Object
});

const goTo = (url) => {
    Inertia.get(url);
};
</script>
