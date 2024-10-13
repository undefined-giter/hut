<template>
    <div id="google_translate_element" class="!mt-2.5"></div>
    <div class="!mt-1.5">
        <img 
            id="worldImg"
            :src="`${baseUrl}/world.png`"
            loading="lazy"
            alt="Translate" 
            @click="openDropdown" 
            style="width: 26px; height: 26px;"
            class="hidden md:block transform transition-transform duration-300 hover:scale-110 origin-top-right cursor-pointer"
        />
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { baseUrl } = usePage().props;

const openDropdown = () => {
    const worldImg = document.querySelector('#worldImg');
    const googleTranslateElement = document.querySelector('#google_translate_element');

    if (window.innerWidth < 768) {
        const googleTradWaiter = document.querySelector('#googleTradWaiter');
        if (googleTradWaiter && googleTranslateElement) {
            if (!googleTradWaiter.contains(googleTranslateElement)) {
                googleTradWaiter.appendChild(googleTranslateElement);
            }

            googleTranslateElement.style.display = 'block';
        }
    } else {
        if (googleTranslateElement) {
            googleTranslateElement.style.display = 'block';
        }
    }

    if (worldImg) {
        worldImg.style.display = 'none';
    }

    const targetLanguage = document.querySelector("#\\:0\\.targetLanguage");
    if (targetLanguage) {
        const targetLanguageImg = targetLanguage.querySelector('img');
        const targetLanguageSpan = targetLanguage.querySelector('span > a > span:nth-child(5)');

        if (targetLanguageImg) targetLanguageImg.style.display = 'none';
        if (targetLanguageSpan) targetLanguageSpan.style.display = 'none';

        targetLanguage.style.height = '20px';
        targetLanguage.style.backgroundColor = 'blue';
        targetLanguage.style.border = 'none';

        const targetLanguageLink = targetLanguage.querySelector('span > a');
        if (targetLanguageLink) {
            targetLanguageLink.style.color = '#b07501';
        }
    }

    const googleTranslateElementDiv = googleTranslateElement?.querySelector('div');
    if (googleTranslateElementDiv) {
        googleTranslateElementDiv.style.height = '0';
    }

    setInterval(() => {
        const targetElement = document.querySelector("#\\:2\\.container");
        if (targetElement) {
            targetElement.style.display = 'none';
        }
    }, 1500);
};


onMounted(() => {
    const googleTranslateScript = document.createElement('script');
    googleTranslateScript.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    googleTranslateScript.async = true;
    document.head.appendChild(googleTranslateScript);

    window.googleTranslateElementInit = () => {
        if (window.google && window.google.translate) {
            new window.google.translate.TranslateElement({
                pageLanguage: 'fr',
                includedLanguages: 'en,fr,frp,fr-CA,fr-CH,oc,ru,co,eu,de,it,es,pt-PT,nl,pl,sv,da,no,fi,et,lv,lt,sk,sl,hu,el,bg,ro,hr,sr,sq,mk,mt,ga,gl,ca',
                layout: window.google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
            
            const googleTranslateElement = document.querySelector('#google_translate_element');
            if (googleTranslateElement) {
                googleTranslateElement.style.display = 'none';
            }
        } else {
            console.error('Google Translate API failed to load.');
        }
    };
});
</script>
