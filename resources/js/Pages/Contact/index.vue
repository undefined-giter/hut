<template>
    <Head title="Contact | Cabane" />

    <Layout>
        <h1>Contact</h1>
        
        <form @submit.prevent="submit" class="max-w-sm mx-auto m-8">
            <div title="Merci de renseigner vos nom et prénom">
                <div class="flex">
                    <InputLabel for="name" value="Nom & Prénom" /><span class="text-xs text-red-700">*</span>
                </div>
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    placeholder="Entrez votre nom et prénom"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    minlength="2"
                    maxlength="255"
                />
                <InputError :message="form.errors.name" />
            </div>

            <div class="mt-4" title="Veuillez renseigner votre Email svp">
                <div class="flex">
                    <InputLabel for="email" value="Email" /><span class="text-xs text-red-500">*</span>
                </div>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    placeholder="Votre email"
                    v-model="form.email"
                    required
                    autocomplete="email"
                />
                <InputError :message="form.errors.email" />
            </div>

            <div class="mt-4" title="Veuillez renseigner votre Numéro de Téléphone svp">
                <div class="flex">
                    <InputLabel for="phone" value="Téléphone" />
                </div>
                <input
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    placeholder="Votre numéro de téléphone"
                    v-model="form.phone"
                    pattern="\d{10}"
                    maxlength="10"
                    title="Numéro de téléphone avec 10 chiffres, commençant par 0"
                    autocomplete="phone"
                    @input="handlePhoneInput"
                    @blur="validatePhone"
                />
                <InputError :message="phoneError" />
            </div>

            <div class="mt-4">
                <div class="flex" title="Entre 20 et 510 caractères">
                    <InputLabel for="message" value="Message" /><span class="text-xs text-red-700">*</span>
                </div>
                <textarea
                    id="message"
                    class="mt-1 block w-full rounded-md shadow-sm"
                    v-model="form.message"
                    :placeholder="messagePlaceholder"
                    rows="4"
                    required
                    title="Entre 20 et 510 caractères"
                    minlength="20"
                    maxlength="510"
                ></textarea>
                <InputError :message="form.errors.message" />
            </div>
            <div class="ml-auto mt-2 flex justify-end">
                <PrimaryButton 
                    :class="[
                        '!btn', 
                        form.processing || !inputsValids 
                        ? 'btn-disabled' 
                        : ''
                    ]"
                    :disabled="form.processing || !inputsValids">
                    Envoyer
                </PrimaryButton>
            </div>
        </form>
    </Layout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { computed } from 'vue';
import Layout from './../Layout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';

const props = defineProps({
    user: {
        type: Object,
        default: null
    },
});

let finalName = props.user?.name ? props.user.name : '';
if (props.user?.name2 && props.user.name2 != '') {
    const nameLength = finalName.length;

    if (nameLength < 255) {
        const availableSpace = 255 - nameLength - 4;
        const truncatedName2 = props.user.name2.slice(0, availableSpace);

        if (truncatedName2.length > 0) {
            finalName += ` et ${truncatedName2}`;
        }
    }
}

const form = useForm({
    name: finalName,
    email: props.user ? props.user.email : '',
    phone: props.user ? props.user.phone : '',
    message: ''
});

const messagePlaceholder = "Bonjour,\nmerci de nous laisser un message, nous vous répondrons au plus vite.";
const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const phoneError = ref('');
const phoneRegex = /^0[1-9][0-9]{8}$/;

const isValidEmail = (email) => {
    return emailRegex.test(email) && email !== '';
};

const handlePhoneInput = (event) => {
    const input = event.target;
    const filteredValue = input.value.replace(/\D/g, '');
    input.value = filteredValue;
    form.phone = filteredValue;
    clearPhoneError();
};

const clearPhoneError = () => {
    phoneError.value = '';
};

const validatePhone = () => {
    if (!phoneRegex.test(form.phone)) {
        phoneError.value = "Le numéro doit commencer par 0 et comporter 10 chiffres.";
    }
};

const inputsValids = computed(() => {
    const isNameValid = form.name && form.name.trim().length >= 2 && form.name.trim().length <= 255;
    const isMessageValid = form.message && form.message.trim().length >= 20 && form.message.trim().length <= 500;
    const isEmailValid = isValidEmail(form.email);
    return isNameValid && isMessageValid && isEmailValid;
});

const resetFieldsOnErrors = () => {
    const isPhoneValid = phoneRegex.test(form.phone);
    const isEmailValid = isValidEmail(form.email);
    if (!isPhoneValid) {form.reset('phone');}
    if (!isEmailValid) {form.reset('email');}
};

const submit = () => {
    if (inputsValids.value) {
        form.post('/contact', {
            onFinish: () => resetFieldsOnErrors(),
        });
    } else {
        resetFieldsOnErrors();
    }
};
</script>
