<template>
  <Layout>
    <Head title="Réservez Votre Bonheur | Cabane" />
    
    <h1>Réservez Votre Bonheur !</h1>

    <TextRes :PRICE_PER_NIGHT="PRICE_PER_NIGHT" :PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS="PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS" :PERCENT_REDUCED_WEEK="PERCENT_REDUCED_WEEK" />
    
    <vue-cal
      locale="fr"
      active-view="month"
      class="vuecal--rounded-theme vuecal--blue-theme communFont"
      hide-view-selector
      @cell-click="handleDateClick"
      :disable-views="['years', 'year', 'week', 'day']"
      :dblclick-to-navigate="false"
      style="height:400px;"
      :min-date="minDateDynamic"
      :max-date="maxDate"
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
              const cellDate = new Date(cell.formattedDate);
              const maxDateObj = new Date(maxDate);
              const minDateDynamicObj = new Date(minDateDynamic);

              if (cellDate < minDateDynamicObj || cellDate > maxDateObj) {
                return 'background: darkred;';
              }

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
                return 'background: linear-gradient(to right, green, green, green, green, #410045, darkred, darkred, darkred, darkred);';
              } else if (otherSwitchToUser) {
                return 'background: linear-gradient(to right, darkred, darkred, darkred, darkred, #410045, green, green, green, green);';
              }

              switch (result) {
                  case 'in':
                    return 'background: linear-gradient(to right, blue, blue, blue, blue, darkred, darkred, darkred, darkred);';
                  case 'inner':
                    return 'background: darkred;';
                  case 'out':
                    return 'background: linear-gradient(to right, darkred, darkred, darkred, darkred, blue, blue, blue, blue);';
                  case 'switch':
                    return auth.user.role === 'admin' 
                        ? 'background: linear-gradient(to right, darkred, darkred, darkred, #2c006c, darkred, darkred, darkred);' 
                        : 'background: darkred;';
                default:
                  return '';
              }
          })()">
          {{ cell.content }}
        </span>
      </template>
    </vue-cal>

    <form method="POST" id="reservationForm" :action="formAction">
      <input type="hidden" name="_token" :value="csrfToken" />
      <input type="hidden" name="start_date" :value="arrivalDate ? arrivalDate.toISOString().split('T')[0] : ''" />
      <input type="hidden" name="end_date" :value="departureDate ? departureDate.toISOString().split('T')[0] : ''" />
      <input type="hidden" name="res_comment" :value="res_comment" />
      <input type="hidden" name="options" :value="JSON.stringify(selectedOptionsObjects)" />

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
        </div>
        <button type="button" :class="`${arrivalDate ? '' : 'btn-disabled'} btn text-sm bg-orangeTheme !hover:text-orangeTheme !shadow-none !px-2 mr-0.5`" @click="resetReservation">Réinitialiser<br>les Dates</button>
      </div>

      <h3 v-if="options.length >= 1" class="underline text-blue-700 dark:text-blue-500 text-xl mt-4">Options disponibles :</h3>
      <div v-if="options.length >= 1" :class="[gridClass, 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3  min-h-[324px] max-h-[450px] overflow-y-auto shadow-sm overflow-x-hidden']" :style="{ padding: `2px ${gridClass === 'one-column' ? '5px' : '0'}`,
        paddingRight: isScrollbarVisible && gridClass == 'one-column' ? '7px' : isScrollbarVisible ? '1px' : '0'}">
        <label v-for="(option, index) in options" :key="option.id"
        :class="[selectedOptionsIds.includes(option.id) ? 'dark:bg-green-600 border border-green-600' : 'dark:bg-orange-500 border border-orange-600', 'relative h-[154px] option_hover p-3.5 border border-2 rounded-md shadow-sm cursor-pointer duration-300 transform hover:z-10']">
          <div class="flex items-center">
            <input type="checkbox" :value="option.id" v-model="selectedOptionsIds" class="mr-1 -mt-4 form-checkbox"/>
            <div class="flex justify-between w-full max-w-[98%]">
              <div :title="option.name.length >= 25 ? option.name : ''"
              class="text-2xl font-bold whitespace-nowrap overflow-hidden text-ellipsis -mt-1">{{ option.name }}</div>
              <div v-if="option.price !== null && option.price !== '' && option.price !== '0.00'" class="-mt-1">
                &nbsp;{{ option.price.endsWith('.00') ? parseInt(option.price) : option.price }}<small>&nbsp;€</small>
              </div>
              <div v-if="option.price === '0.00'" class="-mt-2">Inclu</div>
            </div>
          </div>

          <p :class="selectedOptionsIds.includes(option.id) ? 'text-green-700 dark:text-gray-200 break-words' : 'text-orange-600 dark:text-gray-200 break-words'" class="mb-0.5 overflow-y-scroll max-h-[80px] whitespace-pre-wrap hide-scrollbar">
            {{ option.description }}
          </p>

          <div class="absolute bottom-1 right-4 flex items-center space-x-1">
            <span v-if="option.by_day_display" :class="[selectedOptionsIds.includes(option.id) && !option.by_day ? 'underline underline-offset-2' : '', 'mirza font-bold']" title="1 unité pour l'entièreté du séjour / bouton gris">1 pour le séjour</span>
            <label v-if="option.by_day_display" class="cursor-pointer flex items-center">
              <input type="checkbox" 
                v-model="option.by_day" 
                @change="handleOptionChange(option)" 
                class="sr-only peer hover:scale-105" 
                :disabled="!selectedOptionsIds.includes(option.id)"
              />
              <div :class="[selectedOptionsIds.includes(option.id) ? 'hover:scale-105 hover:bg-gray-500' : '!border-purple-800', option.by_day ? 'hover:scale-105 hover:bg-gray-500 border-green-500' : 'border-orangeTheme', `w-11 h-6 bg-gray-600 rounded-full relative peer peer-checked:after:translate-x-[20px] after:content-[''] after:absolute peer-checked:bg-green-800 peer-checked:after:bg-green-300 after:bg-gray-400 after:rounded-full after:h-5 after:w-5 after:transition-all border border-[2px] peer-checked:hover:bg-green-900 transition-transform duration-300`]"></div>
            </label>
            <span v-if="option.by_day_display" title="1 par nuit réservée / bouton vert
