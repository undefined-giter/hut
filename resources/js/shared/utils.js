export function checkCharacterCount(text, maxLength) {
    const modifiedText = text.replace(/\r?\n/g, '  ');
    const actualLength = modifiedText.length;

    if (actualLength > maxLength) {
        return {
            valid: false,
            message: `Limite de ${actualLength}/${maxLength} caractères atteinte.`,
            remaining: 0,
        };
    }

    const remainingCharacters = maxLength - actualLength;

    return {
        valid: true,
        message: `${actualLength}/${maxLength} caractères utilisés.`,
        remaining: remainingCharacters,
    };
}


import { reactive, ref } from 'vue';

export const showFooter = ref(false);

export const handleScroll = () => {
  const windowHeight = window.innerHeight;
  const documentHeight = document.documentElement.scrollHeight;
  const scrollTop = window.scrollY || window.pageYOffset;

  showFooter.value = windowHeight + scrollTop >= documentHeight - 40;
};


const unrolledStates = reactive({});

export function useUnroll() {

  const toggleUnroll = (id) => {
    if (unrolledStates[id] === undefined) {
      unrolledStates[id] = false;
    }

    unrolledStates[id] = !unrolledStates[id];

    handleScroll();
  };

  const isUnrolled = (id) => {
    return !!unrolledStates[id];
  };

  const setUnroll = (id, value) => {
    unrolledStates[id] = value;
  };

  return { isUnrolled, toggleUnroll, setUnroll };
}