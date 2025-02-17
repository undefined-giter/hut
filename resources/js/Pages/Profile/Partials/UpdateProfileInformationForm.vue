<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useUnroll } from './../../../shared/utils';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { validatePhone } from './../../../shared/utils';

const { isUnrolled, toggleUnroll } = useUnroll();

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: {
        type: Object,
        required: true,
    },
});

const phoneError = ref(null);

const form = useForm({
    name: props.user.name !== 'Profil' ? props.user.name : '',
    name2: props.user.name2 || '',
    email: props.user.email,
    phone: props.user.phone ?? '',
});

const checkPhone = () => {
    form.phone = form.phone.replace(/\D/g, '');

    const { isValid, error } = validatePhone(form.phone);
    phoneError.value = error;
    return isValid;
};

const submit = () => {   
    phoneError.value = null;
     
    if (props.user.email === 'fake_admin@fake.admin') {
        alert("En tant que fake_admin, vous n'avez pas le droit de modifier vos informations.");
        return;
    }
    if (checkPhone()) {
        form.patch(route('profile.update'));
    }
};
</script>


<template>
    <section class="mx-auto">
        <div @click="toggleUnroll(1)" class="flex justify-center cursor-pointer">
            <h2 class="text-lg">Informations du profil</h2>
            <h2 style="transform: translateY(2px); text-decoration: none; font-size: 1em;">{{ isUnrolled(1) ? '🔼' : '🔽' }}</h2>
        </div>
        
        
        <transition name="fade-slide" v-show="isUnrolled(1)">
            <form @submit.prevent="submit" class="space-y-6 max-w-sm mx-auto text-sm bg-light dark:bg-dark p-2 rounded-xl">
                <p>Modifier les informations de votre profil.</p>

                <div>
                    <InputLabel for="name" value="Nom & Prénom" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        autocomplete="name"
                    />
                    <InputError :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="name2" value="Accompagné(e) de" />
                    <TextInput
                        id="name2"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name2"
                        autocomplete="name2"
                    />
                    <InputError :message="form.errors.name2" />
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
                    <InputError :message="form.errors.email" />
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
                        @input="checkPhone"
                    />
                    <InputError :message="form.errors.phone" />
                    <p v-if="phoneError" class="!text-red-600 text-sm mt-2">{{ phoneError }}</p>
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
                    <div class="-mt-3 flex justify-between">
                        <Link :href="route('profile.edit-picture')" class="btn rounded-[1em]">Modifier la photo de profil</Link>

                        <div class="flex items-center">
                            <Transition
                                enter-active-class="transition ease-in-out"
                                enter-from-class="opacity-0"
                                leave-active-class="transition ease-in-out"
                                leave-to-class="opacity-0"
                            >
                                <p v-if="form.recentlySuccessful" class="text-xs text-gray-600 dark:text-gray-400">Sauvegardé. </p>
                            </Transition>
                            
                            <PrimaryButton :disabled="form.processing" class="ml-auto">Sauvegarder</PrimaryButton>
                        </div>
                    </div>
                </div>
            </form>
        </transition>
    </section>
</template>
