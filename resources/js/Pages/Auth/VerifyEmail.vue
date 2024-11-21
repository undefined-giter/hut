<template>
    <GuestLayout>
        <Head title="Vérifier Email | Cabane" />

        <div class="mb-4 text-sm text-orangeTheme dark:text-orangeTheme">
            Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous vous avons envoyé ? Si vous n'avez pas reçu l'email, nous vous en enverrons volontiers un autre.
            <br>Pensez à vérifier vos spams.
        </div>

        <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Renvoyer l'e-mail de vérification
                </PrimaryButton>

                <button
                    @click="window.location.reload();"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Recharger
                </button>
            </div>
        </form>
    </GuestLayout>
</template>

<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(() => props.status === 'verification-link-sent');
</script>
