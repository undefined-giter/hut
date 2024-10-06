<template>
  <Layout>
    <Head title="Réserver | Cabane" />
    <h1>Réserver Votre Bonheur !</h1>

    <div class="flex justify-between">
      <p>Les réservations commencent à 14h, jusqu'à 12h le jour du départ.</p><p>Parking inclu</p>
    </div>
    <vue-cal
      locale="fr"
      active-view="month"
      class="vuecal--rounded-theme vuecal--blue-theme text-black dark:text-[#ccc]"
      hide-view-selector
      @cell-click="handleDateClick"
      :disable-views="['years', 'year', 'week', 'day']"
      :dblclick-to-navigate="false"
      style="height:400px;"
      :min-date="today"
      :selected-date="showMonth"
    >
      <template #cell-content="{ cell }">
        <span 
            :class="['vuecal__cell-date cursor-pointer', edit_reservation_dates.map(date => new Date(date).toISOString().split('T')[0])
              .includes(new Date(cell.formattedDate).toISOString().split('T')[0]) 
              ? 'text-[#cca5cc] font-bold underline decoration-black underline-offset-2 shadow-[0_0_10px_#b700b7]'
              : '',
              (() => {
                const cellDateFormatted = cell.formattedDate;
                const arrivalDateFormatted = arrivalDate ? arrivalDate.toISOString().split('T')[0] : null;
                const departureDateFormatted = departureDate ? departureDate.toISOString().split('T')[0] : null;

                const innerDates = [];
                if (arrivalDateFormatted && departureDateFormatted) {
                  let currentDate = new Date(arrivalDateFormatted);
                  currentDate.setDate(currentDate.getDate() + 1);

                  while (currentDate.toISOString().split('T')[0] < departureDateFormatted) {
                    innerDates.push(currentDate.toISOString().split('T')[0]);
                    currentDate.setDate(currentDate.getDate() + 1);
                  }
                }

                if (
                  arrivalDateFormatted === cellDateFormatted || 
                  departureDateFormatted === cellDateFormatted ||
                  innerDates.includes(cellDateFormatted)
                ) { return 'selected-range'; }
                return '';
              })()
            ]"

            :style="(() => {
              const userIn = Array.isArray(user_in_date) && user_in_date.includes(cell.formattedDate);
              const userInner = Array.isArray(user_inner_date) && user_inner_date.includes(cell.formattedDate);
              const userOut = Array.isArray(user_out_date) && user_out_date.includes(cell.formattedDate);
              const userSwitch = Array.isArray(user_switch_date) && user_switch_date.includes(cell.formattedDate);
              const userSwitchToOther = Array.isArray(user_switch_to_other) && user_switch_to_other.includes(cell.formattedDate);
              const otherSwitchToUser = Array.isArray(other_switch_to_user) && other_switch_to_user.includes(cell.formattedDate);

              const result = isReservedDate(cell.formattedDate);
              
              if (userIn) {
                return 'background: linear-gradient(to right, blue, blue, blue, blue, green, green, green, green);';
              } else if (userInner) {
                return 'background: green;';
              } else if (userOut) {
                return 'background: linear-gradient(to right, green, green, green, green, blue, blue, blue, blue);';
              } else if (userSwitch) {
                return 'background: linear-gradient(to right, green, green, green, green, #410045, green, green, green, green);';
              } else if (userSwitchToOther) {
                return 'background: linear-gradient(to right, green, green, green, green, #410045, red, red, red, red);';
              } else if (otherSwitchToUser) {
                return 'background: linear-gradient(to right, red, red, red, red, #410045, green, green, green, green);';
              }

              switch (result) {
                  case 'in':
                      return 'background: linear-gradient(to right, blue, blue, blue, blue, red, red, red, red);';
                  case 'inner':
                      return 'background: red;';
                  case 'out':
                      return 'background: linear-gradient(to right, red, red, red, red, blue, blue, blue, blue);';
                  case 'switch':
                      return 'background: linear-gradient(to right, red, red, red, #2c006c, red, red, red);';
                  default:
                      return '';
              }
          })()">
          {{ cell.content }}
        </span>
      </template>
    </vue-cal>

    <form method="POST" id="reservationForm" :action="reservationEdit ? `/book/${reservationEdit.id}/update` : '/book'">
      <input type="hidden" name="_token" :value="csrfToken" />
      <input type="hidden" name="start_date" :value="arrivalDate ? arrivalDate.toISOString().split('T')[0] : ''" />
      <input type="hidden" name="end_date" :value="departureDate ? departureDate.toISOString().split('T')[0] : ''" />
      <input type="hidden" name="nights" :value="numberOfNights" />
      <input type="hidden" name="res_comment" :value="res_comment" />
      <input type="hidden" name="options" :value="JSON.stringify(selectedOptionsIds)" />
      <input type="hidden" name="res_price" :value="calculatedPrice" />

      <div class="flex justify-between items-start mt-4">
        <div class="min-h-[60px]">
          <div v-if="arrivalDate && !departureDate">
            <span v-html="`<p style='display: inline;'>Date d'arrivée sélectionnée: </p><span class='text-green-800 dark:text-green-500'>${formatDate(arrivalDate)}</span>.`"></span>
            <br>
            <span class="text-orange-600">Veuillez sélectionner votre date de départ.</span>
          </div>

          <div v-if="!arrivalDate && !arrivalDate">
            <p class="!text-orange-600">Sélectionnez votre date d'arrivée</p>
          </div>

          <div v-if="departureDate" class="text-green-800 dark:text-green-500">
            <span v-html="`Réservation du <span class='text-xl font-bold'>${formatDate(arrivalDate)}</span> au <span class='text-xl font-bold'>${formatDate(departureDate)}</span>.`"></span>
            <br>
            <p class="my-1 text-sm">Nombre de nuit{{ numberOfNights > 1 ? 's' : '' }} : <b>{{ numberOfNights }}</b></p>
          </div>

          <div v-if="dateError" class="text-red-600">
            {{ dateError }}
          </div>
        </div>
        <button type="button" class="!bg-orange-600 btn !px-2" @click="resetReservation">Réinitialiser</button>
      </div>

      <h3 v-if="options" class="underline text-blue-700 dark:text-blue-500 text-xl mt-4">Options disponibles :</h3>
      <div :class="gridClass" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 max-h-[450px] overflow-y-auto shadow-sm overflow-x-hidden" :style="{ padding: `2px ${gridClass === 'one-column' ? '5px' : '0'}`,
        paddingRight: isScrollbarVisible && gridClass == 'one-column' ? '7px' : isScrollbarVisible ? '1px' : '0'}">
        <label v-for="(option, index) in options" :key="option.id"
              class="relative h-[154px] option_hover p-3.5 border border-2 rounded-md shadow-sm cursor-pointer duration-300 transform hover:z-10"
              :class="[selectedOptionsIds.includes(option.id) ? 'dark:bg-green-600 border border-green-600' : 'dark:bg-orange-500 border border-orange-600']">
          <div class="flex items-center w-full">
            <input type="checkbox" :value="option.id" v-model="selectedOptionsIds" class="mr-1.5 -mt-0.5 form-checkbox"/>
            <div class="flex justify-between w-full">
              <div class="oleoScript text-xl overflow-y-auto max-w-[200px]">{{ option.name }}</div> 
              <div v-if="option.price !== null && option.price !== '' && option.price !== '0.00'">{{ option.price }}€</div>
              <div v-if="option.price === '0.00'">Inclu</div>
            </div>
          </div>

          <p :class="selectedOptionsIds.includes(option.id) ? 'text-green-700 dark:text-gray-200 break-words mb-0.5' : 'text-orange-600 dark:text-gray-200 break-words mb-0.5'" class="overflow-y-scroll max-h-[80px] whitespace-pre-wrap hide-scrollbar">
            {{ option.description }}
          </p>

          <label @change="handleOptionChange(option)" class="absolute bottom-1.5 right-2 flex items-center space-x-0.5">
            <span class="text-sm absolute right-12 w-[60px] flex text-gray-800 mirza font-semibold -mr-2 -mt-1">Par jour ?</span>
            <input type="checkbox" v-model="option.by_day" class="sr-only peer" :disabled="!selectedOptionsIds.includes(option.id)" />
            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] 
              after:absolute after:top-[2px] after:left-[4px] peer-checked:bg-green-800 peer-checked:after:bg-green-300 
              after:bg-gray-300 peer-checked:before:bg-green-800 after:rounded-full after:h-5 after:w-5 after:transition-all border border-black border-[1.5px]"
            ></div>
          </label>
        </label>
      </div>
      <div class="flex">
        <div class="flex-1 mr-4 relative">
          <label for="res_comment">Quelque chose à nous demander ?</label>
          <textarea id="res_comment" v-model="res_comment" maxlength="510" cols="2" :placeholder="resCommentPlaceholder" class="w-full -mt-0.5"></textarea>
          <p v-if="res_comment" :class="['absolute top-3.5 right-3.5', res_comment.length === 510 ? '!text-orange-600' : '']">{{ res_comment.length }}/510<small> caractères</small></p>
        </div>
        <div class="ml-auto mt-auto mb-1">
          <Price @price-updated="updateCalculatedPrice"  :resNights="numberOfNights" :resOptions="selectedOptionsObjects" />
          <button type="submit" form="reservationForm" :disabled="!isReservationValid" :class="[isReservationValid ? '' : '!bg-gray-600 hover:text-gray-400 opacity-75', 'btn ml-auto block']">
            {{ reservationEdit ? 'Modifier' : 'Réserver' }}
          </button>
        </div>
      </div>
    </form>
      
    
    <div v-if="sortedReservations.length > 0" class="mt-4 shadow-sm">
      <h3 class="underline text-red-600 text-xl">Nuits déjà réservées :</h3>
      <div style="max-height: 350px; overflow-y: auto; padding-left:2px;">
        <p><li v-for="(reservation, index) in sortedReservations" :key="index" :class="{'dark:text-gray-200 my-2': index % 2 === 0, '!text-blue-500': index % 2 !== 0}">
          <span v-html="formatDateShort(new Date(reservation.start_date)) + ' - ' + formatDateShort(new Date(reservation.end_date))"></span> :
          <span v-html="'Du ' + formatDate(new Date(reservation.start_date)) + ' au ' + formatDate(new Date(reservation.end_date)) + ' pour ' + reservation.nights + ' nuit' + (reservation.nights > 1 ? 's' : '')"></span>
          <span v-if="auth && auth.user && auth.user.role === 'admin'">
            => <form method="POST" :action="route('book.delete', reservation.id)" style="display:inline;" @submit.prevent="confirmDelete">
                <input type="hidden" name="_token" :value="csrfToken" />
                <input type="hidden" name="_method" value="DELETE" />
                <button type="submit" class="text-red-600"><span class="text-xs">❌</span>Annuler</button>
            </form>
            <span class="text-zinc-800 text-sm"> | </span> 
            <Link :href="route('admin.details', reservation.user_id)" target="_blank"><span class="text-xs">➡️</span><span class="text-blue-700">Profil</span></Link>
            <p class="!text-green-400 text-right mr-1.5 -mt-8">{{ Math.floor(reservation.res_price) }}<span v-if="reservation.res_price" class="text-sm -mt-7">€</span><span v-else> </span></p>
          </span>
        </li></p>
      </div>
    </div>
  </Layout>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import Price from './../Components/Price.vue';
