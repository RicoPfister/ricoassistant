<template>

<!-- heading loop-->
<div v-for="(item, index1) in props.data[index][1]" class="mt-1 flex flex-col">
    <div class="flex flex-row">
        <!-- main heading number -->
        <div class="justify-end w-5 h-[16px] flex items-center">{{ index+1 }}</div>
        <div class="h-[16px] w-5 flex items-center">{{ '.'+(index1+1) }}</div>
        <button @click.prevent="IndexSubHeadingOpen[props.index] = !IndexSubHeadingOpen[props.index]" class="h-[16px] flex items-center hover:text-lime-600" type="button">{{ props.data[index][1][index1][0] }}</button>

        <div class="relative grow mx-1 h-[16px] flex items-center">
            <div class="absolute -top-[2px] border-b-2 border-black border-dotted h-[16px] w-full"></div>
        </div>
        <div class="text-xs w-fit h-[16px] flex items-center">
            <div class="">[5]</div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
            </svg>
        </div>
    </div>

    <IndexSubHeading2 v-if="IndexSubHeadingOpen[props.index]" :index="props.index" :data="props.data" />
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch } from 'vue';

import IndexSubHeading2 from './IndexSubHeading2.vue';

const props = defineProps(['index', 'data']);

let IndexSubHeadingOpen = ref([]);

Object.keys(props.data[props.index]).forEach((key, i) => {

IndexSubHeadingOpen.value.push(0);

});

</script>
