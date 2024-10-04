<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Layout from './../Layout.vue';
import { ref } from 'vue';

const form = useForm({
    name: '',
    name2: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
    picture: null,
    preview: null,
});


const phoneError = ref(null);

const filterInput = (event) => {
    event.target.value = event.target.value.replace(/\D/g, '');
    form.phone = event.target.value;

    phoneError.value = null;
};

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
        phoneError.value = "Format 33 non accepté -> Merci de le remplacer par 0 et de compléter votre numéro";
        return false;
    }
    phoneError.value = null;
    return true;
};

const changePicture = (e) => {
    const file = e.target.files[0];
    if (file) {
        form.picture = file;
        form.preview = URL.createObjectURL(file);
    } else {
        form.picture = null;
        form.preview = null;
    }
};


const submit = () => {
    if (validatePhone()) {
        form.submit('post', route('register'), {
            forceFormData: true,
            onFinish: () => form.reset('password', 'password_confirmation'),
        });
    }
};
</script>

<template>
    <Head title="S'enregistrer | Cabane" />
    <Layout title="S'enregistrer">
        <h1>S'enregistrer</h1>

        <form @submit.prevent="submit" class="max-w-sm mx-auto m-8">
            <div>
                <div class="flex">
                    <InputLabel for="name" value="Nom & Prénom" /><span class="text-xs text-red-700">*</span>
                </div>

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
                <div class="mt-4">
                    <InputLabel for="name2" value="Nom & Prénom de la seconde personne" />
                </div>

                <TextInput
                    id="name2"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name2"
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
                    v-model="form.email"
                    required
                    autocomplete="username"
                />

                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="phone" value="Numéro de Téléphone" />

                <TextInput
                    id="phone"
                    type="tel"
                    class="mt-1 block w-full"
                    v-model="form.phone"
                    maxlength="10"
                    pattern="[0-9]*"
                    @input="filterInput"
                    @blur="validatePhone"
                />

                <InputError class="mt-2" :message="form.errors.phone" />
                <p v-if="phoneError" class="!text-red-600 text-sm mt-2">{{ phoneError }}</p>
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
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <div class="flex">
                    <InputLabel for="password_confirmation" value="Confirmez votre Mot de Passe" /><span class="text-xs text-red-700">*</span>
                </div>

                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />

                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div>
                <br>
                <InputLabel for="picture" value="Photo de profil" class="mb-1" />
                
                <div class="flex items-center space-x-4">
                    <img :src="form.preview ?? 'storage/profiles/default_user.png'" alt="Pré-visuelle de votre photo" class="object-cover w-16 h-16 rounded-xl">
                    
                    <input
                    id="picture"
                    type="file"
                    class="mt-1.5 !ml-1 block w-full dark:text-white"
                    @input="changePicture"
                    />
                </div>
                
                <InputError :message="form.errors.picture" />
            </div>
            
            <div class="flex items-end justify-between mt-2">
                
                    <Link
                        :href="route('login')"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                    >
                        Déjà enregistré ?
                    </Link>

                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        S'enregistrer
                    </PrimaryButton>
                
            </div>
        </form>
    </Layout>
</template>
