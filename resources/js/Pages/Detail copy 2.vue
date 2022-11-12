<template>

<!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.title }}</h1>
    <div class="text-gray-400 mb-5">Video Game | 1986</div>
</div>

<!-- index container -->
<div>
    <div>Index</div>

    <!-- heading loop-->
    <div v-for="(item, index) in headings[0]" :style="{'margin-top': headings[1][index] == undefined ? '10px' : '', 'font-weight': headings[1][index] == undefined ? 'bold' : '', 'font-size': textSizeHeading(index)}" class="flex flex-row">
        <!-- main heading number -->
        <div class="justify-end w-6 h-[16px] flex items-center">{{ headings[0][index] }}</div>
        <div class="h-[16px] w-7 flex items-center">{{ headings[1][index] }}</div>
        <button type="button" :style="{'font-weight': fontWeightHeading}" class="pl-2 w-fit h-[16px] flex items-center">{{ headings[2][index] }}</button>
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
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading from '../Components/Detail/IndexSubHeading.vue'

const props = defineProps(['detail']);

let detailData = ref(['']);

let headings = ref('');
headings[0] = 'Arrangement';
headings[0][0] = 'Idea';
headings[0][1] = 'Resource';
headings[1] = 'Realisation';
headings[2] = 'Impact';
headings[3] = 'Source';
headings[3][0] = 'Impressions';

onMounted(() => {
    detailData.value = props.detail;
});

watch(() => props.detail, _.debounce( (curr, prev) => {
    detailData.value = props.detail;
}, 500)
);

function textSizeHeading(index) {

    // console.log(typeof headings.value[1][0]);

     if (typeof headings.value[1][index] != 'undefined') {
         if (headings.value[1][index].search(/\.%\./g) != -1) {
             return '14px';
         }
    }
}

</script>