import Layout from './../Layout.vue';
import 'vue-cal/dist/vuecal.css';
import VueCal from 'vue-cal';

const { auth, reservations, options, reservationEdit, showMonthEdit, 
  in_date, inner_date, out_date, switch_date, 
  user_in_date, user_inner_date, user_out_date, user_switch_date, user_switch_to_other, other_switch_to_user,
  edit_reservation_dates = []  } = usePage().props;
  
const arrivalDate = ref(null);
const departureDate = ref(null);
const showMonth = ref(showMonthEdit ?? null);
const dateError = ref(null);
const numberOfNights = ref(0);
const res_comment = ref('');
const resCommentPlaceholder = "Bonjour,\nN'hésitez pas à partager plus de précisions afin que nous préparions au mieux votre séjour (h arrivée envisagée, ...)";
const isReservationValid = ref(reservationEdit ? true : false);
const csrfToken = ref(null);
const today = new Date();
const selectedOptionsObjects = ref([]);  
const selectedOptionsIds = ref([]);  
const calculatedPrice = ref(0);
const gridClass = ref('three-columns');
const isScrollbarVisible = ref(false);


onMounted(() => {  
  if (Array.isArray(options)) {
    options.forEach(option => {
      option.by_day = option.by_day_preselected == 1;
    });

    options.sort((a, b) => b.preselected - a.preselected);
    selectedOptionsObjects.value = options.filter(option => option.preselected);
    selectedOptionsIds.value = options.filter(option => option.preselected).map(option => option.id);
  }

  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

  
  if (reservationEdit) {
    arrivalDate.value = new Date(reservationEdit.start_date);
    departureDate.value = new Date(reservationEdit.end_date);
    numberOfNights.value = reservationEdit.nights;
    
    if (Array.isArray(reservationEdit.options)) {
      selectedOptionsIds.value = reservationEdit.options.map(option => option.id);
      selectedOptionsObjects.value = reservationEdit.options;
    }
    
    if (reservationEdit.res_comment) { res_comment.value = reservationEdit.res_comment; }
  }

  updateGridClass();
  window.addEventListener('resize', updateGridClass);
});

