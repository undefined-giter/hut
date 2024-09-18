<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;
const phoneError = ref(null);

const form = useForm({
    name: user.name,
    email: user.email,
    phone: user.phone ?? '',
});

const validatePhone = () => {
    const phone = form.phone;
    if (!phone) {
        phoneError.value = null;
        return true;
    }
    if (phone.length !== 10) {
        phoneError.value = "Le numéro doit contenir 10 chiffres.";
        return false;
    }
    if (phone.startsWith('3')) {
        phoneError.value = "Format 33 non accepté. Merci de remplacer par 0.";
        return false;
    }
    phoneError.value = null;
    return true;
};

const submit = () => {    
    if (validatePhone()) {
        form.patch(route('profile.update'))
    }
};
</script>

<template>
    <section class="mx-auto">
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">Informations du profil</h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Modifiez les informations de votre profil et votre adresse e-mail.
            </p>
        </header>

        <form @submit.prevent="submit" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Nom" />
                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel for="phone" value="Numéro de Téléphone" />
                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    maxlength="10"
                    autocomplete="tel"
                />
                <InputError class="mt-2" :message="form.errors.phone" />
                <p v-if="phoneError" class="!text-red-500 text-sm mt-2">{{ phoneError }}</p>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>
                <div v-show="status === 'verification-link-sent'" class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    A new verification link has been sent to your email address.
                </div>
            </div>
            
            <div>
                <div class="mt-6 flex justify-between">
                    <Link :href="route('profile.edit-picture')" class="btn">Modifier la photo de profil</Link>
                    <PrimaryButton :disabled="form.processing" class="ml-auto">Sauvegarder</PrimaryButton>
                </div>

                <div class="flex items-center gap-4">
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">Sauvegardé.</p>
                    </Transition>
                </div>
            </div>

        </form>
    </section>
</template>
