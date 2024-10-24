<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps({
    status: {
        type: String,
    },
});

const queryParams = new URLSearchParams(window.location.search);
const emailFromUrl = queryParams.get('email') || '';

const form = useForm({
    email: emailFromUrl,
});

const isSubmitted = ref(false);

const submit = () => {
    form.post(route('password.email'), {
        onSuccess: () => {
            isSubmitted.value = true;
            setTimeout(() => {
                window.location.href = route('gallery');
            }, 4000);
        }
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Mot de Passe Oublié | Cabane" />
        
        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            Vous avez oublié votre mot de passe ? Pas de souci, entrez votre adresse email et nous vous enverrons un mail pour réinitialiser votre mot de passe.
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="email" value="Email" />

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError :message="form.errors.email" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Recevoir un mail de réinitialisation mdp
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
