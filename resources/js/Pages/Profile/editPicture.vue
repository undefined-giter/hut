<template>
  <Head title="Modifier Photo | Cabane" />

  <Layout>
    <h2 class="text-lg">Modifier votre photo de profil</h2>

    <form @submit.prevent="submit" class="space-y-6">

      <div class="text-center w-[384px] h-[250px] mx-auto">
        <div class="w-[384px] h-[250px] mx-auto">
          <img :src="form.preview" alt="Photo actuelle" class="object-cover w-full h-full rounded-xl">
        </div>

        <div class="flex justify-between items-center mt-2 mx-2">
          <div class="text-left -mt-6">
            <label for="delete_picture" class="inline-flex items-center">
              <input
                id="delete_picture"
                type="checkbox"
                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                v-model="form.delete_picture"
              />
              <span class="ml-2 text-sm text-gray-600">Supprimer la photo actuelle</span>
            </label>
          </div>

          <div class="relative overflow-hidden inline-block">
            <button class="bg-blue-500 text-white py-2 px-4 rounded-lg cursor-pointer">
              Choisir un fichier
            </button>
            <input
              type="file" 
              class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" 
              @change="changePicture"
            />
          </div>
        </div>

        <InputError class="mt-2" :message="form.errors.picture" />

        <div class="mt-4 mx-2 text-right">
          <PrimaryButton :disabled="form.processing" class="!bg-blue-600 !text-gray-200">Enregistrer</PrimaryButton>
        </div>
      </div>
      
    </form>
  </Layout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from '@/Components/InputError.vue';
import Layout from './../Layout.vue';
import { Head } from '@inertiajs/vue3';

const user = usePage().props.auth.user;

const form = useForm({
    picture: null,
    delete_picture: false,
    preview: user.picture ? `/storage/profiles/${user.picture}` : `/storage/profiles/default_user.png`,
});

const changePicture = (e) => {
    const file = e.target.files[0];
    form.picture = file;
    form.preview = file ? URL.createObjectURL(file) : `/storage/profiles/default_user.png`;
};

const submit = () => {
  form.submit('post', route('profile.update-picture'), {
    forceFormData: true,
  });
};
</script>
