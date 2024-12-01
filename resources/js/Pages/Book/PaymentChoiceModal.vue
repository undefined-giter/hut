<template>
    <div class="fixed inset-0 bg-light dark:bg-dark bg-opacity-75 flex justify-center items-center z-50" @click="closeModal">
    
        <div class="relative bg-orangeTheme rounded-lg shadow-xl w-[90%] max-w-lg p-6 text-center text-white" @click.stop>
    
            <h3 class="text-2xl font-bold mb-4 font-kalnia underline">Choisissez votre méthode de paiement</h3>

            <p class="text-sm mb-6 font-kalnia !text-black">Réservez en toute simplicité avec le choix qui vous convient le mieux</p>

            <p class="text-left ml-2 !text-black">Réserver Immédiatement :</p>
            <button @click.prevent="payLater" class="btn w-full mb-4">Payer à l'arrivée, <b>en liquide</b> les {{ calculatedPrice }} €</button>
            
            <p class="text-left ml-2 !text-black">Passer au Payement avec Stripe :</p>
            <button @click.prevent="payNow" class="btn w-full">Payer par Carte</button>
            
            <button @click="closeModal" class="absolute top-1 right-2 text-white text-2xl font-bold hover:text-gray-300">&times;</button>
        </div>

        <div v-if="isSubmitting" class="fixed inset-0 flex items-center justify-center z-50">
          <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-green-600"></div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';

const isSubmitting = ref(false);

defineProps({
    calculatedPrice: Number,
    required: true,
    validator: (value) => !isNaN(value),
});

const emit = defineEmits(['close', 'payNow', 'payLater']);

const payLater = () => {
    isSubmitting.value = true
    emit('payLater');
};

const payNow = () => {
    isSubmitting.value = true
    emit('payNow');
};

const closeModal = () => {
    emit('close');
};
</script>
