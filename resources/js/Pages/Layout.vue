<template>
    <div class="min-h-screen mx-auto xl:max-w-6xl">
        <div class="mx-6 flex-grow">
            <header class="font-bold">
                <nav class="py-6 flex justify-between items-center relative">
                    <div class="flex items-center">
                        <template v-if="auth.user">
                            <img :src="auth.user.picture ? '/storage/profiles/' + auth.user.picture : '/storage/profiles/default_user.png'" alt="Photo de profil" class="rounded-full h-10 w-10 ml-2" draggable="false">
                            <div class="font-kalnia text-lg px-2 w-[248px] overflow-x-auto whitespace-nowrap select-none">
                                {{ capitalizeName(auth.user.name) }}
                            </div>
                        </template>
                    </div>
                    
                    <div class="absolute left-1/2 transform -translate-x-1/2 space-x-2 flex items-center">
                        <Link href="/" :class="isActive('/') ? 'active btn' : 'btn'">Accueil</Link>
                        <Link href="/book" :class="isActive('/book') ? 'active btn' : 'btn'">Réserver</Link>
                        <Link href="/gallery" :class="isActive('/gallery') ? 'active btn' : 'btn'">Gallerie</Link>
                        <span v-if="auth.user && auth.user.role === 'admin'">
                            <Link href="/list" :class="isActive('/list') ? 'active btn' : 'btn'">Utilisateurs</Link>
                        </span>
                    </div>

                    <div class="flex items-center">
                        <template v-if="!auth.user">
                            <Link href="/register" :class="isActive('/register') ? 'active btn' : 'btn'">Inscription</Link>
                            <Link href="/login" :class="isActive('/login') ? 'active btn ml-2' : 'btn ml-2'">Connection</Link>
                        </template>
                        <template v-else>
                            <Link href="/profile" :class="isActive('/profile') ? 'active btn' : 'btn'">Profile</Link>
                            <button @click="logout" class="btn !bg-pink-200 ml-2">Déconnection</button>
                        </template>
                    </div>

                    <div class="absolute top-0 right-0 !bg-transparent">
                        <ThemeSwitcher />
                    </div>
                </nav>
            </header>

            <main class="mt-4">
                <slot />
            </main>

            <transition name="fade">
                <footer v-if="showFooter" class="footer fixed bottom-0 left-0 w-full text-center bg-gray-800 text-white py-4">
                    &copy; {{ new Date().getFullYear() }} - Votre moment de tranquilité
                </footer>
            </transition>
        </div>
    </div>
</template>

<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';

defineProps({
    title: {
        type: String,
        default: 'Bienvenue',
    },
});

const { auth } = usePage().props;

const isActive = (path) => {
    return window.location.pathname === path;
};

const logout = () => {
    Inertia.post('/logout');
};

import ThemeSwitcher from './Components/DarkMode.vue';

const capitalizeName = (name) => {
    return name
        .split('-')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join('-');
};



import { ref, onMounted, onUnmounted } from 'vue';

const showFooter = ref(false);

const handleScroll = () => {
  const windowHeight = window.innerHeight;
  const documentHeight = document.documentElement.scrollHeight;
  const scrollTop = window.scrollY || window.pageYOffset;

  if (windowHeight + scrollTop >= documentHeight - 100) {
    showFooter.value = true;
  } else {
    showFooter.value = false;
  }
};

const checkInitialFooterVisibility = () => {
  const windowHeight = window.innerHeight;
  const documentHeight = document.documentElement.scrollHeight;

  if (documentHeight <= windowHeight) {
    showFooter.value = true;
  }
};

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  checkInitialFooterVisibility();
});

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll);
});
</script>
