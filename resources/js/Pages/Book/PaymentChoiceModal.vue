<template>
    <div class="fixed inset-0 bg-light dark:bg-dark bg-opacity-75 flex justify-center items-center z-50" @click="closeModal">
    
        <div class="relative bg-orangeTheme rounded-lg shadow-xl w-[90%] max-w-lg p-6 text-center text-white" @click.stop>
    
            <h2 class="text-2xl font-bold mb-4 font-kalnia">Choisissez votre méthode de paiement</h2>

            <p class="text-sm mb-6 font-kalnia !text-black">Réservez en toute simplicité avec le choix qui vous convient le mieux :</p>

            <button @click.prevent="payLater" class="btn w-full mb-4">Payer à l'arrivée, en liquide uniquement</button>
            
            <button @click.prevent="payNow" class="btn w-full">Payer Maintenant</button>
            
            <button @click="closeModal" class="absolute top-1 right-2 text-white text-2xl font-bold hover:text-gray-300">&times;</button>
        </div>
    </div>
</template>

<script setup>
const emit = defineEmits(['close', 'payNow', 'payLater']);

const payLater = () => {
    emit('payLater');
};

const payNow = () => {
    emit('payNow');
};

const closeModal = () => {
    emit('close');
};
</script>
