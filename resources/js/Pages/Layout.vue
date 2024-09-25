<template>
    <div class="min-h-screen mx-auto xl:max-w-6xl pb-8">
        <div class="mx-20 flex-grow">
            <header class="font-bold">

                <div v-if="$page.props.flash && $page.props.flash.success" class="fixed left-1/2 transform -translate-x-1/2 space-y-4 z-40 top-20">
                    <transition-group name="fade" tag="div">
                        <div v-for="(message, index) in $page.props.flash.success" :key="index" class="flash-success bg-green-500 text-white px-4 py-2 rounded shadow-lg text-xl select-none" v-html="message.replace(/\n/g, '<br>')"></div>
                    </transition-group>
                </div>

                <div v-if="$page.props.flash && $page.props.flash.error" class="fixed left-1/2 transform -translate-x-1/2 space-y-4 z-40 top-20">
                    <transition-group name="fade" tag="div">
                        <div v-for="(message, index) in $page.props.flash.error" :key="index" class="flash-error bg-red-700 text-white px-4 py-2 rounded shadow-lg text-xl select-none" v-html="message.replace(/\n/g, '<br>')"></div>
                    </transition-group>
                </div>

                <nav class="fixed top-0 left-0 w-full mt-3 px-2 flex justify-between items-center z-50 bg-transparent">
                    <div class="flex items-center w-[300px]">
                        <template v-if="auth.user">
                            <Link href="/profile" class="transition-transform duration-200 hover:scale-105 hover:shadow-lg flex items-center hidden md:flex items-center origin-left w-auto">
                                <img :src="auth.user.picture ? '/storage/profiles/' + auth.user.picture : '/storage/profiles/default_user.png'" 
                                    alt="Photo de profil" class="rounded-full h-10 w-10 ml-2" draggable="false">
                                    <p :class="isActive('/profile') ? 'custom-underline' : ''" class="kalniaGlaze text-lg px-2 max-w-xs overflow-x-auto whitespace-nowrap select-none">
                                        {{ capitalizeName(auth.user.name) }}
                                    </p>
                            </Link>
                        </template>
                    </div>

                    <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-2 items-center">
                        <Link href="/" :class="isActive('/') ? 'active btn' : 'btn'">Accueil</Link>
                        <Link href="/book" :class="isActive('/book') ? 'active btn' : 'btn'">Réserver</Link>
                        <Link href="/gallery" :class="isActive('/gallery') ? 'active btn' : 'btn'">Galerie</Link>
                            
                        <Link href="/options" :class="isActive('/options') ? 'active btn !ml-6' : 'btn !ml-6'" v-if="auth.user && auth.user.role === 'admin'">Options</Link>
                        <Link href="/list" :class="isActive('/list') ? 'active btn' : 'btn'" v-if="auth.user && auth.user.role === 'admin'">Utilisateurs</Link>
                    </div>

                    <button id="menuButton" ref="menuButtonRef" @click="menuOpen = !menuOpen" class="md:hidden text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div v-if="menuOpen" ref="menuRef" class="open-menu md:hidden mr-0.5 !rounded-tr-none">
                        <Link href="/" :class="isActive('/') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Accueil</Link>
                        <Link href="/book" :class="isActive('/book') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Réserver</Link>
                        <Link href="/gallery" :class="isActive('/gallery') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Galerie</Link>
                        <span v-if="auth.user && auth.user.role === 'admin'">
                            <Link href="/options" :class="isActive('/options') ? 'active block px-4 py-2 hover:text-green-200' : 'block px-4 py-2 hover:bg-gray-200'">Options</Link>
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
                            <Link href="/logout" method="post" as="button" class="btn !bg-pink-950 ml-2 hover:text-orange-600">Déconnexion</Link>
                        </template>
                    </div>

                    <div class="absolute -top-5 right-0 !-mr-1.5 !bg-transparent">
                        <ThemeSwitcher />
                    </div>
                </nav>
            </header>

            <main class="md:pt-20 pt-6">
                <slot />
            </main>

            <transition name="fade">
                <footer v-if="showFooter">
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
const menuRef = ref(null);
const menuButtonRef = ref(null);

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

    showFooter.value = windowHeight + scrollTop >= documentHeight - 80;
};

const checkInitialFooterVisibility = () => {
    const windowHeight = window.innerHeight;
    const documentHeight = document.documentElement.scrollHeight;

    if (documentHeight <= windowHeight) {
        showFooter.value = true;
    }
};

const handleDocumentClick = (event) => {
  if (
    menuOpen.value &&
    menuRef.value && !menuRef.value.contains(event.target) &&
    menuButtonRef.value && !menuButtonRef.value.contains(event.target)
  ) {
    menuOpen.value = false;
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
        }, 1000);
    }, 6000);
    }

    if (pageProps.flash && pageProps.flash.error) {
        setTimeout(() => {
            document.querySelectorAll('.flash-error').forEach(el => {
                el.classList.add('fade-out');
            });
            setTimeout(() => {
                pageProps.flash.error = null;
            }, 1000);
        }, 6000);
    }

    document.addEventListener('click', handleDocumentClick);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', handleDocumentClick);
});
</script>

<style>
.flash-success, .flash-error {
    transition: opacity 3s ease-in-out;
    pointer-events: none;
}

.fade-out {opacity: 0;}

.custom-underline {
    text-decoration: underline;
    text-decoration-color: #800064;
    text-underline-offset: 3px;
}
</style>