<template>
    <Head title="Liste des Options | Admin" />
    <Layout>
        <h1>Liste des Options</h1>

        <div class="flex justify-between mb-4">
            <Link :href="route('admin.prices')" class="btn !bg-blue-700 text-white -mb-3 rounded-lg shadow">
                Modifier Prix Réservation
            </Link>
            <Link :href="route('admin.options.create')" class="btn !bg-blue-700 text-white -mb-3 rounded-lg shadow">
                Ajouter une Option
            </Link>
        </div>

        <table class="mx-auto w-full border border-[#EA580C] rounded-lg">
            <thead class="border-x border-[#EA580C]">
                <tr>
                    <th class="text-left pl-2 py-1">Nom</th>
                    <th class="text-left">Description</th>
                    <th class="text-center">€</th>
                    <th class="text-center">Dispo</th>
                    <th class="text-center">Présélect</th>
                    <th class="text-center">/jour</th>
                    <th class="text-center">Présél/j</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="border-x border-[#EA580C]">
                <tr v-for="option in options" :key="option.id" class="hover:bg-[#333333] !important transition h-[3.5rem]">
                    <td class="border-b border-[#EA580C] px-2 max-w-[250px] overflow-hidden">
                        <div class="custom-scrollbar overflow-y-auto overflow-x-hidden text-ellipsis">
                            <span class="line-clamp-2 whitespace-pre-wrap">
                                {{ option.name }}
                            </span>
                        </div>
                    </td>
                    <td class="border-b border-[#EA580C] max-w-[250px] overflow-hidden">
                        <div class="custom-scrollbar overflow-y-auto overflow-x-hidden text-ellipsis">
                            <span class="line-clamp-2 whitespace-pre-wrap">
                                {{ option.description || 'Aucune description' }}
                            </span>
                        </div>
                    </td>
                    <td class="border-b border-[#EA580C] max-w-[100px] text-center">
                        {{ option.price !== null ? option.price == 0.00 ? 'offert' : Number(option.price).toFixed(2) : 'Vide' }}
                    </td>
                    <td class="border-b border-[#EA580C] text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="option.available" class="sr-only peer" 
                                   @change="toggleAvailability(option.id, option.available)" />
                            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                        </label>
                    </td>
                    <td class="border-b border-[#EA580C] text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="option.preselected" class="sr-only peer" 
                                   @change="togglePreselected(option.id, option.preselected)" />
                            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-700"></div>
                        </label>
                    </td>
                    <td class="border-b border-[#EA580C] text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="option.by_day" class="sr-only peer" 
                                   @change="toggleByDay(option.id, option.by_day)" />
                            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-700"></div>
                        </label>
                    </td>
                    <td class="border-b border-[#EA580C] text-center">
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" :checked="option.by_day_preselected" class="sr-only peer" 
                                   @change="toggleByDayPreselected(option.id, option.by_day_preselected)" />
                            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-700"></div>
                        </label>
                    </td>
                    <td class="border-b text-center border-[#EA580C] w-[200px]">
                        <div class="flex justify-center space-x-1.5">
                            <button @click="goTo(route('admin.options.edit', option.id))"
                                class="btn text-sm bg-blue-700 text-white px-2 rounded shadow">
                                Modifier
                            </button>
                            <button @click="deleteOption(option.id)" 
                                class="btn text-sm !bg-red-700 text-white px-2 rounded shadow hover:text-orange-300">
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
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    options: Array
});

const toggleAvailability = (id, currentState) => {
    Inertia.put(route('admin.options.toggle-availability', id), { available: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Disponibilité mise à jour');
        }
    });
};

const togglePreselected = (id, currentState) => {
    Inertia.put(route('admin.options.toggle-preselected', id), { preselected: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Statut de présélection mis à jour');
        }
    });
};

const toggleByDay = (id, currentState) => {
    Inertia.put(route('admin.options.toggle-by-day', id), { by_day: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Statut "Par jour" mis à jour');
        }
    });
};

const toggleByDayPreselected = (id, currentState) => {
    Inertia.put(route('admin.options.toggle-by-day-preselected', id), { by_day_preselected: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Statut "Présélection par jour" mis à jour');
        }
    });
};

const goTo = (url) => {
    Inertia.get(url);
};

const deleteOption = (id) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette option ?')) {
        Inertia.delete(route('admin.options.destroy', id), {
            onSuccess: () => {
                alert('Option supprimée.');
            }
        });
    }
};
</script>
