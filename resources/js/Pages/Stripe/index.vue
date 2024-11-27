<template>
    <Head title="Stripe Paiement | Cabane" />

    <Layout>
        <div class="max-w-sm mx-auto p-4 my-2 bg-light dark:bg-dark rounded-lg">
            <h1 class="text-2xl font-bold text-center text-purple-700 underline mb-6">Paiement</h1>

            <div class="text-center text-lg font-medium text-gray-700 dark:text-gray-200 mb-6">
                <p class="mb-2">Cabane avec Jacuzzi et sa vue Panoramique</p>
                <p class="mb-2">Montant à payer : <strong class="text-green-600 text-xl">{{ total }} €</strong></p>
                <p>Du {{ formatDateShort(start_date) }} au {{ formatDateShort(end_date) }}</p>
                <p>Pour {{ nights }} nuit{{ nights > 1 ? 's' : '' }}</p>
                <div class="text-right mt-1 mb-3">
                    <div class="table w-full">
                        <div class="table-row">
                            <p class="table-cell text-right leading-tight">Nuit{{ nights > 1 ? 's' : '' }} :</p>
                            <p class="table-cell text-left leading-tight text-right">{{ nightsPrice % 1 === 0 ? nightsPrice : nightsPrice.toFixed(2) }} €</p>
                        </div>
                        <div class="table-row">
                            <p class="table-cell text-right leading-tight">Options :</p>
                            <p class="table-cell text-left leading-tight text-right">{{ optionsPrice % 1 === 0 ? optionsPrice : optionsPrice.toFixed(2) }} €</p>
                        </div>
                        <div class="table-row">
                            <p class="table-cell text-right leading-tight">Taxe de paiement par carte :</p>
                            <p class="table-cell text-left leading-tight text-right">{{ stripeTax % 1 === 0 ? stripeTax : stripeTax.toFixed(2) }} €</p>
                        </div>
                        <div class="table-row">
                            <p class="table-cell text-right font-bold text-green-600 leading-tight">Total :</p>
                            <p class="table-cell text-left font-bold text-green-600 text-xl leading-tight text-right">{{ total % 1 === 0 ? total : total.toFixed(2) }} €</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow-md mb-6">
                <h2 class="text-lg font-bold text-gray-800 dark:text-gray-200 mb-4">Informations de carte</h2>
                <div id="payment-element" class="mb-4"></div>
                <button
                    :disabled="isSubmitting || !stripeLoaded"
                    @click.prevent="submitPayment"
                    class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg shadow-md transition-colors duration-200"
                >
                    <i class="fas fa-lock mr-2"></i> Confirmer et Payer
                </button>
                <div v-if="stripeError" class="text-red-500 mt-2">{{ stripeError }}</div>
            </div>

            <button @click.prevent="payLater" class="btn ml-2 mt-2">Ou Payer En Liquide, À l'Arrivée</button>

            <div v-if="isSubmitting" class="fixed inset-0 flex items-center justify-center z-50">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-green-600"></div>
            </div>
        </div>
    </Layout>
</template>

<script setup>
import Layout from './../Layout.vue';
import { Head } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, onMounted } from 'vue';

let stripe = null;
let elements = null;
const stripeLoaded = ref(false);
const stripeError = ref(null);
const isSubmitting = ref(false);

const { 
    clientSecret,
    original_start_date, 
    original_end_date, 
    original_res_comment, 
    original_options,
    total,
} = defineProps({
    clientSecret: String,
    csrf_token: String,
    nightsPrice: Number,
    optionsPrice: Number,
    stripeTax: Number,
    total: Number,
    nights: Number,
    start_date: String,
    end_date: String,
    options: Array | null,
    csrf_token: String,
    res_comment: String | null,

    original_start_date: String,
    original_end_date: String,
    original_res_comment: String | null,
    original_options: Array | null,
});

onMounted(() => {
    if (!clientSecret) {
        console.error('Le clientSecret n\'est pas fourni.');
        return;
    }

    stripe = Stripe('pk_live_51QNaybAwfZnHthsid8zbHUhQ8l3AZWfG4IIAATeYog4oPFJONbBT8CJav0IbNwj0UCEKLsNib7g2Ta2hcDLR8NGY000hi3ptPp');
    elements = stripe.elements();
    const cardElement = elements.create('card');
    cardElement.mount('#payment-element');
    stripeLoaded.value = true;
});

const submitPayment = async () => {
    isSubmitting.value = true;

    if (!stripe || !elements) {
        stripeError.value = "Stripe n'est pas correctement initialisé.";
        return;
    }

    try {
        const { error, paymentIntent } = await stripe.confirmCardPayment(clientSecret, {
            payment_method: {
                card: elements.getElement('card'),
            },
        });

        if (error) {
            stripeError.value = error.message;
            isSubmitting.value = false;
            return;
        }

        Inertia.post(route('payment.process'), {
            paymentIntentId: paymentIntent.id,
        });
    } catch (err) {
        stripeError.value = "Erreur inattendue : " + err.message;
    } finally {
        isSubmitting.value = false;
    }
};

const formatDateShort = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('fr-FR', {
        year: '2-digit',
        month: '2-digit',
        day: '2-digit',
    });
};

const payLater = () => {
    isSubmitting.value = true;

    Inertia.post(route('book.store'), {
        start_date: original_start_date,
        end_date: original_end_date,
        res_comment: original_res_comment,
        options: original_options,
        paymentMethod: 'cash',
        keep_original_data: false,
    });
};
</script>
