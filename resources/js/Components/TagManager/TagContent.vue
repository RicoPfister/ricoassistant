<template>

<div v-if="0" class="h-[calc(100%-35px)] flex items-center justify-center flex-col gap-y-5">
    <h1 class="font-bold">Welcome to the Tag Manager!</h1>
    <p>Here you can choose tags grouped in categories.</p>
    <p>Then you can value the tags and add an discription.</p>
    <p>Let's start by adding the first tag!</p>
</div>

<div class="h-auto flex flex-row bg-gray-100">
        <div class="px-3 flex items-center border-r border-b border-gray-400 w-[200px]">Tags for Entry:</div>
        <div class="px-3 flex items-center border-r border-b border-gray-400 grow"></div>
    </div>

<div v-for="(item, index) in tagArray" class="flex flex-col">
    <div class="h-auto flex flex-row">
        <div class="px-3 flex items-center border-r border-b border-gray-400 w-[200px]">{{ item }}</div>
        <div class="px-3 flex items-center border-r border-b border-gray-400 w-[150px]"></div>
        <div class="flex flex-row justify-between pl-3 pr-1 items-center border-r border-b border-gray-400 grow">
            <div class=""></div>

            <!-- remove button -->
            <button @click="removeTagFromList(index)" class="" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";
import contentBox from "./TagContent.vue";

let props = defineProps(['dataParent']);
let tagCollection = ref([['Presets', ['Presets', 'Test A2']], ['Characteristics', ['Test B1', 'Test B2']], ['Administration', ['Lost', 'Lent', 'Rent']], ['Rating Mood', ['Test B1', 'Test B2']], ['Rating Item', ['Test B1', 'Test B2']], ['Rating Media', ['Test B1', 'Test B2']]]);
let tagArray = ref([]);

// basic title response
watch(() => props.dataParent, _.debounce( (curr, prev) => {

tagArray.value.push(tagCollection.value[props.dataParent[0]][1][props.dataParent[1]]);

}, 500));

function removeTagFromList(index) {
    tagArray.value.splice(index, 1);
}

</script>
