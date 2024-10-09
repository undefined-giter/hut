<template>
    <div v-if="reservations.length > 0" class="bg-light dark:bg-dark shadow-md rounded-lg pt-4 mx-auto mb-4 hover:scale-105 transform transition-transform duration-300">
        <h2 class="text-lg">Réservations</h2>

        <div class="max-w-sm mx-auto pb-6">
            <div style="max-height: 350px; overflow-y: auto;">
                <h3 class="text-center dark:text-orangeTheme" v-if="currentReservations.length > 0">Réservation Actuelle :</h3>
                <ul v-if="currentReservations.length > 0" class="mb-6">
                    <li v-for="reservation in currentReservations" :key="reservation.id" class="dark:text-blue-400">

                        <div class="flex justify-between">
                            <div>
                                {{ formatDateShort(new Date(reservation.start_date)) }} - 
                                {{ formatDateShort(new Date(reservation.end_date)) }} : 
                                {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                            </div>
                        
                            <div class="flex text-sm mt-1">
                                <Link :href="route('book.edit', reservation.id)">
                                    <span class="text-xs">✏️</span><span class="dark:text-blue-700">Modifier</span>
                                </Link>
                                <span class="text-zinc-800 mx-1">|</span>
                                <form method="POST" :action="route('book.delete', reservation.id)" @submit.prevent="confirmDelete" class="mr-0.5 text-right">
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="text-red-600 mr-1">
                                        <span class="text-xs">❌</span>Annuler
                                    </button>
                                </form>
                            </div>
                        </div>

                        <div>
                            Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }}
                        </div>

                        <div v-if="reservation.options && reservation.options.length > 0">
                            <em><span class="dark:text-blue-600">Options demandées :</span></em>
                            <ul class="list-disc ml-6">
                                <li v-for="option in reservation.options" :key="option.id" class="dark:text-blue-400">
                                    {{ option.name }} -
                                    <small>
                                        <span v-if="option.price == 0.00">offert</span>
                                        <span v-else>
                                            <span v-if="option.pivot.by_day">
                                                {{ formatPrice(option.price) }}€/nuit soit {{ formatPrice(option.price * reservation.nights) }}€
                                            </span>
                                            <span v-else>
                                                {{ formatPrice(option.price) }}€ - 1 pour le séjour
                                            </span>
                                        </span>
                                    </small>
                                </li>
                            </ul>
                        </div>
                        <div v-else>
                            <em><span class="text-blue-600">Aucune option demandée</span></em>
                        </div>

                        <div v-if="reservation.res_comment">
                            <div class="flex justify-between">
                                <em><button @click="toggleComment(reservation.id)" class="text-orange-500 underline">
                                    {{ visibleComments[reservation.id] ? 'Masquer' : 'Afficher' }} {{ reservation.user_id == connected_user_id  ? 'votre' : 'son' }} commentaire
                                </button></em>
                                <p class="!text-green-400 mr-1">Total : {{ reservation.res_price }}<span class="text-sm">€</span></p>
                            </div>
                            <p v-if="visibleComments[reservation.id]" class="whitespace-pre-wrap break-words">{{ reservation.res_comment }}</p>
                        </div>
                    </li>
                </ul>
        
                <h3 class="text-center text-orangeTheme" v-if="upcomingReservations.length > 0">
                    {{ upcomingReservations.length === 1 ? 'Réservation à venir :' : 'Réservations à venir :' }}
                </h3>
                <ul v-if="upcomingReservations.length > 0" :class="{ 'mb-6': !isLastList }">
                    <li v-for="(reservation, index) in upcomingReservations" 
                        :key="reservation.id" 
                        :class="{ 'mb-6': index !== upcomingReservations.length - 1 }" class="dark:text-blue-400 hover:dark:bg-zinc-900">
                        <div class="flex justify-between">
                            <div>
                                {{ formatDateShort(new Date(reservation.start_date)) }} - 
                                {{ formatDateShort(new Date(reservation.end_date)) }} : 
                                {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                            </div>
                            
                            <div class="flex text-sm mt-1">
                                <Link :href="route('book.edit', reservation.id)">
                                    <span class="text-xs">✏️</span><span class="dark:text-blue-700">Modifier</span>
                                </Link>
                                <span class="text-zinc-800 mx-1">|</span>
                                <form method="POST" :action="route('book.delete', reservation.id)" @submit.prevent="confirmDelete" class="mr-0.5 text-right">
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="text-red-600 mr-1">
                                        <span class="text-xs">❌</span>Annuler
                                    </button>
                                </form>
                            </div>
                        </div>
                        
                        <div>
                            Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }}
                        </div>

                        <div v-if="reservation.options && reservation.options.length > 0">
                            <em><span class="dark:text-blue-600">Options demandées :</span></em>
                            <ul class="list-disc ml-6">
                                <li v-for="option in reservation.options" :key="option.id" class="dark:text-blue-400">
                                    {{ option.name }} -
                                    <small>
                                        <span v-if="option.price == 0.00">offert</span>
                                        <span v-else>
                                            <span v-if="option.pivot.by_day">
                                                {{ formatPrice(option.price) }}€/nuit soit {{ formatPrice(option.price * reservation.nights) }}€
                                            </span>
                                            <span v-else>
                                                {{ formatPrice(option.price) }}€ - 1 pour le séjour
                                            </span>
                                        </span>
                                    </small>
                                </li>
                            </ul>
                        </div>
                        <div v-else>
                            <em><span class="dark:text-blue-600">Aucune option demandée</span></em>
                        </div>

                        <div v-if="reservation.res_comment">
                            <div class="flex justify-between">
                                <em><button @click="toggleComment(reservation.id)" class="text-orange-500 underline">
                                    {{ visibleComments[reservation.id] ? 'Masquer' : 'Afficher' }} {{ reservation.user_id == connected_user_id  ? 'votre' : 'son' }} commentaire
                                </button></em>
                                <p class="!text-green-400 mr-1">Total : {{ reservation.res_price }}<span class="text-sm">€</span></p>
                            </div>
                            <p v-if="visibleComments[reservation.id]" class="whitespace-pre-wrap break-words">{{ reservation.res_comment }}</p>
                        </div>
                    </li>
                </ul>

                <h3 class="text-center dark:text-orangeTheme" v-if="pastReservations.length > 0">
                    {{ pastReservations.length === 1 ? 'Réservation passée :' : 'Réservations passées :' }}
                </h3>
                <ul v-if="pastReservations.length > 0">
                    <li v-for="(reservation, index) in pastReservations" 
                        :key="reservation.id" 
                        :class="{ 'mb-3': index !== pastReservations.length - 1 }" class="dark:text-blue-400">
                    {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }} <br>
                    Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                    
                        <div v-if="reservation.options && reservation.options.length > 0">
                            <em><span class="text-blue-600">Options demandées :</span></em>
                            <ul class="list-disc ml-6">
                                <li v-for="option in reservation.options" :key="option.id" class="dark:text-blue-400">
                                    {{ option.name }} -
                                    <small>
                                        <span v-if="option.price == 0.00">offert</span>
                                        <span v-else>
                                            <span v-if="option.pivot.by_day">
                                                {{ formatPrice(option.price) }}€/nuit soit {{ formatPrice(option.price * reservation.nights) }}€
                                            </span>
                                            <span v-else>
                                                {{ formatPrice(option.price) }}€ - 1 pour le séjour
                                            </span>
                                        </span>
                                    </small>
                                </li>
                            </ul>
                        </div>
                        <div v-else>
                            <em><span class="dark:text-blue-600">Aucune option demandée</span></em>
                        </div>

                        <div v-if="reservation.res_comment">
                            <div class="flex justify-between">
                                <em><button @click="toggleComment(reservation.id)" class="text-orange-500 underline">
                                    {{ visibleComments[reservation.id] ? 'Masquer' : 'Afficher' }} {{ reservation.user_id == connected_user_id  ? 'votre' : 'son' }} commentaire
                                </button></em>
                                <p class="!text-green-400mr-1">Total : {{ reservation.res_price }}<span class="text-sm">€</span></p>
                            </div>
                            <p v-if="visibleComments[reservation.id]" class="whitespace-pre-wrap break-words">{{ reservation.res_comment }}</p>
                        </div>

                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const csrfToken = ref(null);
