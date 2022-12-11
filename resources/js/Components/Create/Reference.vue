<template>

<div>
    <div class="flex flex-col">
        <button class="flex flex-row justify-between items-center" type="button">
            <label class="font-bold" aria-label="Statement Input" for="statement">Reference
            </label>
            <!-- <MenuEntry /> -->
        </button>

        <div class="flex flex-row items-center border border-black h-fit">
            <button class="w-8 flex justify-center items-center bg-gray-100 border-r border-gray-300 h-fit" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-fit h-fit p-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
            <div class="grow">
                <input class="outline-0 focus:ring-0 border-none focus:placeholder-transparent w-full leading-none h-8" type="text" placeholder="" ref="referenceDOM" v-model="reference">
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

let reference = ref('');
let referenceDOM = ref('');

const props = defineProps(['fromController', 'toParent', 'toChild']);

// import MenuEntry from "./MenuEntry.vue";

watch(() => props.referenceChecker, (curr, prev) => {

console.log('ok');

}, {deep: true}, 500);

watch(() => props.toChild.basicTitle, _.debounce( (curr, prev) => {

if (!reference.value) referenceDOM.value.placeholder = props.toChild.basicTitle;

}, 500));

</script>

