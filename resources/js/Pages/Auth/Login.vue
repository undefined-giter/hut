<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from './../Layout.vue';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head title="Se Connecter | Cabane" />
    <Layout>
        <h1>Se Connecter</h1>
        
        <form @submit.prevent="submit" class="max-w-sm mx-auto m-8">
            <div>
                <div class="flex">
                    <InputLabel for="email" value="Email" /><span class="text-xs text-red-700">*</span>
                </div>

                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <div class="flex">
                    <InputLabel for="password" value="Mot de Passe" /><span class="text-xs text-red-700">*</span>
                </div>

                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="block mt-4 flex justify-between">
                <div>
                    <label class="flex items-center -mt-2">
                        <Checkbox name="remember" v-model:checked="form.remember" :style="{ transform: 'scale(0.75)' }" />
                        <span class="text-sm text-gray-600 dark:text-gray-400">Rester connecté</span>
                    </label>
                    <div class="mt-2">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request', { email: form.email })"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                        >
                            Mot de passe oublié ?
                        </Link>
                    </div>
                </div>
                <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </PrimaryButton>
            </div>
        </form>
    </Layout>
</template>
