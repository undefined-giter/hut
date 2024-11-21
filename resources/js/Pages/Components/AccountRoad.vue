<template>
    <div v-show="visible" class="notification" :class="{ 'fade-out': fadeOut }">
        <div class="notification-arrow"></div>
        Retrouvez vos réservations et profil ici
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const visible = ref(true);
const fadeOut = ref(false);

onMounted(() => {
    const timeout = setTimeout(() => {
        fadeOut.value = true;
        setTimeout(() => {
            visible.value = false;
        }, 1000);
    }, 5000);

    return () => clearTimeout(timeout);
});
</script>
  
<style>
.notification {
  position: absolute;
  top: 10px; /* Ajuste la position pour qu'il ne touche pas le bord supérieur */
  left: 60px; /* Ajuste pour les petits écrans */
  width: 250px; /* Largeur par défaut */
  max-width: 90%; /* Empêche le dépassement sur les petits écrans */
  background-color: #2ecc71; /* Couleur verte plus douce pour le fond */
  border-radius: 10px; /* Bordures arrondies */
  padding: 20px; /* Plus d'espace autour du texte */
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Ombre pour mieux se démarquer */
  font-family: Arial, sans-serif;
  font-size: 18px; /* Texte légèrement plus grand */
  line-height: 1.5; /* Espacement entre les lignes */
  color: #fff; /* Texte blanc */
  z-index: 1000;
  opacity: 1;
  transform: translateY(0);
  transition: transform 0.5s ease, opacity 1s ease;
  text-align: center; /* Centrer le texte */
}

.notification.fade-out {
  opacity: 0;
  transform: translateY(-50px);
}

.notification-arrow {
  position: absolute;
  top: 6px; /* Place la flèche légèrement plus bas */
  left: -10px; /* Flèche toujours à gauche */
  width: 0;
  height: 0;
  border-top: 10px solid transparent;
  border-bottom: 10px solid transparent;
  border-right: 10px solid #2ecc71; /* Même couleur que le rectangle */
}

@media (max-width: 768px) {
  .notification {
    top: -4px; /* Descend légèrement pour être visible */
    left: 70px; /* Ajuste pour ne pas déborder */
    width: auto; /* Largeur adaptative */
    max-width: 90%; /* S'assure que le rectangle ne dépasse pas */
    padding: 15px; /* Réduit le padding sur les petits écrans */
    font-size: 14px; /* Texte légèrement plus petit */
  }

  .notification-arrow {
    top: 8px; /* Ajuste pour rester aligné */
    left: -10px;
  }
}
</style>