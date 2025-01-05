<template>
    <Head title="Se Connecter | Cabane" />
    <Layout>
        <h1>Se Connecter</h1>

        <div class="flex justify-center my-12">
            <button class="text-center btn w-[384px] border-2 border-orangeTheme">
                <a :href="route('google.redirect')">
                    Inscription & connexion
                    
                    <img 
                        v-show="imageLoaded" 
                        @load="imageLoaded = true"
                        src="/img/google_logo.png" 
                        alt="Logo de Google" 
                        class="-mt-6"
                    />
                    
                    <div v-show="!imageLoaded" class="h-[90px] w-auto pt-8">Chargement...</div>
                </a>
            </button>
        </div>

        <form @submit.prevent="submit" class="max-w-sm mx-auto bg-light dark:bg-dark rounded-lg p-4 mb-4">
            <p class="text-center">Ou se connecter manuellement</p>

            <div title="Assurez-vous d'utiliser le même mail que vous avez utiliser pour votre inscription">
                <div class="flex">
                    <InputLabel for="email" value="Email" /><span class="text-xs !text-red-700">*</span>
                </div>

                <TextInput
                    ref="emailInput"
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError :message="form.errors.email" />
            </div>

            <div class="mt-4" title="Assurez-vous d'utiliser les identifiants correspondant à ceux entrés lors de votre inscription">
                <div class="flex">
                    <InputLabel for="password" value="Mot de Passe" /><span class="text-xs !text-red-700">*</span>
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

            <div class="block mt-2 flex justify-between">
                <div>
                    <label class="flex items-center" title="Nos cookies ont une durée de vie de 2 heures seulement.
Inutile de vous surcharger de cookies 😉">
                        <Checkbox name="remember" v-model:checked="form.remember" :style="{ transform: 'scale(0.75)' }" class="-mt-1 -ml-1" />
                        <span class="text-sm pl-0.5 font-mirza text-gray-300">Rester connecté</span>
                    </label>
                    <div class="mt-2">
                        <Link
                            v-if="canResetPassword"
                            :href="route('password.request', { email: form.email })"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                        >
                            Mot de passe oublié ?
                        </Link>
                    </div>
                </div>
                <PrimaryButton :class="['btn', { 'btn-disabled': form.processing || !inputsValids }]" :disabled="form.processing || !inputsValids">
                    Se connecter
                </PrimaryButton>
            </div>
            <div class="mt-8 mb-2 text-center">
                <Link
                    :href="route('register')"
                    class="font-bold underline text-black dark:text-blue-400 decoration-green-600 hover:decoration-green-400 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100"
                >
                    Pas encore de compte ?
                </Link>
            </div>
        </form>

        <vue-cal
        @click="focusEmail"
        locale="fr"
        active-view="month"
        class="vuecal--rounded-theme vuecal--blue-theme communFont"
        hide-view-selector
        :disable-views="['years', 'year', 'week', 'day']"
        :dblclick-to-navigate="false"
        style="height:400px; cursor: default !important"
        :read-only="true"
        :selected-date="minDateDynamic"
        >
            <template #cell-content="{ cell }">
                <span 
                    class="vuecal__cell-date cursor-default"
                    
                    :style="(() => {
                        if (cell.formattedDate < minDateDynamic || cell.formattedDate > maxDate) {
                            return 'background: darkred;';
                        }
                        const result = isReservedDate(cell.formattedDate);
                        switch (result) {
                            case 'in':
                                return 'background: linear-gradient(to right, blue, blue, blue, blue, darkred, darkred, darkred, darkred);';
                            case 'inner':
                                return 'background: darkred;';
                            case 'out':
                                return 'background: linear-gradient(to right, darkred, darkred, darkred, darkred, blue, blue, blue, blue);';
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
import { ref, computed, watch } from 'vue';
import Layout from './../Layout.vue';
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';


const props = defineProps({
    canResetPassword: Boolean,
    status: String,
    minDate: String,
    maxDate: String
});

const imageLoaded = ref(false)

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const emailInput = ref(null)
const focusEmail = () => {
  emailInput.value?.focus()
}

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

const today = new Date(new Date().setDate(new Date().getDate()));

const todayStr = today.getFullYear() + '-' +
                 String(today.getMonth() + 1).padStart(2, '0') + '-' +
                 String(today.getDate()).padStart(2, '0');

const minDateDynamic = ref(
    props.minDate < todayStr
        ? todayStr 
        : props.minDate
);

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
