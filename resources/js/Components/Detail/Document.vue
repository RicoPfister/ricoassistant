<template>
<div>
    <h2><b>Document</b></h2>
    <!-- <Link :href="route('document', {'category': 'fact'})">Document</Link> -->
    <!-- <Link :href="route('filter', {'category': 'exchange'})" class="underline flex flex-row"><b>Exchange</b><span class="hidden 2xl:block"></span></Link> -->
    <button @click.prevent="buttonDocument" type="button">Open Document</button>
</div>
</template>

<script setup>

import { Head, Link, useForm, useRemember } from '@inertiajs/inertia-vue3'
import { ref, onMounted, computed, watch  } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['id']);

function buttonDocument() {

    // console.log('ok');

    Inertia.visit('document', {
    method: 'post',
    data: {
        id: props.id,
    },
    })
}

</script>
