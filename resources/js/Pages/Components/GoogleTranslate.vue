<template>
    <div id="google_translate_element"></div>
    <div>
        <img 
            id="worldImg"
            src='storage/world.png'
            alt="Translate" 
            @click="openDropdown" 
            style="width: 26px; height: 26px;"
            class="transform transition-transform duration-300 hover:scale-110 origin-top-right cursor-pointer"
        />
    </div>
</template>

<script setup>
import { onMounted } from 'vue';

const openDropdown = () => {
    if (window.innerWidth < 768) {
        const googleTradWaiter = document.querySelector('#googleTradWaiter');
        if (googleTradWaiter) {
            const googleTranslateElement = document.querySelector('#google_translate_element');
            
            if (!googleTradWaiter.contains(googleTranslateElement)) {
                googleTradWaiter.appendChild(googleTranslateElement);
            }

            googleTranslateElement.style.display = 'block';
        }
    } else {
        const googleTranslateElement = document.querySelector('#google_translate_element');
        if (googleTranslateElement) {
            googleTranslateElement.style.display = 'block';
        }
    }

    document.querySelector('#worldImg').style.display = 'none';
    document.querySelector("#\\:0\\.targetLanguage > img").style.display = 'none';
    document.querySelector("#\\:0\\.targetLanguage").style.height = '20px';
    document.querySelector("#\\:0\\.targetLanguage > span > a > span:nth-child(5)").style.display = 'none';
    document.querySelector('#google_translate_element > div').style.height = '0';
    document.querySelector("#\\:0\\.targetLanguage").style.backgroundColor = 'blue';
    document.querySelector("#\\:0\\.targetLanguage > span > a").style.color = '#b07501';
    document.querySelector("#\\:0\\.targetLanguage").style.border = 'none';

    setInterval(() => {
        const targetElement = document.querySelector("#\\:2\\.container");
        const overInfos = document.querySelector("goog-gt-tt");
        const overInfos2 = document.querySelector(".VIpgJd-suEOdc");
        const overInfos3 = document.querySelector(".VIpgJd-yAWNEb-L7lbkb");
        if (targetElement) {
            targetElement.style.display = 'none';
            if (overInfos) overInfos.style.display = 'none';
            if (overInfos2) overInfos2.style.display = 'none';
            if (overInfos3) overInfos3.style.display = 'none';
        }
    }, 1500);
};

onMounted(() => {
    const googleTranslateScript = document.createElement('script');
    googleTranslateScript.src = "//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit";
    googleTranslateScript.async = true;
    document.head.appendChild(googleTranslateScript);

    document.querySelector('#google_translate_element').style.display = 'none';

    window.googleTranslateElementInit = () => {
        if (window.google && window.google.translate) {
            new window.google.translate.TranslateElement({
                pageLanguage: 'fr',
                includedLanguages: 'en,fr,frp,fr-CA,fr-CH,oc,ru,co,eu,de,it,es,pt-PT,nl,pl,sv,da,no,fi,et,lv,lt,sk,sl,hu,el,bg,ro,hr,sr,sq,mk,mt,ga,gl,ca',
                layout: window.google.translate.TranslateElement.InlineLayout.SIMPLE,
                autoDisplay: false
            }, 'google_translate_element');
        } else {
            console.error('Google Translate API failed to load.');
        }
    };
});
</script>
