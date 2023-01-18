<template>
<Head>
<title>Rico Assistant</title>
<meta name="Rico Assistant" content="Rico Assistant">
<!-- adobe lato font -->
<link rel="stylesheet" href="https://use.typekit.net/siz6ddj.css">

<!-- google Rubik Dirt font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Rubik+Dirt&display=swap" rel="stylesheet">

</Head>

<!-- <Home class="mx-auto"/> -->
<Frame />

</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3'
import { Link } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed  } from 'vue';

import Home from '../Pages/Home.vue'
import Frame from "../Layouts/MainNav.vue"

let menuboxOpenActive = ref(0);
let addboxOpenActive = ref(0);

</script>