const isReservedDate = (cellDate) => {
  if (in_date.includes(cellDate)) {
    return 'in';
  } else if (inner_date.includes(cellDate)) {
    return 'inner';
  } else if (out_date.includes(cellDate)) {
    return 'out';
  } else if (switch_date.includes(cellDate)) {
    return 'switch';
  } else {
    return false;
  }
};

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
  document.querySelector('.vuecal__cell--selected').classList.remove('vuecal__cell--selected')
};

const formatDate = (date) => {
  return date.toLocaleDateString('fr-FR', {
    weekday: 'long',
    month: 'long',
    day: 'numeric',
  }) + ` <small>${date.getFullYear()}</small>`;
};

const formatDateShort = (date) => {
  return date.toLocaleDateString('fr-FR', {
    year: '2-digit',
    month: '2-digit',
    day: '2-digit',
  });
};

const sortedReservations = computed(() => {
  return reservations.sort((a, b) => new Date(a.start_date) - new Date(b.start_date));
});


const updateGridClass = () => {
  const windowWidth = window.innerWidth;
  
  if (windowWidth >= 1024) {
    gridClass.value = 'three-columns';
  } else if (windowWidth >= 640) {
    gridClass.value = 'two-columns';
  } else {
    gridClass.value = 'one-column';
  }

  checkScrollbar();
};

