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
    }
});

const emit = defineEmits(['price-updated']);

const PRICE_PER_NIGHT = ref(160);
const PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS = ref(120);

const totalPrice = ref(0);
const totalPriceDisplay = ref('');

const fetchPrices = async () => {
    try {
        const response = await axios.get('/get-prices');        
        PRICE_PER_NIGHT.value = response.data.PRICE_PER_NIGHT;
        PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS.value = response.data.PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS;

        calculateTotalPrice();
    } catch (error) {
        console.error('Erreur lors de la récupération des prix :', error);

        calculateTotalPrice(); // Continue with this defaults values instead of breaking the run
    }
};

const calculateTotalPrice = () => {
    const night_price = props.resNights > 1 ? PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS.value : PRICE_PER_NIGHT.value;
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

onMounted(() => {
    fetchPrices();
});
</script>
