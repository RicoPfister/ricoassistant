
<template>

<div>
    <div class="flex flex-col">

        <div class="flex flex-row justify-between items-center" type="button">

            <label class="" aria-label="Statement Input" for="statement">Guidance*: </label>

            <MenuEntry @data-child="dataChildMenuEntry"/>

        </div>

        <textarea class="border border-black outline-0 focus:border-black focus:ring-0" v-model="dataChild['statement']" rows="10" id="statement" type="text"></textarea>

    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";

let dataChild = ref({'statement': ''});

const props = defineProps(['dataParent', 'dataChild']);
let emit = defineEmits(['dataChild']);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

function dataChildMenuEntry(n) {
    // alert(n['formDataEdit']);
    emit('dataChild', {'formDataEdit': n['formDataEdit']});
}

</script>

