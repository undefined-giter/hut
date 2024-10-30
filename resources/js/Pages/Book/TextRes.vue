<template>
    <div class="mb-6">
      <p class="mb-6 text-lg text-justify">Bienvenue dans notre cabane de luxe située au cœur de la nature. Offrez-vous un séjour inoubliable dans une cabane équipée d'un <strong>jacuzzi privatif</strong>, parfaite pour un moment de détente loin du stress quotidien. Profitez d'une <strong>vue à couper le souffle</strong> tout en étant entouré par la beauté de la nature. Notre cabane est idéale pour une <strong>escapade romantique</strong>, un week-end détente ou encore une petite pause bien méritée.
        <br><span class="underline">Partique :</span> Dégustez un bon repas parmis les restaurants ou prennez une pizza dans l'un des deux camions de pizza à proximité.</p>
  
      <p class="text-lg text-justify">Vous avez le choix entre une <strong>location pour une nuit</strong> ou plusieurs nuits pour un séjour prolongé. Nos <strong>tarifs</strong> s'adaptent en fonction de la durée de votre séjour : <strong>{{ PRICE_PER_NIGHT }}€/nuit</strong> pour une nuit et <strong>{{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€/nuit</strong> pour les séjours de deux nuits ou plus. <strong>Le parking est inclus</strong> pour toute réservation, ainsi que les taxes d'habitation et de séjour.</p>
    </div>

    <h2>Nos Services Offerts</h2>
    <div class="max-w-xl mx-auto text-left mb-6">
      <ul class="ml-20 md:ml-36 list-disc list-inside">
        <li class="p">Jacuzzi privatif chauffé sur votre terrasse</li>
        <li class="p">Vue panoramique sur les montagnes</li>
        <li class="p">Parking gratuit</li>
        <li class="p">Bienveillance</li>
        <li class="p">Wi-Fi</li>
      </ul>
    </div>

    <h2>Ce que disent nos clients</h2>
    <div class="mb-6 text-center">
      <p class="italic">"Un endroit incroyable pour se ressourcer. Le jacuzzi avec vue sur les montagnes est tout simplement magique !" — <strong>Lorie et Mickaël</strong></p>
      <p class="italic mt-2">"Nous avons passé un week-end inoubliable. La cabane est magnifique et le service est impeccable. Nous reviendrons !" — <strong>Sophie et Thomas</strong></p>
    </div>

    <div class="flex justify-between">
      <p class="text-lg">Location pour une nuit : {{ PRICE_PER_NIGHT }}€, location par nuit pour 2 nuits et plus : {{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€.</p>
      <p class="text-lg">Parking inclus</p>
    </div>
</template>

<script setup>
import { defineProps, watch } from 'vue';

const props = defineProps({
  PRICE_PER_NIGHT: {
    type: Number,
    default: 160,
  },
  PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS: {
    type: Number,
    default: 120,
  },
});
</script>