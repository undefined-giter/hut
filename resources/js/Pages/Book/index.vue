<template>
  <Layout>
      <Head title="Réserver | Cabane" />
      <h1 class="text-2xl font-semibold mb-5 text-center">Réserver Votre Bonheur !</h1>

      <div class="mx-12">
          <vue-cal
              locale="fr"
              active-view="month"
              hide-view-selector
              @cell-click="handleDateClick"
              :disable-views="['years', 'year', 'week', 'day']"
              :dblclick-to-navigate="false"
              style="color:#ccc;"
          />

          <form method="POST" action="/book">
              <input type="hidden" name="_token" :value="csrfToken" />
              <input type="hidden" name="start_date" :value="arrivalDate ? arrivalDate.toISOString().split('T')[0] : ''" />
              <input type="hidden" name="end_date" :value="departureDate ? departureDate.toISOString().split('T')[0] : ''" />
              <input type="hidden" name="nights" :value="numberOfNights" />

              <div class="flex justify-between items-start mt-4">
                  <div>
                      <div v-if="arrivalDate && !departureDate">
                          Date d'arrivée sélectionnée: <span class="text-green-500">{{ formatDate(arrivalDate) }}</span>.<br>
                          <span class="text-orange-600">Veuillez sélectionner votre date de départ.</span>
                      </div>
                      <div v-if="!arrivalDate && !arrivalDate" class="text-orange-600">
                          Sélectionnez votre date d'arrivée
                      </div>

                      <div v-if="departureDate" class="text-green-500">
                          Réservation du <span class="text-xl font-bold">{{ formatDate(arrivalDate) }}</span>
                          au <span class="text-xl font-bold">{{ formatDate(departureDate) }}</span>.<br>
                          <p class="mt-2 text-sm">Nombre de nuit{{ numberOfNights > 1 ? 's' : '' }} : <b>{{ numberOfNights }}</b></p>
                      </div>

                      <div v-if="dateError" class="text-red-500">
                          {{ dateError }}
                      </div>
                  </div>
                  <div class="flex space-x-4">
                      <button type="button" class="!bg-orange-600 btn" @click="resetReservation">
                          Reset
                      </button>
                      <button type="submit" :disabled="!isReservationValid" :class="[isReservationValid ? '' : '!bg-gray-400 hover:text-gray-400', 'btn']">Réserver</button>
                  </div>
              </div>
          </form>
      </div>
  </Layout>
</template>

<script setup>
import Layout from './../Layout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import { ref, onMounted } from 'vue';

const arrivalDate = ref(null);
const departureDate = ref(null);
const dateError = ref(null);
const numberOfNights = ref(0);
const isReservationValid = ref(false);
const csrfToken = ref(null);
const events = ref([]);

const { reservations } = usePage().props;
console.log(reservations);

onMounted(() => {
  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});

const handleDateClick = (cell) => {
  const selectedDate = new Date(cell);
  selectedDate.setHours(23, 59, 59, 999);

  const today = new Date();
  today.setHours(0, 0, 0, 0);

  if (selectedDate < today) {
    dateError.value = "La date d'arrivée ne peut pas être inférieure à la date actuelle.";
    resetReservation();
    return;
  }

  const oneMonthLater = arrivalDate.value ? new Date(arrivalDate.value) : null;
  if (oneMonthLater) {
    oneMonthLater.setMonth(oneMonthLater.getMonth() + 1);
  }

  if (!arrivalDate.value) {
    arrivalDate.value = selectedDate;
    departureDate.value = null;
    dateError.value = null;
    numberOfNights.value = 0;
    isReservationValid.value = false;
  } else if (selectedDate <= arrivalDate.value) {
    dateError.value = "La date de départ doit être après la date d'arrivée.";
    resetReservation();
  } else if (oneMonthLater && selectedDate > oneMonthLater) {
    dateError.value = "La durée maximale de réservation est d'un mois.";
    resetReservation();
  } else {
    departureDate.value = selectedDate;
    const timeDiff = departureDate.value.getTime() - arrivalDate.value.getTime();
    numberOfNights.value = Math.floor(timeDiff / (1000 * 3600 * 24));
    isReservationValid.value = true;
  }
};

const resetReservation = () => {
  arrivalDate.value = null;
  departureDate.value = null;
  dateError.value = null;
  numberOfNights.value = 0;
  isReservationValid.value = false;
};

const formatDate = (date) => {
  return date.toLocaleDateString('fr-FR', {
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric',
  });
};
</script>

  
<style>
.vuecal__cell-events-count{
    display: none;
}
.vuecal__cell--out-of-scope{
  color:grey;
}
</style>
