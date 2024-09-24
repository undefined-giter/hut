<template>
  <Layout>
      <Head title="Réserver | Cabane" />
      <h1>Réserver Votre Bonheur !</h1>

      <p>Les réservation commencent à 14h jusqu'à 12h le lendemain - parking gratuit inclu</p>
      <vue-cal
        locale="fr"
        active-view="month"
        class="vuecal--rounded-theme vuecal--blue-theme dark:text-gray-200"
        hide-view-selector
        @cell-click="handleDateClick"
        :disable-views="['years', 'year', 'week', 'day']"
        :dblclick-to-navigate="false"
        style="height:300px;"
        :min-date="today"
      />

      <form method="POST" action="/book">
        <input type="hidden" name="_token" :value="csrfToken" />
        <input type="hidden" name="start_date" :value="arrivalDate ? arrivalDate.toISOString().split('T')[0] : ''" />
        <input type="hidden" name="end_date" :value="departureDate ? departureDate.toISOString().split('T')[0] : ''" />
        <input type="hidden" name="nights" :value="numberOfNights" />
        <input type="hidden" name="options" :value="JSON.stringify(selectedOptions)" />

        <div class="flex justify-between items-start mt-4">
          <div class="min-h-[60px]">
            <div v-if="arrivalDate && !departureDate">
              <span v-html="`<p style='display: inline;'>Date d'arrivée sélectionnée: </p><span class='text-green-500'>${formatDate(arrivalDate)}</span>.`"></span>
              <br>
              <span class="text-orange-600">Veuillez sélectionner votre date de départ.</span>
            </div>

            <div v-if="!arrivalDate && !arrivalDate">
              <p class="!text-orange-600">Sélectionnez votre date d'arrivée</p>
            </div>

            <div v-if="departureDate" class="text-green-500">
              <span v-html="`Réservation du <span class='text-xl font-bold'>${formatDate(arrivalDate)}</span> au <span class='text-xl font-bold'>${formatDate(departureDate)}</span>.`"></span>
              <br>
              <p class="my-1 text-sm">Nombre de nuit{{ numberOfNights > 1 ? 's' : '' }} : <b>{{ numberOfNights }}</b></p>
            </div>

            <div v-if="dateError" class="text-red-600">
              {{ dateError }}
            </div>
          </div>
          <div class="flex flex-col sm:flex-row sm:space-x-2 sm:space-y-0 space-y-2">
            <button type="button" class="!bg-orange-600 btn !px-2" @click="resetReservation">
              <small>Réinitialiser</small>
            </button>
            <button type="submit" :disabled="!isReservationValid" :class="[isReservationValid ? '' : '!bg-gray-600 hover:text-gray-400', 'btn']">Réserver</button>
          </div>
        </div>

        <div class="mt-4">
          <h3 class="underline text-blue-500 text-xl">Options disponibles :</h3>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <label
              v-for="option in options" 
              :key="option.id" 
              @click="toggleOption(option.id)" 
              :class="['mb-2 p-4 border border-blue-600 rounded-md shadow-sm cursor-pointer transition', selectedOptions.includes(option.id) ? 'dark:bg-green-600' : 'dark:bg-orange-500']"
            >
              <div class="flex items-center w-full">
                <input 
                  type="checkbox" 
                  :value="option.id" 
                  v-model="selectedOptions" 
                  class="mr-2 form-checkbox h-6 w-6 rounded-full text-blue-600 border-gray-300 focus:ring-blue-500" 
                  @click.stop
                />
                <div class="flex justify-between w-full">
                  <div class="oleoScript text-xl">{{ option.name }}</div> 
                  <div v-if="option.price !== null && option.price !== '' && option.price !== '0.00'">{{ option.price }}€</div>
                  <div v-if="option.price === '0.00'">Gratuit</div>
                </div>
              </div>
              <p :class="selectedOptions.includes(option.id) ? 'text-green-600 dark:text-gray-200' : 'text-orange-600 dark:text-grey-200'">
                {{ option.description }}
              </p>
            </label>
          </div>
        </div>
      </form>
    
      <div v-if="sortedReservations.length > 0" class="mt-4">
        <h3 class="underline text-red-600 text-xl">Nuits déjà réservées :</h3>
        <div style="max-height: 350px; overflow-y: auto;">
          <p><li v-for="(reservation, index) in sortedReservations" :key="index">
            <span v-html="formatDateShort(new Date(reservation.start_date)) + ' - ' + formatDateShort(new Date(reservation.end_date))"></span> :
            <span v-html="'Du ' + formatDate(new Date(reservation.start_date)) + ' au ' + formatDate(new Date(reservation.end_date)) + ' pour ' + reservation.nights + ' nuit' + (reservation.nights > 1 ? 's' : '')"></span>
            <span v-if="auth && auth.user && auth.user.role === 'admin'">
              => <form method="POST" :action="route('reservation.delete', reservation.id)" style="display:inline;" @submit.prevent="confirmDelete">
                  <input type="hidden" name="_token" :value="csrfToken" />
                  <input type="hidden" name="_method" value="DELETE" />
                  <button type="submit" class="text-red-600"><span class="text-xs">❌</span>Annuler</button>
              </form>
              <span class="text-zinc-800 text-sm"> | </span> 
              <Link :href="route('admin.details', reservation.user_id)" target="_blank"><span class="text-xs">➡️</span><span class="text-blue-600">Profil</span></Link>
            </span>
          </li></p>
        </div>
    </div>
  </Layout>
</template>

<script setup>
import Layout from './../Layout.vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import { ref, onMounted, computed } from 'vue';

const { auth, reservations, options } = usePage().props;

const arrivalDate = ref(null);
const departureDate = ref(null);
const dateError = ref(null);
const numberOfNights = ref(0);
const isReservationValid = ref(false);
const csrfToken = ref(null);
const today = new Date();
const selectedOptions = ref([]);


onMounted(() => {
  options.sort((a, b) => b.preselected - a.preselected);
  selectedOptions.value = options.filter(option => option.preselected).map(option => option.id);

  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});

const handleDateClick = (cell) => {
  const selectedDate = new Date(cell);
  selectedDate.setHours(23, 59, 59, 999);

  if (selectedDate < today) {
    dateError.value = "La date d'arrivée ne peut pas être inférieure à la date actuelle.";
    resetReservation();
    return;
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

const formatDateShort = (date) => {
  return date.toLocaleDateString('fr-FR', {
    year: '2-digit',
    month: '2-digit',
    day: '2-digit',
  });
};

const formatDate = (date) => {
  return date.toLocaleDateString('fr-FR', {
    weekday: 'long',
    month: 'long',
    day: 'numeric',
  }) + ` <small>${date.getFullYear()}</small>`;
};

const sortedReservations = computed(() => {
  return reservations.sort((a, b) => new Date(a.start_date) - new Date(b.start_date));
});

const confirmDelete = (event) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
        event.target.submit();
    }
};
</script>

<style>
.vuecal__cell-date{color:#ccc}
.vuecal__cell-events-count{display: none;}
.vuecal__cell--out-of-scope{color:grey;}
.vuecal__cell--disabled {text-decoration: line-through;}
.vuecal__cell--before-min {color: #b6d6c7;}
.reserved-event {
  background-color: red !important;
  color: blue !important;
}
</style>
