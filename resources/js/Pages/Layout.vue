<template>
    <div class="min-h-screen mx-auto xl:max-w-6xl pb-8">
        <div class="mx-6 flex-grow">
            <header class="font-bold">

                <div v-if="$page.props.flash && $page.props.flash.success" class="fixed left-1/2 transform -translate-x-1/2 space-y-4 z-50">
                    <transition-group name="fade" tag="div">
                        <div v-for="(message, index) in $page.props.flash.success" :key="index" class="flash-success bg-green-500 text-white px-4 py-2 rounded shadow-lg text-xl mt-20 select-none" v-html="message.replace(/\n/g, '<br>')">
                        </div>
                    </transition-group>
                    </div>

                    <div v-if="$page.props.flash && $page.props.flash.error" class="fixed left-1/2 transform -translate-x-1/2 space-y-4 z-50">
                    <transition-group name="fade" tag="div">
                        <div v-for="(message, index) in $page.props.flash.error" :key="index" class="flash-error bg-red-600 text-white px-4 py-2 rounded shadow-lg text-xl mt-20 select-none" v-html="message.replace(/\n/g, '<br>')">
                        </div>
                    </transition-group>
                </div>
                <nav class="py-6 flex justify-between items-center relative">
                    <div class="flex items-center">
                        <template v-if="auth.user">
                            <img :src="auth.user.picture ? '/storage/profiles/' + auth.user.picture : '/storage/profiles/default_user.png'" 
                                alt="Photo de profil" class="rounded-full h-10 w-10 ml-2" draggable="false">
                            <div class="font-kalnia text-lg px-2 w-[248px] overflow-x-auto whitespace-nowrap select-none">
                                {{ capitalizeName(auth.user.name) }}
                            </div>
                        </template>
                    </div>

                    <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-2 items-center">
                        <Link href="/" :class="isActive('/') ? 'active btn' : 'btn'">Accueil</Link>
                        <Link href="/book" :class="isActive('/book') ? 'active btn' : 'btn'">Réserver</Link>
                        <Link href="/gallery" :class="isActive('/gallery') ? 'active btn' : 'btn'">Galerie</Link>
                            
                        <Link href="/list" :class="isActive('/list') ? 'active btn' : 'btn'" v-if="auth.user && auth.user.role === 'admin'">Utilisateurs</Link>
                    </div>

                    <button @click="menuOpen = !menuOpen" class="md:hidden text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div v-if="menuOpen" class="open-menu md:hidden">
                        <Link href="/" :class="isActive('/') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Accueil</Link>
                        <Link href="/book" :class="isActive('/book') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Réserver</Link>
                        <Link href="/gallery" :class="isActive('/gallery') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Galerie</Link>
                        <span v-if="auth.user && auth.user.role === 'admin'">
                            <Link href="/list" :class="isActive('/list') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Utilisateurs</Link>
                        </span>
                        <template v-if="!auth.user">
                            <Link href="/register" :class="isActive('/register') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Inscription</Link>
                            <Link href="/login" :class="isActive('/login') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Connexion</Link>
                        </template>
                        <template v-else>
                            <Link href="/profile" :class="isActive('/profile') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Profil</Link>
                            <button @click="logout" class="block px-4 py-2 text-left !bg-pink-950 w-full hover:text-orange-600 text-right">Déconnexion</button>
                        </template>
                    </div>

                    <div class="hidden md:flex items-center">
                        <template v-if="!auth.user">
                            <Link href="/register" :class="isActive('/register') ? 'active btn' : 'btn'">Inscription</Link>
                            <Link href="/login" :class="isActive('/login') ? 'active btn ml-2' : 'btn ml-2'">Connexion</Link>
                        </template>
                        <template v-else>
                            <Link href="/profile" :class="isActive('/profile') ? 'active btn' : 'btn'">Profil</Link>
                            <Link href="/logout" method="post" as="button" class="btn !bg-pink-950 ml-2 hover:text-orange-600">Déconnexion</Link>
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
                <footer v-if="showFooter" class="footer fixed bottom-0 left-0 w-full text-center bg-gray-800 text-white">
                    &copy; {{ new Date().getFullYear() }} - Votre moment de tranquilité
                </footer>
            </transition>
        </div>
    </div>
</template>

<script setup>
import { usePage, Link } from '@inertiajs/vue3';
import { Inertia } from '@inertiajs/inertia';
import { ref, onMounted, onUnmounted } from 'vue';
import ThemeSwitcher from './Components/DarkMode.vue';

const { auth } = usePage().props;

const menuOpen = ref(false);

const isActive = (path) => window.location.pathname === path;

const logout = () => {
    Inertia.post('/logout');
};

const capitalizeName = (name) => {
    return name
        .split('-')
        .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
        .join('-');
};

const showFooter = ref(false);

const handleScroll = () => {
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;
    const scrollTop = window.scrollY || window.pageYOffset;

    showFooter.value = windowHeight + scrollTop >= documentHeight - 100;
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

  const pageProps = usePage().props;

  if (pageProps.flash && pageProps.flash.success) {
    setTimeout(() => {
      document.querySelectorAll('.flash-success').forEach(el => {
        el.classList.add('fade-out');
      });
      setTimeout(() => {
        pageProps.flash.success = null;
      }, 2000);  // Delay to allow fade out
    }, 6000);
  }

  if (pageProps.flash && pageProps.flash.error) {
    setTimeout(() => {
      document.querySelectorAll('.flash-error').forEach(el => {
        el.classList.add('fade-out');
      });
      setTimeout(() => {
        pageProps.flash.error = null;
      }, 2000);  // Delay to allow fade out
    }, 6000);
  }
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
});
</script>

<style>
.flash-success, .flash-error {
  transition: opacity 2s ease-in-out;
}

.fade-out {
  opacity: 0;
}
</style>