<template>
    <div v-if="reservations.length > 0" class="shadow-md rounded-lg p-4 mb-4 hover:scale-105 transform transition-transform duration-300">
        <div @click="toggleUnroll(4)" class="flex justify-center">
            <h2 class="text-lg cursor-pointer">Réservations</h2>
            <h2 style="transform: translateY(2px); text-decoration: none; font-size: 1em;">{{ isUnrolled(4) ? '🔼' : '🔽' }}</h2>
        </div>

        <transition name="fade-slide" v-show="isUnrolled(4)" class="bg-light dark:bg-dark rounded-xl py-1 max-w-sm mx-auto mb-4 px-2 md:px-0">
            <div style="max-height: 350px; overflow-y: auto;" class="!px-2">
                <h3 class="text-center dark:text-orangeTheme" v-if="currentReservations.length > 0">Réservation Actuelle :</h3>
                <ul v-if="currentReservations.length > 0" class="mb-6">
                    <li v-for="reservation in currentReservations" :key="reservation.id" class="communFont hover:bg-[#fedeae] hover:dark:bg-[#04180d]">

                        <div class="flex justify-between">
                            <div>
                                {{ formatDateShort(new Date(reservation.start_date)) }} - 
                                {{ formatDateShort(new Date(reservation.end_date)) }} : 
                                {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                            </div>
                        
                            <div class="flex text-sm mt-1">
                                <Link :href="route('book.edit', reservation.id)"><span class="text-xs">✏️</span><span class="text-blue-700">Modifier</span></Link>
                                <span class="text-zinc-800 mx-1">|</span>
                                <form method="POST" :action="route('book.delete', reservation.id)" @submit.prevent="confirmDelete" class="text-right">
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="text-red-600"><span class="text-xs">❌</span>Annuler</button>
                                </form>
                            </div>
                        </div>

                        <div>Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }}</div>

                        <div v-if="reservation.res_comment">
                            <div class="flex justify-between">
                                <button @click="toggleComment(reservation.id)" class="text-orange-500 underline italic">
                                    {{ visibleComments[reservation.id] ? 'Masquer' : 'Afficher' }} {{ reservation.user_id == connected_user_id  ? 'votre' : 'son' }} commentaire
                                </button>
                            </div>
                            <p v-if="visibleComments[reservation.id]" class="whitespace-pre-wrap break-words">{{ reservation.res_comment }}</p>
                        </div>

                        <div v-if="reservation.options && reservation.options.length > 0">
                            <div class="text-blue-600 mt-1"><em>Options demandées :</em></div>
                            <ul class="list-disc ml-6">
                                <li v-for="option in reservation.options" :key="option.id" class="whitespace-normal break-words">
                                    {{ option.name }} -
                                    <small>
                                        <span v-if="option.price == 0.00">Inclu</span>
                                        <span v-else>
                                            <span v-if="option.pivot.by_day">
                                                {{ formatPrice(option.price) }}€/nuit soit {{ formatPrice(option.price * reservation.nights) }}€
                                            </span>
                                            <span v-else>{{ formatPrice(option.price) }}€ - 1 pour le séjour</span>
                                        </span>
                                    </small>
                                </li>
                            </ul>
                        </div>
                        <div v-else class="text-blue-600 italic">Aucune option demandée</div>
                        
                        <div class="text-blue-600 mt-1"><em>Résumé du Tarif :</em></div>
                        <div class="flex justify-between items-end">
                            <p class="text-sm">Nuits & Options : {{ calculateTotal(reservation.res_price) }}<span class="text-sm">€</span></p>
                            <p class="text-sm">Frais carte : {{ calculateTotal(reservation.card_fees) || 0 }} <span class="text-sm">€</span></p>
                            <p class="text-sm">Total : {{ calculateTotal(reservation.res_price, reservation.card_fees) }}<span class="text-sm"> €</span></p>
                        </div>
                        <p class="-mt-0.5">Reste à payer en liquide à l'arrivée : <span class="!text-green-500 text-xl">{{ calculateTotal(reservation.res_price, reservation.card_fees) - reservation.payed }}</span> <span class="!text-green-500 text-sm">€</span></p>
                    </li>
                </ul>
        
                <h3 class="text-center text-orangeTheme" v-if="upcomingReservations.length > 0">{{ upcomingReservations.length === 1 ? 'Réservation à venir :' : 'Réservations à venir :' }}</h3>
                <ul v-if="upcomingReservations.length > 0" :class="[{ 'mb-6': !isLastList }, 'communFont']">
                    <li v-for="(reservation, index) in upcomingReservations" :key="reservation.id" :class="{ 'mb-6': index !== upcomingReservations.length - 1 }" class="communFont hover:bg-[#fedeae] hover:dark:bg-[#04180d]">
                        <div class="flex justify-between">
                            <div>
                                {{ formatDateShort(new Date(reservation.start_date)) }} - 
                                {{ formatDateShort(new Date(reservation.end_date)) }} : 
                                {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }}
                            </div>
                            
                            <div class="flex text-sm mt-1">
                                <Link :href="route('book.edit', reservation.id)">
                                    <span class="text-xs">✏️</span><span class="text-blue-700">Modifier</span>
                                </Link>
                                <span class="!text-zinc-800 mx-1">|</span>
                                <form method="POST" :action="route('book.delete', reservation.id)" @submit.prevent="confirmDelete" class="text-right">
                                    <input type="hidden" name="_token" :value="csrfToken" />
                                    <input type="hidden" name="_method" value="DELETE" />
                                    <button type="submit" class="text-red-600"><span class="text-xs">❌</span>Annuler</button>
                                </form>
                            </div>
                        </div>
                        
                        <div>Du {{ formatDate(new Date(reservation.start_date)) }} à partir de 14h,<br>Au {{ formatDate(new Date(reservation.end_date)) }} jusqu'à 12h.</div>

                        <div v-if="reservation.res_comment">
                            <div class="flex justify-between">
                                <button @click="toggleComment(reservation.id)" class="text-orange-500 underline italic">
                                    {{ visibleComments[reservation.id] ? 'Masquer' : 'Afficher' }} {{ reservation.user_id == connected_user_id  ? 'votre' : 'son' }} commentaire
                                </button>
                            </div>
                            <p v-if="visibleComments[reservation.id]" class="whitespace-pre-wrap break-words">{{ reservation.res_comment }}</p>
                        </div>

                        <div v-if="reservation.options && reservation.options.length > 0">
                            <div class="text-blue-600 mt-1"><em>Options demandées :</em></div>
                            <ul class="communFont list-disc ml-6">
                                <li v-for="option in reservation.options" :key="option.id" class="whitespace-normal break-words">
                                    {{ option.name }} -
                                    <small>
                                        <span v-if="option.price == 0.00">Inclu</span>
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
                        <div v-else class="text-blue-600 italic">Aucune option demandée</div>

                        <div class="text-blue-600 mt-1"><em>Résumé du Tarif :</em></div>
                        <div class="flex justify-between items-end">
                            <p class="text-sm">Nuits & Options : {{ calculateTotal(reservation.res_price) }}<span class="text-sm">€</span></p>
                            <p class="text-sm">Frais carte : {{ calculateTotal(reservation.card_fees) || 0 }} <span class="text-sm">€</span></p>
                            <p class="text-sm">Total : {{ calculateTotal(reservation.res_price, reservation.card_fees) }}<span class="text-sm"> €</span></p>
                        </div>
                        <p class="-mt-0.5">Reste à payer en liquide à l'arrivée : <span class="!text-green-500 text-xl">{{ calculateTotal(reservation.res_price, reservation.card_fees) - reservation.payed }}</span> <span class="!text-green-500 text-sm">€</span></p>
                    </li>
                </ul>

                <h3 class="text-center dark:text-orangeTheme" v-if="pastReservations.length > 0">{{ pastReservations.length === 1 ? 'Réservation passée :' : 'Réservations passées :' }}</h3>
                <ul v-if="pastReservations.length > 0" class="communFont">
                    <li v-for="(reservation, index) in pastReservations" :key="reservation.id" :class="{ 'mb-6': index !== pastReservations.length - 1 }" class="communFont hover:bg-[#fedeae] hover:dark:bg-[#04180d]">
                    {{ formatDateShort(new Date(reservation.start_date)) }} - {{ formatDateShort(new Date(reservation.end_date)) }} : {{ reservation.nights }} nuit{{ reservation.nights > 1 ? 's' : '' }} <br>
                    Du {{ formatDate(new Date(reservation.start_date)) }} au {{ formatDate(new Date(reservation.end_date)) }} 
                    
                    <div v-if="reservation.res_comment">
                        <div class="flex justify-between">
                            <button @click="toggleComment(reservation.id)" class="text-orange-500 underline italic">
                                {{ visibleComments[reservation.id] ? 'Masquer' : 'Afficher' }} {{ reservation.user_id == connected_user_id  ? 'votre' : 'son' }} commentaire
                            </button>
                        </div>
                        <p v-if="visibleComments[reservation.id]" class="whitespace-pre-wrap break-words">{{ reservation.res_comment }}</p>
                    </div>

                        <div v-if="reservation.options && reservation.options.length > 0">
                            <div class="text-blue-600 mt-1"><em>Options demandées :</em></div>
                            <ul class="communFont list-disc ml-6">
                                <li v-for="option in reservation.options" :key="option.id" class="whitespace-normal break-words">
                                    {{ option.name }} -
                                    <small>
                                        <span v-if="option.price == 0.00">Inclu</span>
                                        <span v-else>
                                            <span v-if="option.pivot.by_day">
                                                {{ formatPrice(option.price) }}€/nuit soit {{ formatPrice(option.price * reservation.nights) }}€
                                            </span>
                                            <span v-else>{{ formatPrice(option.price) }}€ - 1 pour le séjour</span>
                                        </span>
                                    </small>
                                </li>
                            </ul>
                        </div>
                        <div v-else class="text-blue-600 italic">Aucune option demandée</div>

                        <div class="text-blue-600 mt-1"><em>Résumé du Tarif :</em></div>
                        <div class="flex justify-between items-end">
                            <p class="text-sm">Nuits & Options : {{ calculateTotal(reservation.res_price) }}<span class="text-sm">€</span></p>
                            <p class="text-sm">Frais carte : {{ calculateTotal(reservation.card_fees) || 0 }} <span class="text-sm">€</span></p>
                            <p class="text-sm">Total : {{ calculateTotal(reservation.res_price, reservation.card_fees) }}<span class="text-sm"> €</span></p>
                        </div>
                        <p class="-mt-0.5">Reste à payer en liquide à l'arrivée : <span class="!text-green-500 text-xl">{{ Math.round(calculateTotal(reservation.res_price, reservation.card_fees) - reservation.payed)}}</span> <span class="!text-green-500 text-sm">€</span></p>
                    </li>
                </ul>
            </div>
        </transition>
        <div class="size-[10px]">&nbsp;</div>
    </div>
    <div v-if="isSubmitting" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-green-600"></div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import { useUnroll } from './../../shared/utils';
