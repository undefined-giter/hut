<template>
    <div v-if="reservations.length > 0" class="bg-[#181a1b] shadow-lg rounded-lg pt-4 mx-auto mb-4">
        <h2>Réservations</h2>

        <div class="max-w-2xl mx-auto p-8 px-12 pt-0">
            <div style="max-height: 350px; overflow-y: auto;">
                <h3 class="text-center" v-if="currentReservations.length > 0">Réservation Actuelle :</h3>
                <ul v-if="currentReservations.length > 0">
                    <li v-for="reservation in currentReservations" :key="reservation.id">
                    {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : 
                    Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                    pour {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                    </li>
                </ul>
        
                <h3 class="text-center mt-2" v-if="upcomingReservations.length > 0">Réservations à venir :</h3>
                <ul v-if="upcomingReservations.length > 0">
                    <li v-for="reservation in upcomingReservations" :key="reservation.id">
                    {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : 
                    Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                    pour {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                    
                        <span style="display: block; text-align: right; margin-top: -32px;">
                            <br><form method="POST" :action="route('reservation.delete', reservation.id)" style="display:inline;" @submit.prevent="confirmDelete">
                                <input type="hidden" name="_token" :value="csrfToken" />
                                <input type="hidden" name="_method" value="DELETE" />
                                <button type="submit" class="text-red-500 text-sm mr-8 mb-2"><span class="text-xs">❌</span>Supprimer</button>
                            </form>
                        </span>
                    </li>
                </ul>
                
                <h3 class="mt-2 text-center" v-if="pastReservations.length > 0">Réservations passées :</h3>
                <ul v-if="pastReservations.length > 0">
                    <li v-for="reservation in pastReservations" :key="reservation.id">
                    {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : 
                    Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                    pour {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';

const csrfToken = ref(null);

onMounted(() => {
  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});

const props = defineProps({
    reservations: Array
});

const today = new Date();

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
    });
};

const currentReservations = computed(() => {
    return props.reservations.filter((reservation) => {
        const startDate = new Date(reservation.start_date);
        const endDate = new Date(reservation.end_date);
        return startDate <= today && endDate >= today;
    });
});

const upcomingReservations = computed(() => {
    return props.reservations.filter((reservation) => {
        return new Date(reservation.start_date) > today;
    });
});

const pastReservations = computed(() => {
    return props.reservations.filter((reservation) => {
        return new Date(reservation.end_date) < today;
    });
});

const confirmDelete = (event) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
        event.target.submit();
    }
};
</script>
