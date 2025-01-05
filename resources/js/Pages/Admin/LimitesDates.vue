<template>
    <div>
        <transition name="fade">
            <div>
                <div>
                    <p>Réservable à partir du <span class="bold text-green-500">{{ formatDate(minDate) }}</span></p>
                    <p>Modifier la date minimale de réservation :</p>
                    <Datepicker 
                        v-model="minDate" 
                        @change="updateMinDate"
                        class="!w-full" />
                </div>
                <br>
                <div>
                    <p>Réservable jusqu'au <span class="bold text-green-500">{{ formatDate(maxDate) }}</span></p>
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
    return `${d.getFullYear()}-${String(d.getMonth() + 1).padStart(2, "0")}-${String(d.getDate()).padStart(2, "0")}`;
};

const updateMinDate = async (newValue) => {
    const formattedDate = formatDateForBackend(newValue);
    try {
        await axios.patch('/limites-dates/min', { minDate: formattedDate }, {
            headers: { 'Content-Type': 'application/json' }
        });
        minDate.value = formattedDate;
    } catch (error) {}
};

const updateMaxDate = async (newValue) => {
    const formattedDate = formatDateForBackend(newValue);
    
    if (new Date(formattedDate) < new Date(minDate.value)) {
        alert("La date maximale doit être supérieure ou égale à la date minimale.");
        return;
    }

    try {
        await axios.patch(`/limites-dates/max`, { maxDate: formattedDate }, {
            headers: { 'Content-Type': 'application/json' }
        });
        maxDate.value = formattedDate;
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