(distribué en journée si applicable pour l'option)" :class="[option.by_day ? 'underline underline-offset-2' : '', 'mirza font-semibold']">Par jour</span>
          </div>
        </label>
      </div>

      <div class="flex mx-1">
        <div class="flex-1 mr-4 mt-2 relative max-w-[230px] sm:max-w-[840px]">
          <label for="res_comment" class="communFont">Demande spéciale</label>
          <p v-if="res_comment" :class="['absolute right-2 top-5', resCommentLength > 510 ? '!text-red-700' : '']">{{ resCommentLength }}/510<small> caractères</small></p>
          <textarea id="res_comment" v-model="res_comment" maxlength="510" rows="4" :placeholder="animatedText" class="w-full no-scrollbar rounded-tl-2xl rounded-tr-2xl rounded-br-none rounded-bl-2xl"></textarea>
        </div>
        <div class="flex flex-col items-center ml-auto">
          <Price
            @price-updated="updateCalculatedPrice" 
            :arrivalDate="arrivalDate" 
            :departureDate="departureDate" 
            :resNights="numberOfNights" 
            :resOptions="selectedOptionsObjects" 
            :PRICE_PER_NIGHT="PRICE_PER_NIGHT" 
            :PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS="PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS" 
            :PERCENT_REDUCED_WEEK="PERCENT_REDUCED_WEEK" 
            :specialDatesPricesArray="specialDatesPricesArray"
            :res_payed="res_payed"
          />
          <button
            type="button"
            :disabled="!isReservationValid || resCommentLength > 510"
            :class="[(!isReservationValid || resCommentLength > 510) ? 'btn-disabled cursor-not-allowed' : '', 'btn block !p-12 !font-bold text-2xl']"
            @click="openPayementChoiceModal = true"
          >
            {{ reservationEdit ? 'Modifier' : 'Réserver' }}
          </button>

          <PaymentChoiceModal v-if="openPayementChoiceModal" 
            @payLater="submitPayLater"
            @payNow="submitPayNow"
            @close="openPayementChoiceModal = false" 
            :calculatedPrice="calculatedPrice"
          />

        </div>
      </div>
    </form>
    
    <div class="mt-8">
      <div class="hidden md:block">
        <div class="flex justify-evenly">
          <h3 @click="toggleUnroll(6)" class="underline text-xl text-orangeTheme cursor-pointer">{{ isUnrolled(6) ? 'Cacher' : 'Afficher' }} les dates & prix spéciaux<span :class="[isUnrolled(6) ? 'triangle-up' : 'triangle-down', '!text-orangeTheme mb-1']"></span></h3>
          <h3 @click="toggleUnroll(0)" class="underline !text-red-600 text-xl cursor-pointer">{{ isUnrolled(0) ? 'Cacher' : 'Afficher' }} les nuits déjà réservées<span :class="[isUnrolled(0) ? 'triangle-up' : 'triangle-down', '!text-red-600 mb-1 decoration-none']"></span></h3>
        </div>
        
        <div :class="['flex', isUnrolled(0) && isUnrolled(6) ? 'justify-end mr-6' : '']">
          <ListSpecials v-show="isUnrolled(6)" :class="[isUnrolled(0) ? '' : 'ml-[18%]']" />
          <ListsRes v-show="isUnrolled(0)" :reservations="reservations" :auth="auth" :formatDate="formatDate" :class="['transition-all duration-300', !isUnrolled(6) ? 'ml-auto mr-8' : '']" />
        </div>
      </div>

      <div class="flex flex-col md:hidden">
        <div class="mx-auto">
          <h3 @click="toggleUnroll(6)" class="underline text-center text-xl !text-orangeTheme cursor-pointer">{{ isUnrolled(6) ? 'Cacher' : 'Afficher' }} les dates & prix spéciaux<span :class="[isUnrolled(6) ? 'triangle-up' : 'triangle-down', '!text-orangeTheme mb-1']"></span></h3>
          <ListSpecials v-show="isUnrolled(6)" class="transition-all duration-300" />
        </div>

        <div class="mt-4 mx-auto">
          <h3 @click="toggleUnroll(0)" class="underline text-center !text-red-600 text-xl cursor-pointer">{{ isUnrolled(0) ? 'Cacher' : 'Afficher' }} les nuits déjà réservées<span :class="[isUnrolled(0) ? 'triangle-up' : 'triangle-down', '!text-red-600 mb-1 decoration-none']"></span></h3>
          <ListsRes v-show="isUnrolled(0)" :reservations="reservations" :auth="auth" :formatDate="formatDate" class="transition-all duration-300" />
        </div>
      </div>
    </div>
  </Layout>

  <PhoneModal v-if="showPhoneModal" />
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed, watch } from 'vue';
import { Head, usePage } from '@inertiajs/vue3';
import { useUnroll } from '../../shared/utils';
import PhoneModal from './../Components/PhoneModal.vue';
import PaymentChoiceModal from './PaymentChoiceModal.vue';
import Price from './Price.vue';
import TextRes from './TextRes.vue';
import ListsRes from './ListsRes.vue';
import ListSpecials from './ListSpecials.vue';
import Layout from './../Layout.vue';
import 'vue-cal/dist/vuecal.css';
import VueCal from 'vue-cal';

