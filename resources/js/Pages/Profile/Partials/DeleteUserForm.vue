<script setup>
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import { useUnroll } from './../../../shared/utils';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

const { isUnrolled, toggleUnroll } = useUnroll();

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;

    nextTick(() => passwordInput.value.focus());
};

const confirmDeletion = () => {
    if (confirm("Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.")) {
        deleteUser();
    }
};

const deleteUser = () => {
    form.delete(route('user.delete', { id: usePage().props.auth.user.id }), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => passwordInput.value.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingUserDeletion.value = false;

    form.reset();
};
</script>

<template>
    <section class="space-y-6 max-w-sm mx-auto">

        <div @click="toggleUnroll(3)">
            <div class="flex justify-center cursor-pointer">
                <h2 class="text-lg">Supprimer Votre Compte</h2>
                <h2 style="transform: translateY(2px); text-decoration: none; font-size: 1em;">{{ isUnrolled(3) ? '🔼' : '🔽' }}</h2>
            </div>
        </div>


        <transition name="fade-slide" v-show="isUnrolled(3)" class="max-w-sm mx-auto text-sm">
            <div>
                <p>
                    Supprimer votre compte supprimera toutes vos réservations.
                    <br>Toutes vos données seront supprimées définitivement.
                </p>
                <DangerButton v-if="isUnrolled(3)" @click="confirmUserDeletion" class="mt-2">Supprimer Compte</DangerButton>
            </div>
        </transition>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg">
                    Etes-vous sûr de vouloir supprimer votre compte ?
                </h2>

                <p>
                    <span class="text-red-600 text-2xl">Supprimer votre compte supprimera toutes vos réservations !</span>
                    <br>Si vous vous êtes connecté avec google, laissez le mot-de-passe vide pour supprimer définitivement votre compte ainsi que vos réservations.
                    <br>Une fois que votre compte est supprimé, toutes vos données sont supprimées définitivement.
                </p>

                <div class="mt-6">
                    <InputLabel for="password" value="Password" class="sr-only" />

                    <TextInput
                        id="password"
                        ref="passwordInput"
                        v-model="form.password"
                        type="password"
                        class="mt-1 block w-3/4"
                        placeholder="Password"
                        @keyup.enter="confirmDeletion"
                    />

                    <InputError :message="form.errors.password" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                    <DangerButton
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing || usePage().props.auth.user.role === 'admin'"
                        @click="confirmDeletion"
                    >
                        Supprimer Compte
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
