<template>
    <Head title="Liste des Options | Admin" />
    <Layout>
        <h1>Liste des Options</h1>

        <table>
            <thead class="border-x border-[#EA580C]">
                <tr>
                    <th class="py-2">Nom</th>
                    <th class="text-left">Description</th>
                    <th class="text-left">Prix (€)</th>
                    <th class="text-left">Disponible</th>
                    <th class="text-left">Présélectionnée</th>
                    <th style="width: 1%;">Actions</th>
                </tr>
            </thead>
            <tbody class="border-x border-[#EA580C]">
                <tr v-for="option in options" :key="option.id">
                    <td class="px-4 py-1 border-b border-[#EA580C] table-cell">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar">
                            {{ option.name }}
                        </div>
                    </td>
                    <td class="border-b border-[#EA580C] max-w-[250px]" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar">
                            {{ option.description || 'Aucune description' }}
                        </div>
                    </td>
                    <td class="border-b max-w-[100px] border-[#EA580C]" draggable="false">
                        <div class="overflow-x-auto whitespace-nowrap custom-scrollbar">
                            {{ option.price !== null ? Number(option.price).toFixed(2) : 'Gratuit' }}
                        </div>
                    </td>
                    <td class="border-b border-[#EA580C] max-w-[100px]" draggable="false">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="option.available" class="sr-only peer" 
                                   @change="toggleAvailability(option.id, option.available)" />
                            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </td>
                    <td class="border-b border-[#EA580C] max-w-[100px]" draggable="false">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="option.preselected" class="sr-only peer" 
                                   @change="togglePreselected(option.id, option.preselected)" />
                            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-700"></div>
                        </label>
                    </td>
                    <td class="px-2 py-2 border-b text-center border-[#EA580C] w-[80px]" draggable="false">
                        <div class="flex justify-center">
                            <button 
                                @click="goTo(`/admin/options/${option.id}/edit`)" 
                                class="btn -m-1 text-sm rounded-xs" style="padding: 6px 18px;">
                                Modifier
                            </button>
                            <button 
                                @click="deleteOption(option.id)" 
                                class="btn -m-1 text-sm rounded-xs !bg-red-700 text-white ml-2" style="padding: 6px 18px;">
                                Supprimer
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </Layout>
</template>

<script setup>
import { Inertia } from '@inertiajs/inertia';
import Layout from '../Layout.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    options: Array
});

const toggleAvailability = (id, currentState) => {
    Inertia.put(`/admin/options/${id}/toggle-availability`, { available: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Disponibilité mise à jour avec succès.');
        }
    });
};

const togglePreselected = (id, currentState) => {
    Inertia.put(`/admin/options/${id}/toggle-preselected`, { preselected: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Statut de présélection mis à jour avec succès.');
        }
    });
};

const goTo = (url) => {
    Inertia.get(url);
};

const deleteOption = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette option ?')) {
        Inertia.delete(`/admin/options/${id}`, {
            onSuccess: () => {
                alert('Option supprimée avec succès.');
            }
        });
    }
};
</script>
