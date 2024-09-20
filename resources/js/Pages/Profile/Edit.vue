<script setup>
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import Layout from './../Layout.vue';
import Reservations from './../Components/Reservations.vue';

defineProps({
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
    <Head title="Modifier Profile | Cabane" />

    
    <Layout>
        <h1>Votre Profil</h1>
        
        <Reservations :reservations="reservations" />

        <div>
            <div class="max-w-7xl mx-auto space-y-6">
                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 !bg-[#181a1b] shadow sm:rounded-lg">
                    <UpdateProfileInformationForm
                        :must-verify-email="mustVerifyEmail"
                        :status="status"
                        class="max-w-xl"
                    />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 !bg-[#181a1b] shadow sm:rounded-lg">
                    <UpdatePasswordForm class="max-w-xl" />
                </div>

                <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 !bg-[#181a1b] shadow sm:rounded-lg">
                    <DeleteUserForm class="max-w-xl" />
                </div>
            </div>
        </div>
    </Layout>
</template>
