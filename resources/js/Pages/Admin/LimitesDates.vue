<template>
    <div>
        <transition name="fade">
            <div>
                <div>
                    <p>Réservable à partir du <b>{{ formatDate(minDate) }}</b></p>
                    <p>Modifier la date minimale de réservation :</p>
                    <Datepicker 
                        v-model="minDate" 
                        @change="updateMinDate"
                        class="!w-full" />
                </div>
                <br>
                <div>
                    <p>Réservable jusqu'au <b>{{ formatDate(maxDate) }}</b></p>
                    <p>Modifier la date maximale de réservation :</p>
                    <Datepicker 
                        v-model="maxDate" 
                        @change="updateMaxDate"
                        class="!w-full" />
                </div>
            </div>
        </transition>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Datepicker from "vue-datepicker-next";
import "vue-datepicker-next/index.css";

const minDate = ref(null);
const maxDate = ref(null);

const fetchLimitesDates = async () => {
    try {
        const response = await axios.get("/limites-dates");
        if (response.data) {
            minDate.value = response.data.minDate;
            maxDate.value = response.data.maxDate;
        }
    } catch (error) {}
};

const formatDateForBackend = (date) => {
    if (!date) return "";
    const d = new Date(date);
    return d.toISOString().split("T")[0];
};

const updateMinDate = async (newValue) => {   
    const formattedDate = formatDateForBackend(newValue);
    console.log("Mise à jour minDate:", formattedDate);
    try {
        await axios.put(`/limites-dates/min`, { minDate: formattedDate });
    } catch (error) {}
};

const updateMaxDate = async (newValue) => {   
    const formattedDate = formatDateForBackend(newValue);
    console.log("Mise à jour maxDate:", formattedDate);
    try {
        await axios.put(`/limites-dates/max`, { maxDate: formattedDate });
    } catch (error) {}
};

const formatDate = (date) => {
    if (!date) return "";
    return new Date(date).toLocaleDateString("fr-FR", {
        day: "2-digit",
        month: "2-digit",
        year: "numeric"
    });
};

onMounted(fetchLimitesDates);
</script>

<style scoped>
.mx-datepicker-main {
  transform: translateX(21%) !important;
}
</style>
