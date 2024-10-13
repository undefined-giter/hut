<template>
    <Head title="Liste des Options | Admin" />
    <Layout>
        <h1>Liste des Options</h1>

        <div class="flex justify-between mb-4">
            <Link :href="route('admin.prices')" class="btn !bg-blue-700 text-white -mb-3 mr-1 rounded-lg shadow">
                Modifier Prix Réservation
            </Link>
            <Link :href="route('admin.options.create')" class="btn !bg-blue-700 text-white -mb-3 rounded-lg shadow">
                Ajouter une Option
            </Link>
        </div>

        <div class="overflow-x-auto">
            <table class="table-auto mx-auto w-full border border-orangeTheme rounded-lg">
                <thead class="border-x border-orangeTheme">
                    <tr>
                        <th class="text-left pl-2 py-1" title="Nom de l'option">Nom</th>
                        <th class="hidden sm:table-cell text-left" title="Description de l'option">Description</th>
                        <th class="hidden sm:table-cell text-center" title="Si vide = rien de n'affiche; Si 0.00 = 'Inclu' s'affichera dans l'option;">€</th>
                        <th class="hidden xs:table-cell text-center" title="Décocher pour ne plus rendre l'option disponible, sans la supprimée pour autant.">Dispo</th>
                        <th class="hidden xs:table-cell text-center" title="Présélectionner l'option par défault">Présélect</th>
                        <th class="hidden xs:table-cell text-center" title="Afficher l'option Par jour ?">Voir/jr</th>
                        <th class="hidden xs:table-cell text-center" title="NE PAS SELECTIONNER si la colone précédente 'Voir/jr' n'est pas séléctionnée, à moins de vouloir imposer la récurence du prix par jour réserver.
    Prix payé par jour, ou pour le séjour entier ? Séléctionné : option 1 fois par jour, Déséléctionné : 1 fois pour le séjour entier. 
    Exemple si '/jour' est séléctionné : 2 nuits = 2 x le prix de l'option à régler.
    Si l'utilisateur sélectionne l'option, le réglage par défault est qu'elle sera prise tous les jours de la réservation
    -> Peut être déselectionné par l'utilisateur lors de sa réservation.">Présél/jr</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="border-x border-orangeTheme">
                    <tr v-for="option in options" :key="option.id" class="hover:bg-[#333333] !important transition h-[3.5rem]">
                        <td class="border-b border-orangeTheme px-2 max-w-[250px] overflow-hidden">
                            <div class="custom-scrollbar overflow-y-auto overflow-x-hidden text-ellipsis">
                                <span class="line-clamp-2 whitespace-pre-wrap">
                                    {{ option.name }}
                                </span>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell border-b border-orangeTheme max-w-[250px] overflow-hidden">
                            <div class="custom-scrollbar overflow-y-auto overflow-x-hidden text-ellipsis">
                                <span class="line-clamp-2 whitespace-pre-wrap">
                                    {{ option.description || 'Aucune description' }}
                                </span>
                            </div>
                        </td>
                        <td class="hidden sm:table-cell border-b border-orangeTheme max-w-[100px] text-center">
                            {{ option.price !== null ? option.price == 0.00 ? 'Inclu' : Number(option.price).toFixed(2) : 'Vide' }}
                        </td>
                        <td class="hidden xs:table-cell border-b border-orangeTheme text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="option.available" class="sr-only peer" 
                                    @change="toggleAvailability(option.id, option.available)" />
                                <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                            </label>
                        </td>
                        <td class="hidden xs:table-cell border-b border-orangeTheme text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="option.preselected" class="sr-only peer" 
                                    @change="togglePreselected(option.id, option.preselected)" />
                                <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-700"></div>
                            </label>
                        </td>
                        <td class="hidden xs:table-cell border-b border-orangeTheme text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="option.by_day_display" class="sr-only peer" 
                                    @change="toggleByDayDisplay(option.id, option.by_day_display)" />
                                <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-orange-700"></div>
                            </label>
                        </td>
                        <td class="hidden xs:table-cell border-b border-orangeTheme text-center">
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" :checked="option.by_day_preselected" class="sr-only peer" 
                                    @change="toggleByDayPreselected(option.id, option.by_day_preselected)" />
                                <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-purple-800"></div>
                            </label>
                        </td>
                        <td class="border-b text-center border-orangeTheme w-[200px]">
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
        </div>
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

const toggleByDayDisplay = (id, currentState) => {
    Inertia.put(route('admin.options.toggle-by-day-display', id), { by_day_display: !currentState }, {
        preserveScroll: true,
        onSuccess: () => {
            alert('Statut de l\'affichage "Par jour" mis à jour');
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