const checkScrollbar = () => {
  const container = document.querySelector('.grid');
  isScrollbarVisible.value = container.scrollHeight > container.clientHeight;
};


watch(selectedOptionsIds, (newSelectedIds, oldSelectedIds) => {
  const updatedOptions = options.filter(option => newSelectedIds.includes(option.id));

  if (JSON.stringify(updatedOptions) !== JSON.stringify(selectedOptionsObjects.value)) {
    selectedOptionsObjects.value = updatedOptions;
  }

  options.forEach(option => {
    if (newSelectedIds.includes(option.id)) {
      if (oldSelectedIds.includes(option.id) === false) {
        option.by_day = option.by_day_preselected == 1;
      }
    } else {
      if (option.by_day) {
        option.by_day = false;
      }
    }
  });
});

const handleOptionChange = (option) => {
  if (selectedOptionsIds.value.includes(option.id)) {
    selectedOptionsObjects.value = options.filter(opt => selectedOptionsIds.value.includes(opt.id));
  }
};

const updateCalculatedPrice = (price) => {
  calculatedPrice.value = price;
};

const confirmDelete = (event) => {
  if (confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?')) {
    event.target.submit();
  }
};

onUnmounted(() => {
  window.removeEventListener('resize', updateGridClass);
});
</script>

<style>
.option_hover {transition: transform 0.3s ease;}
.option_hover:hover {transform: scale(1.02);}

.one-column .option_hover {transform-origin: center;}

.two-columns .option_hover:nth-child(even) {transform-origin: right;}

.two-columns .option_hover:nth-child(odd) {transform-origin: left;}

.three-columns .option_hover:nth-child(3n + 1) {transform-origin: left;}

.three-columns .option_hover:nth-child(3n + 2) {transform-origin: center;}

.three-columns .option_hover:nth-child(3n) {transform-origin: right;}

.vuecal__cell-date {
  color: #ccc;
  background: blue;
  border-radius: 50%;
  width: 1.8rem;
  height: 1.8rem;
  font-size: 1.2rem;
  padding-top: 2.5px;
  font-family: 'Oleo Script', cursive;
  display: flex;
  align-items: center;
  justify-content: center;
}
.vuecal__cell--before-min .vuecal__cell-content .vuecal__cell-date{
  color: #ccc; 
  background: rgb(144, 0, 0);
  font-weight: 400;
  font-size: 1rem;
}

.selected-range {
  background: rgba(0, 150, 136, 0.8);
  border: 3px solid #009688;
  color: rgb(104, 252, 104);
}

/* .vuecal__cell-events-count{display: none;} */
/* .vuecal__cell--selected {;} */
/* .vuecal__cell--out-of-scope{;} */
/* .vuecal__cell--disabled {;} */
</style>

<style scoped>
.hide-scrollbar::-webkit-scrollbar {display: none;}
.hide-scrollbar {scrollbar-width: none;}
.hide-scrollbar {-ms-overflow-style: none;}
</style>