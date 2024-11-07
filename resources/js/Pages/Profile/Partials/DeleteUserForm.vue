<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { nextTick, ref } from 'vue';

const confirmingUserDeletion = ref(false);
const passwordInput = ref(null);

const form = useForm({
    password: '',
});

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
        <header>
            <h2 class="text-lg">Supprimer Votre Compte</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400 max-w-sm mx-auto">
                Supprimer votre compte supprimera toutes vos réservations.
                <br>Toutes vos données seront supprimées définitivement.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion" class="ml-24 !mt-4">Supprimer Compte</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg">
                    Etes-vous sûr de vouloir supprimer votre compte ?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
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
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="confirmDeletion"
                    >
                        Supprimer Compte
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
