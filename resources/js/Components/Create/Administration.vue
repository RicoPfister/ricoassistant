<template>

<div class="flex gap-3 flex-wrap w-full min-w-0">

<div class="flex flex-col">
    <label aria-label="Referenced Date Input" for="acc_date">Date*:</label>
    <input class="w-[141px]" id="acc_date" placeholder="Search" type="date" v-model="dataChild['basicRefDate']">
</div>

<div class="flex flex-col min-w-0 grow">
    <label aria-label="Author Input" for="author">Author*:</label>
    <input class="min-w-0" type="text" id="author">
</div>

</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

// Date now
const dateData = new Date();
const year  = dateData.getFullYear();
const month = (dateData.getMonth() + 1).toString().padStart(2, "0");
const day = dateData.getDate().toString().padStart(2, "0");
const dateNow = year+'-'+month+'-'+day;

let basicTitelPickerOpen = ref(0);
let basicTitleWarning = ref(0);

let dataChild = ref({'basicRefDate': dateNow, 'basicAuthor': ''});

const props = defineProps(['dataParent']);
let emit = defineEmits(['dataChild']);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

// processing parent props
watch(() => props.dataParent, (curr, prev) => {

    // cl(props.dataParent.basicTitleData[0].warning);

    if (props.dataParent.basicTitleData[0].warning > 0) {
        basicTitleWarning.value = 1;
    }
    basicTitelPickerOpen.value = props.dataParent.basicTitelPickerOpen;
    // basicTitleWarning.value =

}, {deep: true}, 500);

// testing
// **************************************************

function cl(log) {
    // alert(log)
    if (typeof log == 'undefined') console.log('Testlog');
    else console.log('Testlog: ' + log);
}

function keyPress(event) {
    if (event.ctrlKey && event.altKey && event.key === 'a') {
        console.log('Testlog: ' + log);
        };
}

</script>
