<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import Layout from './../Layout.vue';
import Reservations from './../Components/Reservations.vue';

const props = defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    user: Object,
    reservations: Array,
    connected_user_id: Number,
});
</script>

<template>
    <Head :title="user.name ? `Profil de ${user.name} | Cabane` : 'Profil | Cabane'" />

    <Layout>
        <h1>Votre Profil</h1>
        
        <Reservations :reservations="reservations" :connected_user_id="connected_user_id" />

        <div>
            <div class="max-w-7xl mx-auto space-y-6">
                <div class="p-4 sm:p-8 bg-light dark:bg-dark shadow-md rounded-lg hover:scale-105 transform transition-transform duration-300">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        :user="user"
                        class="max-w-xl"
                    />
                </div>

                <div v-if="!user.google_id" class="p-4 sm:p-8 bg-light dark:bg-dark shadow-md rounded-lg hover:scale-105 transform transition-transform duration-300">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-light dark:bg-dark shadow-md rounded-lg hover:scale-105 transform transition-transform duration-300">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </Layout>
</template>
