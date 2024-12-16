<template>
  <transition name="modal">
    <div v-if="showModal" class="modal-overlay">
      <div class="modal-content mx-2">
        <h2 class="md:mt-0">Renseignez Votre Téléphone</h2>
        <p class="ml-0.5 -mt-2.5 md:mt-0">Optionnel mais recommandé</p>
        <input
          v-model="phone"
          type="tel"
          maxlength="10"
          placeholder="Numéro de téléphone"
          @input="handlePhoneInput"
        />
        <p v-if="phoneError" class="!text-red-600">{{ phoneError }}</p>
        <div class="flex justify-between mt-1">
          <button @click="closeModal" class="btn">Ne pas renseigner</button>
          <button @click="submitPhone" :disabled="!isPhoneValid" class="btn">Ajouter Numéro</button>
        </div>
      </div>
    </div>
  </transition>

  <transition name="fade">
    <p v-if="showConfirmation" class="confirmation-message">Merci !</p>
  </transition>

  <transition name="fade">
    <p v-if="showPhoneReminder" class="reminder-message">Pensez à renseigner votre numéro de téléphone dans votre profil pour améliorer votre expérience.</p>
  </transition>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { validatePhone } from './../../shared/utils.js';
import axios from 'axios';

const showModal = ref(false);
const phone = ref('');
const phoneError = ref(null);
const showConfirmation = ref(false);
const showPhoneReminder = ref(false);

const isPhoneValid = computed(() => {
  const { isValid } = validatePhone(phone.value);
  return isValid;
});

const handlePhoneInput = () => {
  phone.value = phone.value.replace(/\D/g, '').slice(0, 10);
  const { isValid, error } = validatePhone(phone.value);
  phoneError.value = error;
};

const closeModal = () => {
  if (!phone.value) {
    showPhoneReminder.value = true;
    setTimeout(() => {
      showPhoneReminder.value = false;
    }, 8000);
  }

  phone.value = '';
  phoneError.value = null;
  showModal.value = false;
};

const handleOutsideClick = (event) => {
  const modalContent = document.querySelector('.modal-overlay');
  if (modalContent && !modalContent.contains(event.target)) {
    closeModal();
  }
};

const submitPhone = async () => {
  if (isPhoneValid.value) {
    try {
      await axios.patch('/update-phone', { phone: phone.value });
      closeModal();
      showConfirmationMessage();
      showPhoneReminder.value = false;
    } catch (error) {}
  }
};

const showConfirmationMessage = () => {
  showConfirmation.value = true;
  setTimeout(() => {
    const confirmationElement = document.querySelector('.confirmation-message');
    if (confirmationElement) {
      confirmationElement.classList.add('fade-out');
    }
  }, 5000);
  setTimeout(() => {
    showConfirmation.value = false;
  }, 6000);
};

const checkUserPhone = async () => {
  try {
    const response = await axios.get('/get-phone');
    if (!response.data.phone) {
      showModal.value = true;
    }
  } catch (error) {}
};

onMounted(() => {
  checkUserPhone();
  document.addEventListener('click', handleOutsideClick);
});

onUnmounted(() => {
  document.removeEventListener('click', handleOutsideClick);
});
</script>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 60px;
  left: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 250;
  height: 220px;
  @apply bg-orangeTheme bg-opacity-75;
}

.modal-content {
  padding: 18px;
  border-radius: 1em;
  width: 400px;
  height: 210px;
  @apply bg-light dark:bg-dark rounded-lg bg-opacity-100 dark:bg-opacity-100;
}

.modal-enter-active, .modal-leave-active { transition: opacity 1s ease, transform 1s ease; }
.modal-enter-from, .modal-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}

.fade-enter-active, .fade-leave-active { transition: opacity 1s ease-in-out; }

.confirmation-message, .reminder-message {
  position: fixed;
  top: 64px;
  left: 50%;
  transform: translateX(-50%);
  padding: 10px 20px;
  background-color: #4caf50;
  font-weight: bold;
  opacity: 1;
  transition: opacity 0.3s ease-in-out;
  z-index : 150;
  color: #ccc;
  border-radius: 1em;
}

.confirmation-message.fade-out, .fade-enter-from, .fade-leave-to, .modal-enter-from, .modal-leave-to { opacity: 0; }

.reminder-message { @apply bg-orangeTheme; }
</style>
