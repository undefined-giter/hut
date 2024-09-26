<template>
    <div>
        <p class="!text-green-400 text-right mr-1.5 -mt-">Total : {{ totalPriceDisplay }}<span class="text-sm">€</span></p>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';

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

const PRICE_PER_NIGHT = 160;
const PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS = 120;

const totalPrice = ref(0);
const totalPriceDisplay = ref('');

const calculateTotalPrice = () => {
    const customPrice = props.resNights > 1 ? PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS : PRICE_PER_NIGHT;
    const optionPrices = props.resOptions.map(option => parseFloat(option.price) || 0);

    totalPrice.value = optionPrices.reduce((accumulator, currentValue) => {
        return accumulator + currentValue;
    }, props.resNights * customPrice);

    totalPriceDisplay.value = totalPrice.value % 1 === 0 ? totalPrice.value.toFixed(0) : totalPrice.value.toFixed(2);
};

watch([() => props.resNights, () => props.resOptions], calculateTotalPrice);

calculateTotalPrice();
</script>
