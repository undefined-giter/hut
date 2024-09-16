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

            <div class="flex justify-between items-start mt-4">
                <div>
                    <div v-if="arrivalDate && !departureDate">
                        Date d'arrivée sélectionnée: <span class="text-green-500">{{ formatDate(arrivalDate) }}</span>.<br><span class="text-orange-600">Veuillez sélectionner votre date de départ.</span>
                    </div>
                    <div v-if="!arrivalDate" class="text-orange-600">
                        Sélectionnez votre date d'arrivée
                    </div>

                    <div v-if="departureDate" class="text-green-500">
                        Réservation du <span class="text-xl font-bold">{{ formatDate(arrivalDate) }}</span> au <span class="text-xl font-bold">{{ formatDate(departureDate) }}</span>.<br>
                        <p class="mt-2 text-sm">Nombre de nuit{{ numberOfNights > 1 ? 's' : '' }} : <b>{{ numberOfNights }}</b></p>
                    </div>

                    <div v-if="dateError" class="text-red-500">
                        {{ dateError }}
                    </div>
                </div>
                <div class="flex space-x-4">
                    <button
                        class="!bg-orange-600 btn"
                        @click="resetReservation"
                    >
                        Reset
                    </button>
                    <button
                        :disabled="!isReservationValid"
                        :class="[isReservationValid ? 'bg-blue-500' : 'bg-gray-400', 'btn']"
                        @click="submitReservation"
                    >
                        Réserver
                    </button>
                </div>
            </div>
        </div>
    </Layout>
</template>
  
<script>
import Layout from './../Layout.vue';
import { Head } from '@inertiajs/vue3';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import { ref } from 'vue';

export default {
  components: { VueCal, Layout, Head },
  setup() {
    const arrivalDate = ref(null);
    const departureDate = ref(null);
    const dateError = ref(null);
    const numberOfNights = ref(0);
    const isReservationValid = ref(false);

    const today = new Date();
    today.setHours(0, 0, 0, 0);

    const handleDateClick = (cell) => {
      const selectedDate = new Date(cell);
      selectedDate.setHours(23, 59, 59, 999);

      if (selectedDate < today) {
        dateError.value = "La date d'arrivée ne peut pas être inférieure à la date actuelle.";
        arrivalDate.value = null;
        departureDate.value = null;
        numberOfNights.value = 0;
        isReservationValid.value = false;
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
        arrivalDate.value = selectedDate;
        departureDate.value = null;
        numberOfNights.value = 0;
        isReservationValid.value = false;
      } else if (oneMonthLater && selectedDate > oneMonthLater) {
        dateError.value = "La durée maximale de réservation est d'un mois.";
        numberOfNights.value = 0;
        isReservationValid.value = false;
      } else {
        departureDate.value = selectedDate;
        dateError.value = null;

        const timeDiff = departureDate.value.getTime() - arrivalDate.value.getTime();
        numberOfNights.value = Math.floor(timeDiff / (1000 * 3600 * 24));

        isReservationValid.value = true;
      }
    };

    const submitReservation = () => {
        if (!isReservationValid.value) return;

        fetch('/reservations', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: JSON.stringify({
                start_date: arrivalDate.value,
                end_date: departureDate.value,
                nights: numberOfNights.value,
            }),
        })
            .then((response) => response.json())
            .then((data) => {
                alert('Réservation effectuée avec succès');
            })
            .catch((error) => {
                console.error('Erreur lors de la réservation :', error);
            });
        };
        console.log('yyy')
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

    return {
      arrivalDate,
      departureDate,
      handleDateClick,
      formatDate,
      numberOfNights,
      dateError,
      isReservationValid,
      submitReservation,
      resetReservation,
    };
  },
};

</script>
  
<style>
.vuecal__cell-events-count{
    display: none;
}
</style>
