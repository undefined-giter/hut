<template>
  <Layout>
    <Head title="Réserver | Cabane" />
    
    <h1>Réservez Votre Bonheur !</h1>

    <div class="mb-6">
      <p class="mb-6 text-lg text-justify">Bienvenue dans notre cabane de luxe située au cœur de la nature. Offrez-vous un séjour inoubliable dans une cabane équipée d'un <strong>jacuzzi privatif</strong>, parfaite pour un moment de détente loin du stress quotidien. Profitez d'une <strong>vue à couper le souffle</strong> tout en étant entouré par la beauté de la nature. Notre cabane est idéale pour une <strong>escapade romantique</strong>, un week-end détente ou encore une petite pause bien méritée.
        <br><span class="underline">Partique :</span> Dégustez un bon repas parmis les restaurants ou prennez une pizza dans l'un des deux camions de pizza à proximité.</p>
  
      <p class="text-lg text-justify">Vous avez le choix entre une <strong>location pour une nuit</strong> ou plusieurs nuits pour un séjour prolongé. Nos <strong>tarifs</strong> s'adaptent en fonction de la durée de votre séjour : <strong>{{ PRICE_PER_NIGHT }}€/nuit</strong> pour une nuit et <strong>{{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€/nuit</strong> pour les séjours de deux nuits ou plus. <strong>Le parking est inclus</strong> pour toute réservation.</p>
    </div>

    <h2>Nos Services Offerts</h2>
    <div class="max-w-xl mx-auto text-left mb-6">
      <ul class="ml-20 md:ml-36 list-disc list-inside">
        <p>
          <li>Accès à un jacuzzi privatif chauffé</li>
          <li>Vue panoramique sur la nature environnante</li>
          <li>Petit déjeuner livré à la cabane (en option)</li>
          <li>Parking gratuit et sécurisé</li>
          <li>Wi-Fi inclus</li>
        </p>
      </ul>
    </div>

    <h2>Ce que disent nos clients</h2>
    <div class="mb-6">
      <p class="italic">"Un endroit incroyable pour se ressourcer. Le jacuzzi avec vue sur les montagnes est tout simplement magique !" — <strong>Marie et Julien</strong></p>
      <p class="italic mt-2">"Nous avons passé un week-end inoubliable. La cabane est magnifique et le service est impeccable. Nous reviendrons !" — <strong>Sophie et Thomas</strong></p>
    </div>

    <div class="flex justify-between">
      <p class="text-lg">Location pour une nuit : {{ PRICE_PER_NIGHT }}€, location par nuit pour 2 nuits et plus : {{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€.</p>
      <p class="text-lg">Parking inclus</p>
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

    <form method="POST" id="reservationForm" :action="reservationEdit ? `/book/${reservationEdit.id}/update` : '/book'"  @submit.prevent="handleSubmit">
      <input type="hidden" name="_token" :value="usePage().props.csrf_token" />
      <input type="hidden" name="start_date" :value="arrivalDate ? arrivalDate.toISOString().split('T')[0] : ''" />
      <input type="hidden" name="end_date" :value="departureDate ? departureDate.toISOString().split('T')[0] : ''" />
      <input type="hidden" name="nights" :value="numberOfNights" />
      <input type="hidden" name="res_comment" :value="res_comment" />
      <input type="hidden" name="options" :value="JSON.stringify(selectedOptionsObjects)" />
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

      <h3 v-if="options.length >= 1" class="underline text-blue-700 dark:text-blue-500 text-xl mt-4">Options disponibles :</h3>
      <div v-if="options.length >= 1" :class="gridClass" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3  min-h-[158px] max-h-[450px] overflow-y-auto shadow-sm overflow-x-hidden" :style="{ padding: `2px ${gridClass === 'one-column' ? '5px' : '0'}`,
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

          <label v-if="option.by_day_display" class="cursor-pointer absolute bottom-1.5 right-2 flex items-center space-x-0.5">
            <span class="text-sm absolute right-12 w-[60px] flex text-gray-800 mirza font-semibold -mr-2 -mt-1">Par jour ?</span>
            <input type="checkbox" 
              v-model="option.by_day" 
              @change="handleOptionChange(option)" 
              class="sr-only peer" 
              :disabled="!selectedOptionsIds.includes(option.id)" 
            />
            <div class="w-11 h-6 bg-gray-600 rounded-full peer peer-checked:after:translate-x-full after:content-[''] 
              after:absolute after:top-[2px] after:left-[4px] peer-checked:bg-green-800 peer-checked:after:bg-green-300 
              after:bg-gray-300 peer-checked:before:bg-green-800 after:rounded-full after:h-5 after:w-5 after:transition-all border border-black border-[1.5px]"
            ></div>
          </label>
        </label>
      </div>
      <div class="flex">
        <div class="flex-1 mr-4 relative max-w-[840px]">
          <label for="res_comment">Demande spéciale</label>
          <textarea id="res_comment" v-model="res_comment" maxlength="510" cols="2" :placeholder="resCommentPlaceholder" class="w-full -mt-0.5 no-scrollbar"></textarea>
          <p v-if="res_comment" :class="['absolute top-3.5 right-3.5', resCommentLength > 510 ? '!text-red-700' : '']">{{ resCommentLength }}/510<small> caractères</small></p>
        </div>
        <div class="ml-auto mt-auto mb-1">
          <Price @price-updated="updateCalculatedPrice"  :resNights="numberOfNights" :resOptions="selectedOptionsObjects" class="mb-3" />
          <button
            type="submit"
            form="reservationForm"
            :disabled="!isReservationValid || resCommentLength > 510"
            :class="[
              (!isReservationValid || resCommentLength > 510) ? '!bg-gray-600 hover:text-gray-400 opacity-75 cursor-not-allowed' : '', 
              'btn ml-auto block'
            ]">
            {{ reservationEdit ? 'Modifier' : 'Réserver' }}
          </button>
        </div>
      </div>
      <div v-if="isSubmitting" class="fixed inset-0 flex items-center justify-center z-50">
        <div class="animate-spin rounded-full h-12 w-12 border-t-4 border-orangeTheme"></div>
      </div>
    </form>
      
    
    <div v-if="sortedReservations.length > 0" class="mt-4 shadow-sm">
      <h3 class="underline text-red-600 text-xl -mb-2">Nuits déjà réservées :</h3>
      <div style="max-height: 350px; overflow-y: auto; padding-left:2px;">
        <p><li v-for="(reservation, index) in sortedReservations" :key="index" :class="{'dark:text-gray-200 my-2': index % 2 === 0, '!text-blue-500': index % 2 !== 0}">
          <span v-html="formatDateShort(new Date(reservation.start_date)) + ' - ' + formatDateShort(new Date(reservation.end_date))"></span> :
          <span v-html="'Du ' + formatDate(new Date(reservation.start_date)) + ' au ' + formatDate(new Date(reservation.end_date)) + ' pour ' + reservation.nights + ' nuit' + (reservation.nights > 1 ? 's ' : ' ')"></span>
          <span v-if="auth && auth.user && auth.user.id === reservation.user_id">
            <Link :href="route('profile', reservation.user_id)" class="text-blue-600">
              <span class="text-sm">🟢</span><span v-if="auth && auth.user && auth.user.role !== 'admin'">La vôtre</span>
            </Link>
          </span>
          <span v-if="auth && auth.user && auth.user.role === 'admin'">
            => <form method="POST" :action="route('book.delete', reservation.id)" style="display:inline;" @submit.prevent="confirmDelete">
                <input type="hidden" name="_token" :value="usePage().props.csrf_token" />
                <input type="hidden" name="_method" value="DELETE" />
                <button type="submit" class="text-red-600"><span class="text-xs">❌</span>Annuler</button>
            </form>
            <span class="text-zinc-800 text-sm"> | </span> 
            <Link :href="route('admin.details', reservation.user_id)"><span class="text-xs">➡️</span><span class="text-blue-700">Profil</span></Link>
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

const { auth, reservations, options, reservationEdit, showMonthEdit, PRICE_PER_NIGHT, PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS,
  in_date, inner_date, out_date, switch_date, 
  user_in_date, user_inner_date, user_out_date, user_switch_date, user_switch_to_other, other_switch_to_user,
  edit_reservation_dates = []  } = usePage().props;

const arrivalDate = ref(null);
const departureDate = ref(null);
const showMonth = ref(showMonthEdit ?? null);
const dateError = ref(null);
const numberOfNights = ref(0);
const res_comment = ref('');
const resCommentPlaceholder = "Bonjour,\nN'hésitez pas à partager plus de précisions afin que nous préparions au mieux votre séjour\nComme votre heure d'arrivée envisagée, etc.";
const isReservationValid = ref(reservationEdit ? true : false);
const csrfToken = ref(null);
const today = new Date();
const selectedOptionsObjects = ref([]);  
const selectedOptionsIds = ref([]);  
const calculatedPrice = ref(0);
const gridClass = ref('three-columns');
const isScrollbarVisible = ref(false);
const isSubmitting = ref(false);
const previousAuthUser = ref(null);


onMounted(() => {
  if (Array.isArray(options)) {
    options.forEach(option => {
      if (reservationEdit) {
        const editedOption = reservationEdit.options.find(resOption => resOption.id === option.id);
        if (editedOption) {
          option.by_day = editedOption.pivot.by_day ? true : false;
        } else {
          option.by_day = option.by_day_preselected == 1;
        }
      } else {
        option.by_day = option.by_day_preselected == 1;
      }
    });

    selectedOptionsObjects.value = options.filter(option => option.preselected || (reservationEdit && reservationEdit.options.some(resOption => resOption.id === option.id)));
    selectedOptionsIds.value = selectedOptionsObjects.value.map(option => option.id);

    if (reservationEdit) {
      arrivalDate.value = new Date(reservationEdit.start_date);
      departureDate.value = new Date(reservationEdit.end_date);
      numberOfNights.value = reservationEdit.nights;
      if (reservationEdit.res_comment) {
        res_comment.value = reservationEdit.res_comment;
      }
    }
  }

  csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
  previousAuthUser.value = auth.user;

  window.addEventListener('resize', updateGridClass);
  updateGridClass();
});

watch(
  () => usePage().props.auth.user,
  (newUser, oldUser) => {
    if (!previousAuthUser.value && newUser) {
      window.location.reload();
    }
    previousAuthUser.value = newUser;
  }
);

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
  }) + ` <span class="text-xs">${date.getFullYear()}</span>`;
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

const updateCalculatedPrice = (price) => {
  calculatedPrice.value = price;
};

const handleSubmit = async () => {
  isSubmitting.value = true;

  try {
    await new Promise((resolve) => setTimeout(resolve, 4000));
    document.getElementById('reservationForm').submit();
  } catch (error) {
    console.error('Erreur lors de la soumission du formulaire', error);
  } finally {
  }
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

<style scoped>
.hide-scrollbar::-webkit-scrollbar {display: none;}
.hide-scrollbar {scrollbar-width: none;}
.hide-scrollbar {-ms-overflow-style: none;}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.animate-spin {animation: spin 1s linear infinite;}
</style>