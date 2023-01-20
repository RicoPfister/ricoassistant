<template>

    <div class="absolute top-0 left-0 bg-white opacity-90 h-screen w-screen z-40"></div>

    <button @click="$emit('MessagePopUpOpen')" class="absolute top-0 left-0 w-full h-16 flex items-center justify-center bg-lime-600 text-lg z-50">

        <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg> -->


        <div>{{ $page.props.flash.message }}</div>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 ml-3">
  <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
</svg>

</div>
        <!-- <div class="">Close</div> -->
    </button>

</template>

<script setup>

import { Link } from "@inertiajs/inertia-vue3";



</script>
