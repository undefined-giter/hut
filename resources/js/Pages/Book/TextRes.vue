<template>
  <div class="mb-6">
    <p class="mb-6 text-lg text-justify">Bienvenue dans notre cabane de luxe située au cœur de la nature. Offrez-vous un séjour inoubliable dans une cabane équipée d'un <strong>jacuzzi privatif</strong>, parfaite pour un moment de détente loin du stress quotidien. Profitez d'une <strong>vue à couper le souffle</strong> tout en étant entouré par la beauté de la nature. Notre cabane est idéale pour une <strong>escapade romantique</strong>, un week-end détente ou encore une petite pause bien méritée.</p>

    <p class="text-lg text-justify">Vous avez le choix entre une <strong>location pour une nuit</strong> ou plusieurs nuits pour un séjour prolongé. Nos <strong>tarifs</strong> s'adaptent en fonction de la durée de votre séjour : <strong>{{ PRICE_PER_NIGHT }}€/nuit</strong> pour une nuit et <strong>{{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€/nuit</strong> pour les séjours de deux nuits ou plus. <strong>Le parking est inclus</strong> pour toute réservation, ainsi que les taxes d'habitation et de séjour.</p>
  </div>

  <div class="flex flex-col md:flex-row">
    <div class="w-full flex flex-col items-center">
      <h2 class="text-xl font-bold text-center">Nos Services Offerts</h2>
      <div class="w-full flex justify-center">
        <ul class="list-disc list-inside space-y-2">
          <li class="p">Vue panoramique sur les montagnes</li>
          <li class="p">Jacuzzi chauffé sur votre terrasse</li>
          <li class="p">Bienveillance</li>
          <li class="p">Parking</li>
          <li class="p">Wi-Fi</li>
        </ul>
      </div>
    </div>
    <br>

    <div class="w-full flex flex-col items-center">
      <h2 class="text-xl font-bold text-center">Activités à Faire aux Alentours</h2>
      <div class="w-full flex justify-center">
        <ul class="list-disc list-inside grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
          <li class="p">Détente au lac à 10 minutes <span class="md:hidden">             </span></li>
          <li class="p">Randonnée en montagne</li>
          <li class="p">Aller aux champignons</li>
          <li class="p">Villages pittoresques</li>
          <li class="p">Restaurants locaux</li>
          <li class="p">Balade en vélo</li>
          <li class="p">Faune locale</li>
        </ul>
      </div>
    </div>
  </div>
  <br>

  <h2>Ce que Disent nos Hôtes</h2>
  <div class="mb-6 text-center">
    <p class="italic">"Un endroit incroyable pour se ressourcer. Le jacuzzi avec vue sur les montagnes est tout simplement magique !" — <strong>Lorie et Mickaël</strong></p>
    <p class="italic mt-2">"Nous avons passé un week-end inoubliable. La cabane est magnifique et le service est impeccable. Nous reviendrons !" — <strong>Sophie et Thomas</strong></p>
  </div>

  <div class="flex justify-between">
    <p class="hidden mb:block text-lg">Location pour une nuit : {{ PRICE_PER_NIGHT }}€, location par nuit pour 2 nuits et plus : {{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€.</p>
    <p class="block text-sm md:hidden">1 nuit : {{ PRICE_PER_NIGHT }}€, 2 nuits et plus : {{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€/nuit</p>
    <p class="text-sm md:text-lg">Parking inclus</p>
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