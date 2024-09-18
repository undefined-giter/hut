<template>
    <Head title="Liste Profils | Admin" />
    <Layout>
        <h1>Liste des profils</h1>
        
        <table class="w-3xl border border-gray-200">
            <thead class="select-none">
                <tr>
                    <th class="px-4 py-2 border">Photo</th>
                    <th class="px-4 py-2 border">Nom</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border text-center" style="width: 1%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="user in users.data" :key="user.id">                    
                    <td class="flex justify-center items-center h-full">
                        <img :src="`/storage/profiles/${user.picture}`" alt="Photo de profil" class="rounded-full h-8 w-8">
                    </td>
                    <td class="px-4 py-2 border" draggable="false">
                        <div class="w-[250px] overflow-x-auto whitespace-nowrap custom-scrollbar">
                            {{ user.name }}
                        </div>
                    </td>

                    <td class="px-4 py-2 border" draggable="false">
                        <div class="w-[250px] overflow-x-auto whitespace-nowrap custom-scrollbar">
                            {{ user.email }}
                        </div>
                    </td>
                    
                    <td class="px-2 py-2 border text-center" draggable="false">
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

        <div class="mt-6 flex justify-between">
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
