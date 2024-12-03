<template>
<p class="!text-green-500 mt-1 -mb-1">
    Total : {{ totalPriceDisplay }} <span class="text-sm">€</span>
</p>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    arrivalDate: { type: Date },
    departureDate: { type: Date },
    resNights: { type: Number, default: 1 },
    resOptions: { type: Array, default: () => [] },
    PRICE_PER_NIGHT: { type: Number, default: 160 },
    PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS: { type: Number, default: 120 },
    PERCENT_REDUCED_WEEK: { type: Number, default: 10 },
    specialDatesPricesArray: { type: Array, default: () => [] },
    res_payed: {type: Number }
});

const emit = defineEmits(['price-updated']);

const totalPrice = ref(0);
const totalPriceDisplay = ref('');


const generateSelectedDates = (arrivalDate, departureDate) => {
    const dateArray = [];
    const startDate = new Date(arrivalDate);
    const endDate = new Date(departureDate);

    while (startDate < endDate) {
        dateArray.push(startDate.toISOString().split('T')[0]);
        startDate.setDate(startDate.getDate() + 1);
    }

    return dateArray;
};


const calculateSpecialPrices = (dateArray) => {
  let totalSpecialPrice = 0;
  let remainingDateArray = [...dateArray];

  props.specialDatesPricesArray.forEach(({ spe_date, spe_price }) => {
    const index = remainingDateArray.indexOf(spe_date);
    if (index !== -1) {
      totalSpecialPrice += parseFloat(spe_price);
      remainingDateArray.splice(index, 1);
    }
  });

  return { totalSpecialPrice, remainingDateArray };
};


const calculateRegularNightPrices = (regularDateArray, dateArray) => {
  let totalRegularPrice = 0;

  regularDateArray.forEach((date) => {
    const dayOfWeek = new Date(date).getDay();
    const isWeekend = [5, 6, 0].includes(dayOfWeek);

    if (dateArray.length === 1) {
      if (isWeekend) {
        totalRegularPrice += props.PRICE_PER_NIGHT;
      } else {
        totalRegularPrice += props.PRICE_PER_NIGHT - (props.PRICE_PER_NIGHT * props.PERCENT_REDUCED_WEEK) / 100;
      }
    } else {
      totalRegularPrice += isWeekend
        ? props.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS
        : props.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS -
          (props.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS * props.PERCENT_REDUCED_WEEK) / 100;
    }
  });

  return totalRegularPrice;
};


const calculateOptionsPrice = () => {
    return props.resOptions.reduce((total, option) => {
        const optionPrice = parseFloat(option.price) || 0;
        return total + (option.by_day ? optionPrice * Math.max(props.resNights, 1) : optionPrice);
    }, 0);
};


const calculateTotalPrice = () => {
  let basePrice = 0;

  if (props.arrivalDate && props.departureDate) {
    let dateArray = generateSelectedDates(props.arrivalDate, props.departureDate);

    const { totalSpecialPrice, remainingDateArray } = calculateSpecialPrices(dateArray);

    basePrice = totalSpecialPrice + calculateRegularNightPrices(remainingDateArray, dateArray);
  }

  const optionsPrice = calculateOptionsPrice();

  totalPrice.value = parseFloat(basePrice + optionsPrice - props.res_payed);

  totalPriceDisplay.value =
    totalPrice.value % 1 === 0 ? totalPrice.value.toFixed(0) : totalPrice.value.toFixed(2);

  emit('price-updated', totalPrice.value);
};


watch(
    [
      () => props.resNights,
      () => props.resOptions,
      () => props.arrivalDate,
      () => props.departureDate,
      () => props.specialDatesPricesArray,
    ],
    calculateTotalPrice
);
</script>