const { csrf_token, auth, reservations, options, showMonthEdit, PRICE_PER_NIGHT, PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS, PERCENT_REDUCED_WEEK, specialDatesPricesArray,
  in_date, inner_date, out_date, switch_date, 
  user_in_date, user_inner_date, user_out_date, user_switch_date, user_switch_to_other, other_switch_to_user,
  minDate, maxDate,
  edit_reservation_dates = [], reservationEdit = false } = usePage().props;

const arrivalDate = ref(null);
const departureDate = ref(null);
const numberOfNights = ref(0);
const res_comment = ref('');
const animatedText = ref('');
const resCommentPlaceholder = "Bonjour,\nN'hésitez pas à partager plus de précisions afin que nous préparions au mieux votre séjour.\nComme votre heure d'arrivée envisagée, ou autres informations pertinantes.";
const isReservationValid = ref(reservationEdit ? true : false);
const csrfToken = computed(() => csrf_token);
const selectedOptionsObjects = ref([]);  
const selectedOptionsIds = ref([]);  
const calculatedPrice = ref(0);
const gridClass = ref('three-columns');
const isScrollbarVisible = ref(false);
const openPayementChoiceModal = ref(false);
const formAction = ref(null);
const res_payed = ref(parseFloat(reservationEdit.res_payed) || 0)

const today = new Date();
const todayStr = today.getFullYear() + '-' +
                 String(today.getMonth() + 1).padStart(2, '0') + '-' +
                 String(today.getDate()).padStart(2, '0');

const minDateDynamic = ref(
    minDate < todayStr
        ? todayStr 
        : minDate
);

const showMonth = ref(showMonthEdit ?? minDateDynamic.value);

const { isUnrolled, toggleUnroll } = useUnroll();

