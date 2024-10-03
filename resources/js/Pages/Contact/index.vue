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
                    placeholder="Nom et Prénom"
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
                    <InputLabel for="email" value="Email" /><span class="text-xs text-red-700">*</span>
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
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <div class="flex">
                    <InputLabel for="message" value="Message" /><span class="text-xs text-red-700">*</span>
                </div>
                <textarea
                    id="message"
                    class="mt-1 block w-full rounded-md shadow-sm"
                    v-model="form.message"
                    :placeholder="messagePlaceholder"
                    rows="4"
                    required
                    minlength="2"
                    maxlength="510"
                ></textarea>
                <InputError class="mt-2" :message="form.errors.message" />
            </div>
            <div class="ml-auto mt-1 flex justify-end">
                <PrimaryButton 
                    :class="[
                        '!btn', 
                        form.processing || !inputsValids 
                        ? 'cursor-not-allowed opacity-50 !bg-gray-600 hover:text-gray-400 opacity-75' 
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
    message: ''
});

const messagePlaceholder = "Bonjour,\nmerci de nous laisser un message, nous vous répondrons au plus vite.";

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const isValidEmail = (email) => {
    return emailRegex.test(email) && email !== '';
};

const inputsValids = computed(() => {
    const isNameValid = form.name && form.name.trim().length >= 2 && form.name.trim().length <= 50;
    const isEmailValid = isValidEmail(form.email);
    const isMessageValid = form.message && form.message.trim().length >= 3 && form.message.trim().length <= 500;
    
    return isNameValid && isEmailValid && isMessageValid;
});

const submit = () => {
    if (inputsValids.value) {
        form.post('/contact', {
            onFinish: () => form.reset('message'),
        });
    } else {
        console.log('Formulaire non valide');
    }
};
</script>

