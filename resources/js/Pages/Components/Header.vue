<template>
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
        
        <nav class="fixed top-0 left-4 right-3 1280px:px-0 max-w-6xl mx-auto mt-2 flex justify-between z-50 bg-transparent">   
            <div>
                <div class="flex absolute -top-6 !bg-transparent z-30">
                    <ThemeSwitcher class="mt-4 md:mt-0.5" />
                    <GoogleTranslate />
                </div>
                
                <div class="flex items-center w-auto absolute top-2.5 md:-top-0 !bg-transparent z-20">
                    <template v-if="user">
                        <Link :href="route('profile')" class="flex items-center z-20 origin-right md:origin-left transition-transform duration-300 hover:scale-110 hover:shadow-lg ml-2 md:ml-0">
                            <img 
                                :src="profilePicture"
                                loading="lazy"
                                alt="Photo de profil"
                                class="img-transition rounded-full h-8 w-8 md:h-10 md:w-10 ml-5 -mt-3.5 ml-4 md:ml-2 md:mt-2 transition-all duration-300"
                                draggable="false"
                            />
                            <p :class="[isActive('profile') ? 'custom-underline' : '', 'hidden md:flex kalniaGlaze text-lg px-2 max-w-xs overflow-x-auto whitespace-nowrap select-none']">
                                {{ user.name }}
                            </p>
                        </Link>
                    </template>
                </div>
                <AccountRoad v-show="showAccountRoad" />
            </div>

            <div class="hidden md:flex absolute full-nav left-1/2 transform -translate-x-1/2 space-x-1.5">
                <Link :href="route('homepage')" :class="[isActive('homepage') ? 'link-active' : '', commonClasses]">Accueil</Link>
                <Link :href="route('gallery')" :class="[isActive('gallery') ? 'link-active' : '', commonClasses]">Galerie</Link>
                <Link :href="route('book')" :class="[isActive('book') ? 'link-active' : '', commonClasses]">Réserver</Link>
                <Link :href="route('contact')" :class="[isActive('contact') ? 'link-active' : '', commonClasses]">Contact</Link>

                <div v-if="user && (user.role === 'admin' || user.role === 'fake_admin')" class="mt-2 relative group inline-block">
                    <Link :href="route('admin.options.index')" :class="[isActive('admin.options.*') || isActive('admin.prices') ? 'link-active' : '', commonClasses, 'ml-6 group-hover:rounded-b-none']">Options</Link>
                    <div class="absolute hidden group-hover:block">
                    <div class="block mt-4 -ml-6">
                        <Link :href="route('admin.options.create')" :class="[isActive('admin.options.create') ? 'link-active' : '', 'btn rounded-tl-md rounded-bl-md']">+Options</Link>
                        <Link :href="route('admin.prices')" :class="[isActive('admin.prices') ? 'link-active' : '', 'btn rounded-tr-md rounded-br-md']">Prix</Link>
                    </div>
                    </div>
                </div>
                <Link v-if="user && (user.role === 'admin' || user.role === 'fake_admin')"
                    :href="route('admin.list')" 
                    :class="[isActive('admin.list') || isActive('admin.details') ? 'link-active' : '', commonClasses]">Profils
                </Link>
            </div>

            <div class="hidden md:flex full-nav">
                <template v-if="!user">
                    <Link :href="route('register')" :class="[isActive('register') ? 'link-active' : '', commonClasses]">Inscription</Link>
                    <Link :href="route('login')" :class="[isActive('login') ? 'link-active' : '', commonClasses, 'ml-1.5']">Connexion</Link>
                </template>
                <template v-else>
                    <Link :href="route('logout')" method="post" as="button" class="btn deconnection">Déconnexion</Link>
                </template>
            </div>

            <button id="menuButton" ref="menuButtonRef" @click="menuOpen = !menuOpen" class="md:hidden ml-auto text-blue-700 focus:outline-none transition duration-300 ease-in-out">
                <svg class="w-6 h-6" fill="none" stroke="#0022ff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>

            <div v-if="menuOpen" ref="menuRef" class="open-menu md:hidden transition duration-300 ease-in-out">
                <Link :href="route('homepage')" :class="[isActive('homepage') ? 'link-active' : '', menuLinkClasses]">Accueil</Link>
                <Link :href="route('gallery')" :class="[isActive('gallery') ? 'link-active' : '', menuLinkClasses]">Galerie</Link>
                <Link :href="route('book')" :class="[isActive('book') ? 'link-active' : '', menuLinkClasses]">Réserver</Link>
                <Link :href="route('contact')" :class="[isActive('contact') ? 'link-active' : '', menuLinkClasses]">Contact</Link>
                
                <span v-if="user && (user.role === 'admin' || user.role === 'fake_admin')">
                    <Link :href="route('admin.options.index')" :class="[isActive('admin.options.index') ? 'link-active' : '', menuLinkClasses]">Options</Link>
                    <Link :href="route('admin.list')" :class="[isActive('admin.list') ? 'link-active' : '', menuLinkClasses]">Utilisateurs</Link>
                </span>

                <template v-if="!user">
                    <Link :href="route('register')" :class="[isActive('register') ? 'link-active' : '', menuLinkClasses]">Inscription</Link>
                    <Link :href="route('login')" :class="[isActive('login') ? 'link-active' : '', menuLinkClasses]">Connexion</Link>
                </template>
                <template v-else>
                    <Link :href="route('profile')" :class="[isActive('profile') ? 'link-active' : '', menuLinkClasses]">Profil</Link>
                    <button @click="logout" class="block deconnection py-1.5 text-sm w-full !rounded-none">Déconnexion</button>
                </template>
            </div>
        </nav>
    </header>
