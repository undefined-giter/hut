<template>
    <transition name="fade-slide">
        <div class="max-h-[350px] overflow-y-auto px-2">
            <table v-if="specialDatesPricesArray.length" border="1" class="border-collapse">
                <thead>
                    <tr>
                        <th class="text-left pl-2">Date <span class="text-xs">d'entrée</span></th>
                        <th class="text-right pr-2">Prix</th>
                    </tr>
                </thead>

                <tbody>
                    <tr v-for="item in specialDatesPricesArray" :key="item.id">
                        <td class="text-left px-2" v-html="
                            capitalizeFirstLetter(
                                format(new Date(item.spe_date), 'eeee d MMMM', { locale: fr })
                            ) + ' <span class=\'text-xs\'> - ' + format(new Date(item.spe_date), 'dd/MM/yy') + '</span>'
                        "></td>
                        <td class="text-right px-2">
                            {{ parseFloat(item.spe_price) % 1 === 0 ? parseFloat(item.spe_price).toFixed(0) : parseFloat(item.spe_price).toFixed(2) }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else>Aucune date/price spéciale.</p>
        </div>
    </transition>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { format } from 'date-fns';
import { fr } from 'date-fns/locale';

const specialDatesPricesArray = ref([]);

const fetchSpecialDatesPrices = async () => {
    const response = await axios.get(`/specials-dates-prices`);
    
    specialDatesPricesArray.value = response.data.specialDatesPricesArray.map(item => ({
        ...item,
        formattedDate: format(new Date(item.spe_date), 'eeee d MMMM yyyy', { locale: fr }),
        editedPrice: item.spe_price,
        isEditing: false
    }));
};

const capitalizeFirstLetter = (string) => {
    return string.charAt(0).toUpperCase() + string.slice(1);
};

onMounted(fetchSpecialDatesPrices);
</script>