<template>
  <div class="mb-6">
    <p class="mb-6 text-lg text-justify">Bienvenue dans notre cabane de luxe située au cœur de la nature. Offrez-vous un séjour inoubliable dans une cabane équipée d'un <strong>jacuzzi privatif</strong>, parfaite pour un moment de détente loin du stress quotidien. Profitez d'une <strong>vue à couper le souffle</strong> tout en étant entouré par la beauté de la nature. Notre cabane est idéale pour une <strong>escapade romantique</strong>, un week-end détente ou encore une petite pause bien méritée.</p>

    <p class="text-lg text-justify">Vous avez le choix entre une <strong>location pour une nuit</strong> ou plusieurs nuits pour un séjour prolongé. Nos <strong>tarifs</strong> s'adaptent en fonction de la durée de votre séjour : <strong>{{ PRICE_PER_NIGHT }}€/nuit</strong> pour une nuit et <strong>{{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€/nuit</strong> pour les séjours de deux nuits ou plus.<span v-show="PERCENT_REDUCED_WEEK !== 0"> De plus, il y a une <strong>{{ PERCENT_REDUCED_WEEK > 0 ? 'réduction de ' + PERCENT_REDUCED_WEEK : 'augmentation de +' + String(PERCENT_REDUCED_WEEK).slice(1) }}% pour les nuits de semaine</strong>, de lundi 14h à vendredi 12h.</span> Le parking est inclus pour toute réservation, ainsi que les taxes d'habitation et de séjour et équipements de sécurité.</p>
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
          <li class="p">Détente au lac à 10 minutes<span class="md:hidden">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span></li>
          <li class="p">Randonnées en montagne</li>
          <li class="p">Cueillir des champignons</li>
          <li class="p">Villages pittoresques</li>
          <li class="p">Faune & flore locale</li>
          <li class="p">Restaurants locaux</li>
          <li class="p">Balade en vélo</li>
        </ul>
      </div>
    </div>
  </div>
  <br>

  <div class="flex justify-between text-sm">
    <p class="hidden md:block">Location pour une nuit : {{ PRICE_PER_NIGHT }}€, location par nuit pour 2 nuits et plus : {{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€.</p>
    <p class="block md:hidden">1 nuit : {{ PRICE_PER_NIGHT }}€, 2+ nuits : {{ PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS }}€/nuit</p>
    <p v-show="PERCENT_REDUCED_WEEK !== 0">{{ PERCENT_REDUCED_WEEK > 0 ? '-' + PERCENT_REDUCED_WEEK : '+' + String(PERCENT_REDUCED_WEEK).slice(1) }}% en semaine</p>
    <p class="text-right">Parking gratuit</p>
  </div>
</template>


<script setup>
const props = defineProps({
  PRICE_PER_NIGHT: {
    type: Number,
    default: 160,
  },
  PRICE_PER_NIGHT_FOR_2_AND_MORE_NIGHTS: {
    type: Number,
    default: 120,
  },
  PERCENT_REDUCED_WEEK: {
    type: Number,
    default: 10,
  },
});
</script>