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
    <section class="space-y-6 mx-auto">
        <header>
            <h2 class="text-lg">Supprimer Votre Compte</h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
               Une fois que votre compte est supprimé, toutes vos données sont supprimées définitivement.<br>Avant de supprimer votre compte, veuillez télécharger vos données.
            </p>
        </header>

        <DangerButton @click="confirmUserDeletion">Supprimer Compte</DangerButton>

        <Modal :show="confirmingUserDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg">
                    Etes-vous sûr de vouloir supprimer votre compte ?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Une fois que votre compte est supprimé, toutes vos données sont supprimées définitivement.<br>Avant de supprimer votre compte, veuillez télécharger vos données.
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
                        @keyup.enter="deleteUser"
                    />

                    <InputError :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Annuler </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteUser"
                    >
                        Supprimer Compte
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>