onMounted(() => {
  if (Array.isArray(options)) {
    options.forEach(option => {
      if (reservationEdit) {
        const editedOption = reservationEdit.options.find(resOption => resOption.id === option.id);
        if (editedOption) {
          selectedOptionsIds.value.push(option.id);
          option.by_day = editedOption.pivot.by_day ? true : false;
        } else {
          option.by_day = option.by_day_preselected == 1 && selectedOptionsIds.value.includes(option.id);
        }
      } else {
        if (option.preselected) {
          selectedOptionsIds.value.push(option.id);
        }
        option.by_day = option.preselected && option.by_day_preselected == 1;
      }
    });

    selectedOptionsObjects.value = options.filter(option => selectedOptionsIds.value.includes(option.id));

    if (reservationEdit) {
      arrivalDate.value = new Date(reservationEdit.start_date);
      arrivalDate.value.setHours(23, 59, 59, 999);
      departureDate.value = new Date(reservationEdit.end_date);
      departureDate.value.setHours(23, 59, 59, 999);
      numberOfNights.value = reservationEdit.nights;
      if (reservationEdit.res_comment) {
        res_comment.value = reservationEdit.res_comment;
      }
    }
  }

  window.addEventListener('resize', updateGridClass);
  updateGridClass();
  displayPhoneModalAfterDelay();
  animateText(resCommentPlaceholder, 50);  
});


watch(selectedOptionsIds, (newSelectedIds, oldSelectedIds) => {
  const updatedOptions = options.filter(option => newSelectedIds.includes(option.id));
  
  if (JSON.stringify(updatedOptions) !== JSON.stringify(selectedOptionsObjects.value)) {
    selectedOptionsObjects.value = updatedOptions;
  }
  
  options.forEach(option => {
    if (newSelectedIds.includes(option.id)) {
      if (!oldSelectedIds.includes(option.id)) {
        const editedOption = reservationEdit ? reservationEdit.options.find(resOption => resOption.id === option.id) : null;
        if (editedOption) {
          option.by_day = editedOption.pivot.by_day ? true : false;
        } else {
          option.by_day = option.by_day_preselected == 1;
        }
      }
    } else {
      option.by_day = false;
    }
  });
});

const handleOptionChange = (option) => {
  if (selectedOptionsIds.value.includes(option.id)) {
    selectedOptionsObjects.value = options.filter(opt => selectedOptionsIds.value.includes(opt.id));
  }
};

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

const resCommentLength = computed(() => {
  return res_comment.value.replace(/\r?\n/g, '  ').length;
});

const handleDateClick = (cell) => {
  const selectedDate = new Date(cell);
  selectedDate.setHours(23, 59, 59, 999);

  if (!arrivalDate.value) {
    arrivalDate.value = selectedDate;
    departureDate.value = null;
    numberOfNights.value = 0;
    isReservationValid.value = false;
  } else if (selectedDate <= arrivalDate.value) {
    if(selectedDate <= minDateDynamic){
      resetReservation();
    }else{
      arrivalDate.value = selectedDate;
      const timeDiff = departureDate.value.getTime() - arrivalDate.value.getTime();
      numberOfNights.value = Math.floor(timeDiff / (1000 * 3600 * 24));
    }
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
  numberOfNights.value = 0;
  isReservationValid.value = false;
  if(document.querySelector('.vuecal__cell--selected')){
    document.querySelector('.vuecal__cell--selected').classList.remove('vuecal__cell--selected')
  }
};

const formatDate = (date) => {
  return date.toLocaleDateString('fr-FR', {
    weekday: 'long',
    month: 'long',
    day: 'numeric',
  }) + ` <span class="text-xs">${date.getFullYear()}</span>`;
};

const showPhoneModal = ref(false);
const displayPhoneModalAfterDelay = () => {
  setTimeout(() => {
    showPhoneModal.value = true;
  }, 6000);
};

const animateText = (text, delay = 50) => {
  animatedText.value = '';
  let index = 0;

  const interval = setInterval(() => {
    if (index < text.length) {
      animatedText.value += text[index];
      index++;
    } else {
      clearInterval(interval);
    }
  }, delay);
};

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

const updateCalculatedPrice = (price) => {
  calculatedPrice.value = price;
};


const submitPayLater = () => {
    formAction.value = reservationEdit 
        ? route('book.update', { id: reservationEdit.id })
        : route('book.store');    

    setTimeout(() => {
      document.getElementById('reservationForm').submit();
    }, 10);
};

const submitPayNow = () => {
    formAction.value = reservationEdit 
        ? route('payment.show', { id: reservationEdit.id })
        : route('payment.show');

    setTimeout(() => {
      document.getElementById('reservationForm').submit();
    }, 10);
}


onUnmounted(() => {
  window.removeEventListener('resize', updateGridClass);
});
</script>
