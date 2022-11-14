<template>

<!-- heading loop-->
<div v-for="(item, index1) in props.data[props.index][1]" class="flex flex-col" :style="{ 'margin-top': index1 == 0 ? '1px' : '', 'margin-bottom': index1+1 == props.data[props.index][1].length ? '3px' : ''}">
    <div class="flex flex-row">

        <!-- heading number -->
        <div class="justify-end h-[16px] w-[18px] flex items-center text-sm">{{ props.index + 1 }}</div>
        <div class="h-[16px] w-[35px] flex items-center text-sm">{{ '.'+(index1 + 1 ) }}</div>
        <div @mouseover="indexLink1[index1] = 1" @mouseleave="indexLink1[index1] = 0"
            class="flex flex-row h-[16px]">

            <!-- heading text button -->
            <button v-if="typeof props.data[props.index][1][index1][1] != 'undefined'" @click.prevent="IndexSubHeadingOpen[index1] = !IndexSubHeadingOpen[index1]"
                class="h-[16px] flex items-center hover:text-lime-600 text-sm font-bold ml-1"
                type="button">
                {{ props.data[props.index][1][index1][0] }}
            </button>

            <!-- heading text non-button -->
            <div v-else
                class="h-[16px] flex items-center text-sm font-bold ml-1 cursor-default"
                type="button" :disabled="typeof props.data[props.index][1][index1][1] != 'undefined' ? 0 : 1">
                {{ props.data[props.index][1][index1][0] }}
            </div>

            <!-- link button -->
            <button v-show="indexLink1[index1]">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 hover:stroke-lime-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </button>
        </div>

        <!-- leading dots -->
        <div v-if="typeof item[1] != 'undefined'" class="flex flex-row grow">

            <!-- leading dots -->
            <div class="relative grow mx-1 h-[16px] flex items-center">
                <div class="absolute -top-[2px] border-b border-black border-dotted h-[16px] w-full"></div>
            </div>

            <!-- infos / collaps icon -->
            <div class="text-sm w-fit h-[16px] flex items-center">
                <div class="">
                    {{ typeof props.data[props.index][1][index1][1] != 'undefined' ? props.data[props.index][1][index1][1].length : '' }}</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </div>
        </div>
    </div>

    <IndexSubHeading2 v-if="IndexSubHeadingOpen[index1]" :data="props.data" :index="props.index" :index1="index1"/>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch } from 'vue';

import IndexSubHeading2 from './IndexSubHeading2.vue';

const props = defineProps(['index', 'data']);

let IndexSubHeadingOpen = ref([]);
let indexLink1 = ref([0]);
let headingWidthArray = ref();
let headingWidth = ref();

Object.keys(props.data[props.index]).forEach((key, i) => {

IndexSubHeadingOpen.value.push(0);

});

</script>
