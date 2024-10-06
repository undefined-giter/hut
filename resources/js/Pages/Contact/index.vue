<template>
    <Head title="Contact | Cabane" />

    <Layout>
        <h1>Contact</h1>

        <form @submit.prevent="submit" class="max-w-sm mx-auto m-8">
            <div>
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
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <div class="flex">
                    <InputLabel for="email" value="Email" title="Veuillez renségner votre Email ou votre Numéro de Téléphone, ou bien les deux" /><span class="text-xs text-orange-500">*</span>
                </div>
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    placeholder="Votre email"
                    v-model="form.email"
                    title="Veuillez renségner votre Email ou votre Numéro de Téléphone, ou bien les deux"
                    autocomplete="email"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <div class="flex">
                    <InputLabel for="phone" value="Téléphone" title="Veuillez renségner votre Numéro de Téléphone ou votre Email, ou bien les deux" /><span class="text-xs text-orange-500">*</span>
                </div>
                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    placeholder="Votre numéro de téléphone"
                    v-model="form.phone"
                    maxlength="12"
                    autocomplete="phone"
                />
                <InputError class="mt-2" :message="form.errors.email" />
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
                <InputError class="mt-2" :message="form.errors.message" />
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
    }
});

let finalName = props.user?.name || '';
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
    phone: '',
    message: ''
});

const messagePlaceholder = "Bonjour,\nmerci de nous laisser un message, nous vous répondrons au plus vite.";

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const isValidEmail = (email) => {
    return emailRegex.test(email) && email !== '';
};

const transformPhoneToLocal = (phone) => {
    if (phone.startsWith("+33")) {
        return '0' + phone.slice(4);
    } else if (phone.startsWith("33")) {
        return '0' + phone.slice(2);
    }
    return phone;
};

const phoneRegex = /^0[1-9][0-9]{8}$/;
const isValidPhone = (phone) => {
    const transformedPhone = transformPhoneToLocal(phone);
    return phoneRegex.test(transformedPhone);
};

const inputsValids = computed(() => {
    const isNameValid = form.name && form.name.trim().length >= 2 && form.name.trim().length <= 50;
    const isMessageValid = form.message && form.message.trim().length >= 20 && form.message.trim().length <= 500;
    const isEmailOrPhoneValid = isValidEmail(form.email) || isValidPhone(form.phone);
    return isNameValid && isMessageValid && isEmailOrPhoneValid;
});

const submit = () => {
    if (inputsValids.value) {
        form.phone = transformPhoneToLocal(form.phone);
        form.post('/contact', {
            onFinish: () => form.reset('message', 'email', 'phone'),
        });
    } else {
        console.log('Formulaire non valide');
    }
};
</script>
