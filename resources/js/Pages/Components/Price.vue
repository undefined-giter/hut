<template>
    <p class="!text-green-500 mt-1 -mb-1">Total : {{ totalPriceDisplay }}<span class="text-sm">€</span></p>
</template>

<script setup>
import { ref, watch } from 'vue';

const props = defineProps({
    arrivalDate: {
        type: Date,
    },
    departureDate: {
        type: Date,
    },
    resNights: {
        type: Number,
        default: 1,
    },
    resOptions: {
        type: Array,
        default: () => []
    },
    PRICE_PER_NIGHT: {
        type: Number,
        default: 160,
    },
    PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS: {
        type: Number,
        default: 120,
    },
    PERCENT_REDUCED_WEEK: {
        type: Number,
        default: 10,
    },
    specialDatesPricesArray: {
        type: Array,
        default: [],
    }
});

const emit = defineEmits(['price-updated']);

const totalPrice = ref(0);
const totalPriceDisplay = ref('');

let specialDate = []
for (let i = 0; i < props.specialDatesPricesArray.length; i++) {
    specialDate.push(props.specialDatesPricesArray[i].spe_date)
}


const generateSelectedDates = (arrivalDate, departureDate) => {

    const dateArray = [];
    const startDate = new Date(arrivalDate);
    const endDate = new Date(departureDate);

    while (startDate < endDate) {
        dateArray.push(startDate.toISOString().split('T')[0]);
        
        startDate.setDate(startDate.getDate() + 1);
    }

    return dateArray
};


const calculateTotalPrice = () => {

    const dateArray = generateSelectedDates(props.arrivalDate, props.departureDate);

    let nbNightOnSpecialPrice = 0;
    for (let i = 0; i < props.specialDatesPricesArray.length; i++){
        if (dateArray.includes(props.specialDatesPricesArray[i].spe_date)){
            console.log(props.specialDatesPricesArray[i].spe_date, props.specialDatesPricesArray[i].spe_price);
            nbNightOnSpecialPrice++
        }
    }

    const night_price = (props.resNights + nbNightOnSpecialPrice) > 1 ? props.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS : props.PRICE_PER_NIGHT;
    totalPrice.value = props.resNights * night_price;

    const dayIndexReserved = [];

    for (let date = new Date(props.arrivalDate); date <= new Date(props.departureDate) - 1; date.setDate(date.getDate() + 1)) {
        dayIndexReserved.push(date.getDay());
    }

    const dayReducedBooked = dayIndexReserved.filter(day => ![0, 5, 6].includes(day));

    if (props.arrivalDate && props.departureDate) {
        if (props.resNights === 1 && dayReducedBooked.length > 0) {
            totalPrice.value -= (props.PRICE_PER_NIGHT * (props.PERCENT_REDUCED_WEEK / 100));
        } else {
            let reduceAmount = (dayReducedBooked.length * props.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS * props.PERCENT_REDUCED_WEEK) / 100;
            totalPrice.value -= reduceAmount;
        }
    }

    const optionPrices = props.resOptions.map(option => {
        const optionPrice = parseFloat(option.price) || 0;
        return option.by_day ? optionPrice * (props.resNights === 0 ? 1 : props.resNights) : optionPrice;
    });

    totalPrice.value += optionPrices.reduce((accumulator, currentValue) => accumulator + currentValue, 0);
    totalPriceDisplay.value = totalPrice.value % 1 === 0 ? totalPrice.value.toFixed(0) : totalPrice.value.toFixed(2);

    emit('price-updated', totalPrice.value);
};


watch([
    () => props.resNights, 
    () => props.resOptions,
    () => props.arrivalDate,
    () => props.departureDate,
    ], calculateTotalPrice);
</script>
