<template>
  <Head title="Modifier Photo | Cabane" />

  <Layout>
    <h2 class="text-lg">Modifier votre photo de profil</h2>

    <form @submit.prevent="submit" class="space-y-6 mx-2">

      <div class="text-center w-[340px] md:w-[384px] mx-auto">
        <div class="w-[340px] md:w-[384px] h-[250px] mx-auto">
          <img :src="form.preview" loading="lazy" alt="Photo actuelle" class="object-cover w-full h-full rounded-xl">
        </div>

        <div class="flex justify-between items-center mt-1">
          <div class="text-left -mt-6">
            <label for="delete_picture" class="inline-flex items-center">
              <input
                id="delete_picture"
                type="checkbox"
                v-model="form.delete_picture"
              />
              <span class="ml-2 text-sm text-gray-600">Supprimer la photo actuelle</span>
            </label>
          </div>

          <div class="relative overflow-hidden inline-block">
            <button class="btn" id="input-file">
              Parcourir
            </button>
            <input
              type="file"
              class="absolute top-0 left-0 w-full h-full opacity-0 cursor-pointer" 
              @change="changePicture"
            />
          </div>
        </div>

        <InputError :message="form.errors.picture" />

        <div class="mt-4 flex justify-between">
          <button type="button" @click="goBack();" class="btn">Retour</button>
          <PrimaryButton :disabled="form.processing" class="btn">Enregistrer</PrimaryButton>
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
    preview: user.picture 
        ? user.picture.startsWith('https') 
            ? user.picture 
            : `${baseUrl}/profiles/` + user.picture
        : `${baseUrl}/profiles/default_user.png`,
});

const goBack = () => {
    if (window.history.length > 1) {
        window.history.back();
    } else {
        Inertia.visit('/list');
    }
};

const changePicture = (e) => {
    const file = e.target.files[0];
    form.picture = file;
    form.preview = file ? URL.createObjectURL(file) : `${baseUrl}/profiles/default_user.png`;
};

const submit = () => {
  form.submit('post', route('profile.update-picture'), {
    forceFormData: true,
  });
};
</script>