<template>
    <Head title="Stripe Paiement | Cabane" />

    <Layout>
        <div class="max-w-sm mx-auto p-4 my-2 bg-light dark:bg-dark rounded-lg">
            <h1 class="text-2xl font-bold text-center text-purple-700 underline mb-6">Paiement</h1>

            <div class="text-center text-lg font-medium text-gray-700 dark:text-gray-200 mb-6">
                <p class="mb-2">Cabane avec Jacuzzi et sa vue Panoramique</p>
                <p class="mb-1 text-left">Montant à payer : <span class="text-2xl font-bold">{{ total }} €</span></p>
                <p class="text-left">Du {{ formatDateShort(start_date) }} au {{ formatDateShort(end_date) }}</p>
                <p class="text-left">Pour {{ nights }} nuit{{ nights > 1 ? 's' : '' }}</p>
                <div class="text-right mt-1 mb-3">
                    <div class="table w-full">
                        <div class="table-row">
                            <p class="table-cell leading-tight">Nuit{{ nights > 1 ? 's' : '' }} :</p>
                            <p class="table-cell leading-tight">{{ nightsPrice % 1 === 0 ? nightsPrice : nightsPrice.toFixed(2) }} €</p>
                        </div>
                        <div class="table-row">
                            <p class="table-cell leading-tight">Options :</p>
                            <p class="table-cell leading-tight">{{ optionsPrice % 1 === 0 ? optionsPrice : optionsPrice.toFixed(2) }} €</p>
                        </div>
                        <div class="table-row">
                            <p class="table-cell leading-tight">Taxe de paiement par carte :</p>
                            <p class="table-cell leading-tight">{{ stripeTax % 1 === 0 ? stripeTax : stripeTax.toFixed(2) }} €</p>
                        </div>
                        <div class="table-row">
                            <p class="table-cell font-bold leading-tight">Total :</p>
                            <p class="table-cell leading-tight !text-green-600 text-2xl font-semibold">{{ total % 1 === 0 ? total : total.toFixed(2) }} €</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg shadow-md mb-6 text-center underline">
                <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100 mb-4">Informations de carte</h3>
                <div id="payment-element" class="mb-4"></div>
                <button :disabled="isSubmitting || !stripeLoaded" @click.prevent="submitPayment" class="w-full bg-green-600 hover:bg-green-700 disabled:opacity-50 text-white font-semibold py-3 rounded-lg shadow-md transition-colors duration-200">
                    <i class="fas fa-lock mr-2"></i> Confirmer et Payer
                </button>
                <div v-if="stripeError" class="text-red-500 dark:text-red-400 mt-2">{{ stripeError }}</div>
            </div>

            <button @click.prevent="reserve" class="btn">Ou Payer En Liquide, À l'Arrivée</button>

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
    start_date,
    end_date,
    original_options,
    res_comment,
    total,
    payed,
    stripeTax,
    csrf_token,
    reservation_id,
} = defineProps({
    clientSecret: String,
    csrf_token: String,
    nightsPrice: Number,
    optionsPrice: Number,
    stripeTax: Number,
    total: Number,
    payed: Number,
    nights: Number,
    start_date: String,
    end_date: String,
    options: Array | null,
    original_options: Array | null,
    res_comment: String | null,
    reservation_id: Number | null,
});


onMounted(() => {
    if (!clientSecret) {
        console.error("Le clientSecret n'est pas fourni.");
        return;
    }

    //stripe = Stripe('pk_live_51QNaybAwfZnHthsid8zbHUhQ8l3AZWfG4IIAATeYog4oPFJONbBT8CJav0IbNwj0UCEKLsNib7g2Ta2hcDLR8NGY000hi3ptPp');
    stripe = Stripe('pk_test_51QNaybAwfZnHthsiorwzaGxsMW73Ba0E9yGqzzpIBtfmtKdMpesgZ9d9BGUNG1gkVDDUd29Idqbdu8OXlDSniWUm00eqc9MpAR');
    elements = stripe.elements({ clientSecret });

    const appearance = {
        theme: 'flat',
        variables: {
            colorPrimary: '#38a169',
            colorBackground: '#FFFFFF',
            colorText: '#2D3748',
            colorDanger: '#E53E3E',
        },
    };

    const paymentElement = elements.create('payment', { appearance });
    paymentElement.mount('#payment-element');
    stripeLoaded.value = true;
});


const submitPayment = async () => {
    isSubmitting.value = true;

    try {
        const { error, paymentIntent } = await stripe.confirmPayment({
            elements,
            confirmParams: {
                payment_method_data: {},
            },
            redirect: "if_required",
        });

        if (error) {
            stripeError.value = error.message;
            return;
        }

        if (paymentIntent && paymentIntent.status === 'succeeded') {
            Inertia.post('/process-stripe', {
                _token: csrf_token,
                paymentIntentId: paymentIntent.id,
                paymentIntentId: paymentIntent.id,
                start_date,
                end_date,
                res_comment,
                options: original_options,
                total,
                payed,
                stripeTax,
                reservation_id,
            }, {
                onSuccess: () => {},
                onError: (errors) => {
                    stripeError.value = "Erreur lors de la confirmation du paiement.";
                },
            });
        } else {
            stripeError.value = "Erreur : le paiement n'a pas été confirmé.";
        }
    } catch (err) {
        stripeError.value = err.message;
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

const reserve = () => {
    isSubmitting.value = true;

    Inertia.post(route('book.store'), {
        start_date,
        end_date,
        res_comment,
        options: original_options,
    });
};
</script>
