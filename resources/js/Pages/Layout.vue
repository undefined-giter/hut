<template>
    <div class="min-h-screen mx-auto max-w-6xl pb-8">
        <div class="mx-0.5 flex-grow">
            
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
                
                <nav class="fixed top-0 left-7 right-4 1280px:px-0 max-w-6xl mx-auto mt-2 flex justify-between items-center z-50 bg-transparent">   
                    <div>
                        <div class="flex absolute -top-6 !bg-transparent z-30">
                            <ThemeSwitcher class="mt-4 md:mt-0.5" />
                            <GoogleTranslate />
                        </div>

                        <div class="flex items-center w-auto absolute md:-top-0 !bg-transparent z-20">
                            <template v-if="auth.user">
                                <Link :href="route('profile')" class="flex items-center z-20 origin-right md:origin-left transition-transform duration-300 hover:scale-110 hover:shadow-lg ml-2 md:ml-0">
                                    <img :src="auth.user.picture ? `${baseUrl}/profiles/` + auth.user.picture : `${baseUrl}/profiles/default_user.png`"
                                        loading="lazy"
                                        alt="Photo de profil"
                                        class="rounded-full h-8 w-8 md:h-10 md:w-10 ml-5 -mt-3.5 ml-4 md:ml-2 md:mt-2 transition-all duration-300"
                                        draggable="false">
                                    <p :class="isActive('/profile') ? 'custom-underline' : ''" 
                                    class="hidden md:flex kalniaGlaze text-lg px-2 max-w-xs overflow-x-auto whitespace-nowrap select-none">
                                        {{ auth.user.name }}
                                    </p>
                                </Link>
                            </template>
                        </div>
                    </div>

                    <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 space-x-2 items-center">
                        <Link :href="route('homepage')" :class="isActive(route('homepage')) ? 'active btn transition duration-300 ease-in-out' : 'btn transition duration-300 ease-in-out'">Accueil</Link>
                        <Link :href="route('gallery')" :class="isActive(route('gallery')) ? 'active btn transition duration-300 ease-in-out' : 'btn transition duration-300 ease-in-out'">Galerie</Link>
                        <Link :href="route('book')" :class="isActive(route('book')) ? 'active btn transition duration-300 ease-in-out' : 'btn transition duration-300 ease-in-out'">Réserver</Link>
                        <Link :href="route('contact')" :class="isActive(route('contact')) ? 'active btn transition duration-300 ease-in-out' : 'btn transition duration-300 ease-in-out'">Contact</Link>

                        <Link :href="route('admin.options.index')" :class="isActive(route('admin.options.index')) ? 'active btn transition duration-300 ease-in-out !ml-6' : 'btn transition duration-300 ease-in-out !ml-6'" v-if="auth.user && (auth.user.role === 'admin' || auth.user.role === 'fake_admin')">Options</Link>
                        <Link :href="route('admin.list')" :class="isActive(route('admin.list')) ? 'active btn transition duration-300 ease-in-out' : 'btn transition duration-300 ease-in-out'" v-if="auth.user && (auth.user.role === 'admin' || auth.user.role === 'fake_admin')">Utilisateurs</Link>
                    </div>

                    <div class="hidden md:flex items-center">
                        <template v-if="!auth.user">
                            <Link :href="route('register')" :class="isActive(route('register')) ? 'active btn transition duration-300 ease-in-out' : 'btn transition duration-300 ease-in-out'">Inscription</Link>
                            <Link :href="route('login')" :class="isActive(route('login')) ? 'active btn ml-2 transition duration-300 ease-in-out' : 'btn ml-2 transition duration-300 ease-in-out'">Connexion</Link>
                        </template>
                        <template v-else>
                            <Link :href="route('logout')" method="post" as="button" class="btn !bg-pink-950 right-2 mr-0 lg:mr-4 xl:mr-3 hover:text-orange-600 transition duration-300 ease-in-out">Déconnexion</Link>
                        </template>
                    </div>

                    <button id="menuButton" ref="menuButtonRef" @click="menuOpen = !menuOpen" class="md:hidden ml-auto text-blue-700 focus:outline-none transition duration-300 ease-in-out">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <div v-if="menuOpen" ref="menuRef" class="open-menu md:hidden mr-0.5 -mt-9 !rounded-tr-none transition duration-300 ease-in-out">
                        <Link :href="route('homepage')" :class="isActive(route('homepage')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Accueil</Link>
                        <Link :href="route('gallery')" :class="isActive(route('gallery')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Galerie</Link>
                        <Link :href="route('book')" :class="isActive(route('book')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Réserver</Link>
                        <Link :href="route('contact')" :class="isActive(route('contact')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Contact</Link>
                        <span v-if="auth.user && (auth.user.role === 'admin' || auth.user.role === 'fake_admin')">
                            <Link :href="route('admin.options.index')" :class="isActive(route('admin.options.index')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Options</Link>
                            <Link :href="route('admin.list')" :class="isActive(route('admin.list')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Utilisateurs</Link>
                        </span>
                        <template v-if="!auth.user">
                            <Link :href="route('register')" :class="isActive(route('register')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Inscription</Link>
                            <Link :href="route('login')" :class="isActive(route('login')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Connexion</Link>
                        </template>
                        <template v-else>
                            <Link :href="route('profile')" :class="isActive(route('profile')) ? 'active block px-4 py-1.5 hover:text-green-200 transition duration-300 ease-in-out' : 'block px-4 py-1.5 hover:bg-gray-200 transition duration-300 ease-in-out'">Profil</Link>
                            <button @click="logout" class="block px-4 py-1.5 text-left text-sm custom-transparent-pink w-full hover:text-orange-600 transition duration-300 ease-in-out text-right">Déconnexion</button>
                        </template>
                    </div>
                </nav>
            </header>

            <div class="mx-1 sm:mx-2 md:mx-4 lg:mx-2 xl:mx-0">
                <main class="max-w-6xl mt-12 md:mt-16 mx-auto overflow-hidden p-2 mb-1 rounded-xl shadow-lg border border-orangeTheme transition-all duration-300">
                    <slot />
                </main>
            </div>

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
import GoogleTranslate from './Components/GoogleTranslate.vue';

const { baseUrl, auth } = usePage().props;

const menuOpen = ref(false);
const menuRef = ref(null);
const menuButtonRef = ref(null);

const isActive = (path) => window.location.pathname === path;

const logout = () => { Inertia.post('/logout'); };

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
    menuButtonRef.value.click();
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
    }, 8000);
    }

    if (pageProps.flash && pageProps.flash.error) {
        setTimeout(() => {
            document.querySelectorAll('.flash-error').forEach(el => {
                el.classList.add('fade-out');
            });
            setTimeout(() => {
                pageProps.flash.error = null;
            }, 1000);
        }, 8000);
    }

    document.addEventListener('click', handleDocumentClick);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', handleDocumentClick);
});
</script>
