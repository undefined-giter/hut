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
});
</script>

<template>
    <Head :title="`Profil de ${user.name} | Cabane`" />

    <Layout>
        <h1>Votre Profil</h1>
        
        <Reservations :reservations="reservations" :user="user" />

        <div>
            <div class="max-w-7xl mx-auto space-y-6">
                <div class="p-4 sm:p-8 dark:bg-[#131516] shadow sm:rounded-lg hover:scale-105 transform transition-transform duration-300">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        :user="user"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 dark:bg-[#131516] shadow sm:rounded-lg hover:scale-105 transform transition-transform duration-300">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 dark:bg-[#131516] shadow sm:rounded-lg hover:scale-105 transform transition-transform duration-300">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </Layout>
</template>
