<template>
    <transition name="fade-slide" v-if="sortedReservations.length > 0" class="shadow-md transition-all duration-300" style="max-height: 350px; overflow-y: auto; padding-left:2px;">
      <p>
        <li
          v-for="(reservation, index) in sortedReservations"
          :key="index"
          :class="{
            'dark:text-gray-200 my-2': index % 2 === 0,
            '!text-blue-500': index % 2 !== 0
          }"
          class="flex items-center justify-between space-x-2"
        >
          <div>
            <span
              v-html="formatDateShort(new Date(reservation.start_date)) + ' - ' + formatDateShort(new Date(reservation.end_date))"
            ></span>
            :
            <span
              v-html="'Du ' + formatDate(new Date(reservation.start_date)) + ' au ' + formatDate(new Date(reservation.end_date)) + ' pour ' + reservation.nights + ' nuit' + (reservation.nights > 1 ? 's ' : ' ')"
            ></span>
            <span v-if="auth && auth.user && auth.user.id === reservation.user_id">
              <Link :href="route('profile', reservation.user_id)" class="text-blue-600">
                <span class="text-sm">🟢</span
                ><span v-if="auth && auth.user && auth.user.role !== 'admin'">La vôtre</span>
              </Link>
            </span>
            <span v-if="auth && auth.user && (auth.user.role === 'admin' || auth.user.role === 'fake_admin')">
              <Link :href="route('admin.details', reservation.user_id)">
                <span class="text-xs">➡️</span><span class="text-blue-700">Profil</span>
              </Link>
            </span>
          </div>
          <div v-if="auth && auth.user && (auth.user.role === 'admin' || auth.user.role === 'fake_admin')" class="flex items-center space-x-1">
            <form
              method="POST"
              :action="route('book.delete', reservation.id)"
              @submit.prevent="confirmDelete"
              class="inline"
            >
              <input type="hidden" name="_token" :value="usePage().props.csrf_token" />
              <input type="hidden" name="_method" value="DELETE" />
              <button type="submit" class="text-red-600">
                <span class="text-xs">❌Annuler</span>
              </button>
            </form>
            <p class="!text-green-400 text-sm">
              {{ Math.round(reservation.res_price) }}
              <span v-if="reservation.res_price">€</span>
              <span v-else>&nbsp;</span>
            </p>
          </div>
        </li>
      </p>
    </transition>
</template>

<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { computed } from 'vue';


const props = defineProps({
  reservations: {
    type: Array,
  },
  formatDate: {
    type: Function,
    required: true,
  },
  auth: {
    type: Object,
    required: true,
  }
});

const formatDateShort = (date) => {
  return date.toLocaleDateString('fr-FR', {
    year: '2-digit',
    month: '2-digit',
    day: '2-digit',
  });
};

const sortedReservations = computed(() => {
  return props.reservations.sort((a, b) => new Date(a.start_date) - new Date(b.start_date));
});

const confirmDelete = (event) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
        event.target.submit();
    }
};
</script>