import { Link } from '@inertiajs/vue3';
import Swal from 'sweetalert2';

const csrfToken = ref(null);
const isSubmitting = ref(false)

const { isUnrolled, toggleUnroll, setUnroll } = useUnroll();

const visibleComments = ref({});

onMounted(() => {
  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  setUnroll(4, true)
});

const props = defineProps({
    reservations: Array,
    connected_user_id: Number,
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

const formatPrice = (price) => {
    const numericPrice = parseFloat(price);
    if (isNaN(numericPrice)) {
        return 'à déterminer au départ en ';
    }
    return numericPrice % 1 === 0 ? numericPrice.toFixed(0).replace('.', ',') : numericPrice.toFixed(2).replace('.', ',');
};

const calculateTotal = (price, fees) => {
    const resPrice = parseFloat(price) || 0;
    const cardFees = parseFloat(fees) || 0;
    return parseFloat((resPrice + cardFees).toFixed(2));;
}

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
    Swal.fire({
        title: '<span class="text-2xl text-purple-600 underline">Êtes-vous sûr ?</span>',
        text: "Vous ne pourrez pas annuler cette action !",
        icon: 'warning',
        iconColor: '#F97316',
        showCancelButton: true,
        confirmButtonText: 'Oui, supprimer',
        cancelButtonText: 'Non, annuler',
        customClass: {
            popup: 'bg-light dark:bg-dark shadow-lg rounded-lg',
            title: 'font-mirza text-pink-600',
            confirmButton: 'bg-orangeTheme text-white font-bold py-2 px-4 rounded-lg hover:bg-orange-700 focus:ring-4 focus:ring-orangeTheme',
            cancelButton: 'bg-gray-300 text-black font-bold py-2 px-4 rounded-lg hover:bg-gray-400 focus:ring-4 focus:ring-gray-200',
        },
        buttonsStyling: false,
    }).then((result) => {
        if (result.isConfirmed) {
            isSubmitting.value = true;
            event.target.submit();
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                title: '<span class="font-mirza text-green-600">Annulé</span>',
                text: 'Votre réservation est toujours active.',
                icon: 'info',
                customClass: {
                    popup: 'bg-light dark:bg-dark shadow-lg rounded-lg',
                    confirmButton: 'bg-green-600 text-white font-bold py-2 px-4 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300',
                },
            });
        }
    });
};
</script>
