<template>
    <div>
        <transition name="fade">
            <div>
                <p class="text-sm">Depuis le {{ sinceDate }}</p>
                <table v-if="specialDatesPricesArray.length" border="1" class="mx-auto text-center">
                    <thead>
                    <tr>
                        <th class="min-w-[110px]">Date</th>
                        <th class="min-w-[80px]">Prix</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="item in specialDatesPricesArray" :key="item.id">
                        <td>
                        <input
                            v-if="item.isEditing"
                            type="text"
                            v-model="item.editedDate"
                            placeholder="JJ-MM-AAAA"
                        />
                        <span v-else class="select-text">
                                {{
                                    new Date(item.spe_date)
                                    .toLocaleDateString('fr-FR')
                                    .replace(/\//g, '-')
                                }}
                            </span>
                        </td>
                        <td>
                        <input
                            v-if="item.isEditing"
                            type="number"
                            v-model="item.editedPrice"
                            placeholder="Prix"
                        />
                        <span v-else  class="select-text">{{ parseFloat(item.spe_price) % 1 === 0 ? parseFloat(item.spe_price).toFixed(0) : parseFloat(item.spe_price).toFixed(2) }}</span>
                        </td>
                        <td class="text-xs">
                            <div v-if="item.isEditing" class="flex space-x-1">
                                <button @click.stop="saveRecord(item)" type="button" class="btn">Enregistrer</button>
                                <button @click.stop="cancelEdit(item)" type="button" class="btn">Annuler</button>
                            </div>
                            <div v-else class="flex space-x-1">
                                <button @click.stop="edit(item)" type="button" class="btn">Modifier</button>
                                <button @click.stop="remove(item.id)" type="button" class="btn hidden md:block btn !bg-red-700 red-shadow hover:text-orange-500">Supprimer</button>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <p v-else class="ml-2">Aucun enregistrement à afficher.</p>
            </div>
        </transition>

        <button v-if="!showAddForm" type="button" @click.stop="showAddForm = !showAddForm" class="btn mt-4">Ajouter un enregistrement</button>
        <transition name="fade">
            <div v-if="showAddForm">
                <div class="my-2 mt-4">
                    <div class="flex justify-center mb-2">
                        <Datepicker
                            v-model:value="newRecord.date"
                            valueType="format"
                            format="DD-MM-YYYY"
                            placeholder="Sélectionner une date -> format JJ-MM-AAAA"
                            class="!w-full"
                        />
                    </div>
                    <input type="number" v-model="newRecord.price" placeholder="Prix"  />
                    <p v-if="priceError" class="text-sm !text-red-600 text-right mr-1 -mt-1">{{ priceError }}</p>
                </div>
                <div class="flex justify-between">
                    <button @click="cancelNewRecord" type="button" class="btn">Annuler</button>
                    <button @click.stop="saveRecord" type="button" class="btn">Enregistrer</button>
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import Datepicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import axios from 'axios';
import { format, parse } from 'date-fns';
import { fr } from 'date-fns/locale';

const specialDatesPricesArray = ref([]);
const sinceDate = ref('');
const showAddForm = ref(false);
const newRecord = ref({ date: '', price: '' });
const priceError = ref(false);

const edit = (item) => {
    item.isEditing = true;
};

const fetchSpecialDatesPrices = async () => {
    const sinceDays = 7;
    const response = await axios.get(`/specials-dates-prices?sincedays=${sinceDays}`);
    
    specialDatesPricesArray.value = response.data.specialDatesPricesArray.map(item => ({
        ...item,
        editedDate: format(new Date(item.spe_date), 'dd-MM-yyyy', { locale: fr }),
        editedPrice: item.spe_price,
        isEditing: false
    }));
    sinceDate.value = response.data.sinceDate;
};


const saveRecord = async (item = null) => {

    try {
        let dateToParse, price, url, method;

        if (item.id) {
            dateToParse = item.editedDate;
            price = item.editedPrice;
            url = `/specials-dates-prices/${item.id}`;
            method = 'put';
        } else {
            if (!newRecord.value.price) {
                priceError.value = 'Veuillez renseigner un prix.';
                return;
            } else {
                priceError.value = false;
            }

            dateToParse = newRecord._rawValue.date;
            price = newRecord.value.price;
            url = '/specials-dates-prices';
            method = 'post';
        }

        const parsedDate = parse(dateToParse, 'dd-MM-yyyy', new Date());
        const formattedDate = format(parsedDate, 'yyyy-MM-dd');

        await axios[method](url, {
            spe_date: formattedDate,
            spe_price: price
        });

        if (item.id) {
            item.spe_date = format(parsedDate, 'dd-MM-yyyy');
            item.spe_price = price;
            item.isEditing = false;
        } else {
            newRecord.value.date = '';
            newRecord.value.price = '';
        }

        await fetchSpecialDatesPrices();
    } catch (error) {
        //console.error("Erreur lors de la sauvegarde de l'enregistrement : ", error);
    }
};

const cancelEdit = (item) => {
    item.isEditing = false;
    item.editedDate = format(new Date(item.spe_date), 'dd-MM-yyyy', { locale: fr });
    item.editedPrice = item.spe_price;
};

const cancelNewRecord = () => {
    showAddForm.value = false;
    newRecord.value = { date: '', price: '' };
};

const remove = async (id) => {
    await axios.delete(`/specials-dates-prices/${id}`);
    await fetchSpecialDatesPrices();
};
  
onMounted(fetchSpecialDatesPrices);
</script>

<style>
.mx-datepicker-main {
  transform: translateX(21%) !important;
}
</style>
