<template>
    <Head title="Stripe Payement | Cabane" />
  
    <Layout>
        <h1>Paiement</h1>

        <p>Montant à payer : <strong>{{ $amount }} €</strong></p>

        <form action="{{ route('stripe.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="amount" value="{{ $amount }}">
            <button type="submit" class="btn">Payer avec Stripe</button>
        </form>
    </Layout>
  </template>
  
  <script setup>
  import Layout from './../Layout.vue';
  import { Head } from '@inertiajs/vue3';
  