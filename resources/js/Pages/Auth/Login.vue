<template>
    <Head title="Se Connecter | Cabane" />
    <Layout>
        <h1>Se Connecter</h1>
        
        <form @submit.prevent="submit" class="max-w-sm mx-auto mt-8 mb-4">
            <div title="Assurez-vous d'utiliser le même mail que vous avez utiliser pour votre inscription">
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

                <InputError :message="form.errors.email" />
            </div>

            <div class="mt-4" title="Assurez-vous d'utiliser les identifiants correspondant à ceux entrés lors de votre inscription">
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

                <InputError :message="form.errors.password" />
            </div>

            <div class="block mt-4 flex justify-between">
                <div>
                    <label class="flex items-center -mt-2" title="Nos cookies ont une durée de vie de 2 heures seulement.
Inutile de vous surcharger de cookies 😉">
                        <Checkbox name="remember" v-model:checked="form.remember" :style="{ transform: 'scale(0.75)' }" class="mt-1 -ml-1" />
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
                <PrimaryButton :class="['btn', { 'btn-disabled': form.processing || !inputsValids }]" :disabled="form.processing || !inputsValids">
                    Se connecter
                </PrimaryButton>
            </div>
            <div class="mt-2 mb-12 text-center">
                <Link
                    :href="route('register')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Pas encore de compte ?
                </Link>
            </div>
        </form>

        <vue-cal
        locale="fr"
        active-view="month"
        class="vuecal--rounded-theme vuecal--blue-theme text-black dark:text-[#ccc]"
        hide-view-selector
        @cell-click="handleDateClick"
        :disable-views="['years', 'year', 'week', 'day']"
        :dblclick-to-navigate="false"
        style="height:400px; cursor: default !important"
        :min-date="today"
        :selected-date="showMonth"
        >
            <template #cell-content="{ cell }">
                <span 
                    class="vuecal__cell-date cursor-default"

                    :style="(() => {
                        const result = isReservedDate(cell.formattedDate);
                        switch (result) {
                            case 'in':
                                return 'background: linear-gradient(to right, blue, blue, blue, blue, red, red, red, red);';
                            case 'inner':
                                return 'background: red;';
                            case 'out':
                                return 'background: linear-gradient(to right, red, red, red, red, blue, blue, blue, blue);';
                            default:
                                return '';
                        }
                    })()">
                    {{ cell.content }}
                </span>
            </template>
        </vue-cal>
    </Layout>
</template>

<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed, watch } from 'vue';
import Layout from './../Layout.vue';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';

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

const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const isValidEmail = (email) => {
    return emailRegex.test(email) && email !== '';
};

const inputsValids = computed(() => {
    const isEmailValid = isValidEmail(form.email);
    const isPasswordValid = form.password !== '';
    return isEmailValid && isPasswordValid;
});

watch(() => form.email, () => {
    form.clearErrors('email');
});

watch(() => form.password, () => {
    form.clearErrors('password');
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};

const today = new Date();
const isReservedDate = (cellDate) => {
  const in_date = usePage().props.in_date || [];
  const inner_date = usePage().props.inner_date || [];
  const out_date = usePage().props.out_date || [];

  const formattedCellDate = new Date(cellDate);

  if (formattedCellDate < today) {
    return 'inner';
  }

  if (in_date.includes(cellDate)) {
    return 'in';
  } else if (inner_date.includes(cellDate)) {
    return 'inner';
  } else if (out_date.includes(cellDate)) {
    return 'out';
  } else {
    return false;
  }
};
</script>