</template>

<script setup>
import ThemeSwitcher from './DarkMode.vue';
import GoogleTranslate from './GoogleTranslate.vue';
import AccountRoad from './AccountRoad.vue'
import { watch, computed, ref, onMounted, onUnmounted } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { handleScroll } from './../../shared/utils';
import { Inertia } from '@inertiajs/inertia';

const page = usePage();
const reloadLayout = computed(() => page.props.reloadLayout);

watch(
    () => reloadLayout.value,
    (newValue) => {
        if (newValue) {
            Inertia.reload({ only: ['auth'] });
        }
    },
);

const { baseUrl, auth, flash, showAccountRoad = false } = usePage().props;

const user = computed(() => auth?.user || null);

const menuOpen = ref(false);
const menuRef = ref(null);
const menuButtonRef = ref(null);

const commonClasses = 'btn transition duration-300 ease-in-out rounded';
const menuLinkClasses = 'btn block px-4 py-1.5 hover:text-green-200';

const isActive = (routeName) => {
    return route().current(routeName);
};

const logout = () => { Inertia.post('/logout'); };

const handleDocumentClick = (event) => {
  if (
    menuOpen.value &&
    menuRef.value && !menuRef.value.contains(event.target) &&
    menuButtonRef.value && !menuButtonRef.value.contains(event.target)
  ) {
    menuButtonRef.value.click();
  }
};

const profilePicture = ref('');
const fetchProfilePicture = () => {
    if (user.value?.picture) {
        profilePicture.value = user.value.picture.startsWith('https')
            ? user.value.picture
            : `${baseUrl}/profiles/${user.value.picture}`;
    } else {
        profilePicture.value = `${baseUrl}/profiles/default_user.png`;
    }
};

const observer = new MutationObserver(() => {
    handleScroll();
});
observer.observe(document.body, { childList: true, subtree: true, attributes: true });

onMounted(() => {
    fetchProfilePicture();
    window.addEventListener('scroll', handleScroll);

    const handleFlashMessages = (type, className) => {
        if (flash && flash[type]) {
            setTimeout(() => {
                document.querySelectorAll(`.${className}`).forEach(el => {
                    el.classList.add('fade-out');
                });
                setTimeout(() => {
                    flash[type] = null;
                }, 1000);
            }, 8000);
        }
    };

    handleFlashMessages('success', 'flash-success');
    handleFlashMessages('error', 'flash-error');

    document.addEventListener('click', handleDocumentClick);
});

onUnmounted(() => {
    window.removeEventListener('scroll', handleScroll);
    document.removeEventListener('click', handleDocumentClick);
});
</script>