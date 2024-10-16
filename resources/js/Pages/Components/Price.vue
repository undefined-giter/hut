<template>
    <p class="!text-green-400 text-right mr-1.5 -mt-">Total : {{ totalPriceDisplay }}<span class="text-sm">€</span></p>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';

const props = defineProps({
    resNights: {
        type: Number,
        default: 1
    },
    resOptions: {
        type: Array,
        default: () => []
    },
    PRICE_PER_NIGHT: {
        type: Number,
        required: true
    },
    PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS: {
        type: Number,
        required: true
    },
});

const emit = defineEmits(['price-updated']);

const totalPrice = ref(0);
const totalPriceDisplay = ref('');

const calculateTotalPrice = () => {
    const night_price = props.resNights > 1 ? props.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS : props.PRICE_PER_NIGHT;
    const optionPrices = props.resOptions.map(option => {
        const optionPrice = parseFloat(option.price) || 0;
        return option.by_day ? optionPrice * (props.resNights == 0 ? 1 : props.resNights) : optionPrice;
    });

    totalPrice.value = optionPrices.reduce((accumulator, currentValue) => {
        return accumulator + currentValue;
    }, props.resNights * night_price);

    totalPriceDisplay.value = totalPrice.value % 1 === 0 ? totalPrice.value.toFixed(0) : totalPrice.value.toFixed(2);

    emit('price-updated', totalPrice.value);
};

watch([() => props.resNights, () => props.resOptions], calculateTotalPrice);
</script>
