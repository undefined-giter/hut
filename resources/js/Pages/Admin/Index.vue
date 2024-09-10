<template>
    <Layout>
        <div class="bg-white shadow sm:rounded-lg p-6">
            <h1 class="text-2xl font-semibold mb-6">Liste des utilisateurs</h1>
            
            <table class="w-auto bg-white border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border">ID</th>
                        <th class="px-4 py-2 border">Nom</th>
                        <th class="px-4 py-2 border">Email</th>
                        <th class="px-4 py-2 border text-center" style="width: 1%;">Actions</th> <!-- Colonne ajustée -->
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ user.id }}</td>
                        <td class="px-4 py-2 border">{{ user.name }}</td>
                        <td class="px-4 py-2 border">{{ user.email }}</td>
                        <td class="px-2 py-2 border text-center">
                            <div class="flex justify-center">
                                <button 
                                    @click="goTo(`/user/${user.id}`)" 
                                    class="px-2 py-1 bg-blue-500 text-white rounded text-sm">
                                    Détails
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-6 flex justify-between">
                <button
                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded disabled:opacity-50"
                    :disabled="!users.prev_page_url"
                    @click="goTo(users.prev_page_url)"
                >
                    Précédent
                </button>
                <button
                    class="px-4 py-2 bg-blue-500 text-white rounded disabled:opacity-50"
                    :disabled="!users.next_page_url"
                    @click="goTo(users.next_page_url)"
                >
                    Suivant
                </button>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import Layout from '../Layout.vue';

defineProps({
    users: Object
});

const goTo = (url) => {
    Inertia.get(url);
};
</script>