const isCommentVisible = ref(false);

onMounted(() => {
  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
});

const props = defineProps({
    reservations: Array,
    connected_user_id: Number,
});

const visibleComments = ref({});

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

const formatPrice = (price) => {
    const numericPrice = parseFloat(price);
    if (isNaN(numericPrice)) {
        return 'à déterminer';
    }
    return numericPrice % 1 === 0 ? numericPrice.toFixed(0).replace('.', ',') : numericPrice.toFixed(2).replace('.', ',');
};

const toggleComment = (reservationId) => {
  visibleComments.value = {
    ...visibleComments.value,
    [reservationId]: !visibleComments.value[reservationId],
  };
};

const currentReservations = computed(() => {
    return props.reservations.filter((reservation) => {
        const startDate = new Date(reservation.start_date);
        const endDate = new Date(reservation.end_date);
        return startDate <= today && endDate >= today;
    });
});

const upcomingReservations = computed(() => {
    return props.reservations
        .filter((reservation) => {
            return new Date(reservation.start_date) > today;
        })
        .sort((a, b) => new Date(a.start_date) - new Date(b.start_date));
});


const pastReservations = computed(() => {
    return props.reservations
        .filter((reservation) => {
            return new Date(reservation.end_date) < today;
        })
        .sort((a, b) => new Date(b.end_date) - new Date(a.end_date));
});


const isLastList = computed(() => {
    return upcomingReservations.length === 0 && pastReservations.length === 0;
});

const confirmDelete = (event) => {
    if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
        event.target.submit();
    }
};
</script>
