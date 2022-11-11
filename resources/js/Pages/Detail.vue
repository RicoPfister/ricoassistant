<template>

<!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.title }}</h1>
    <div class="text-gray-400 text-sm">Video Game | 1986</div>
</div>

<!-- index container -->
<div class="">
    <!-- index title box -->
    <div @mouseover="indexMenuOpen = 1" @mouseleave="indexMenuOpen = 0" class="flex flex-row gap-1 items-center">

        <!-- title area -->
        <button @click="IndexCollapsState('switch')" class="flex flex-row items-center gap-1 hover:text-lime-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>

            <div>Index</div>
        </button>

        <!-- menu area -->
        <div v-show="indexMenuOpen" class="flex flex-row border">
            <button @click="IndexCollapsState(1)" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 leading-none hover:stroke-lime-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <button @click="IndexCollapsState(0)" type="button" class="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 leading-none hover:stroke-lime-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </button>

            <button @click="IndexShowOpen = !IndexShowOpen" type="button" class="">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 leading-none hover:stroke-red-600">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>


    </div>

    <!-- heading loop-->
    <div v-if="IndexShowOpen" v-for="(item, index) in headings" class="mt-2">
        <div class="flex flex-row">
            <!-- main heading number -->
            <div class="justify-end w-5 h-[16px] flex items-center">{{ index + 1}}</div>
            <div class="h-[16px] w-5 flex items-center"></div>
            <button @click.prevent="IndexSubHeadingOpen[index] = !IndexSubHeadingOpen[index]" class="h-[16px] flex items-center font-bold hover:text-lime-600" type="button">{{ item[0] }}</button>

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

        <IndexSubHeading v-if="IndexSubHeadingOpen[index]" :index="index"/>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading from '../Components/Detail/IndexSubHeading.vue'

const props = defineProps(['detail']);

let detailData = ref(['']);

let IndexSubHeadingOpen = ref([]);
let indexMenuOpen = ref(0);
let indexMenuOpenSwitcher = ref('open');
let IndexShowOpen = ref(1);

let headings = ref([]);
headings.value[0] = ['Arrangement'];
headings.value[0][1] = [];
headings.value[0][1][0] = 'Idea';
headings.value[0][1][1] = 'Resource';
// headings[0][1] = 'Idea';
// headings[1] = 'Realisation';
headings.value[1] = ['Realisation'];
headings.value[2] = ['Impact'];
headings.value[3] = ['Source'];
headings.value[4] = ['Source'];
headings.value[5] = ['Source'];
headings.value[6] = ['Source'];
headings.value[7] = ['Source'];
headings.value[8] = ['Source'];
headings.value[9] = ['Source'];
headings.value[10] = ['Source'];
// headings[2] = 'Impact';
// headings[3] = 'Source';
// headings[3][0] = 'Impressions';

// console.log(headings.value);

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

Object.keys(headings.value).forEach((key, i) => {

    IndexSubHeadingOpen.value.push(0);

    // console.log(i);
});

// console.log(IndexSubHeadingOpen.value);

function IndexCollapsState(n) {

    if (n == 'switch') {

        switch (indexMenuOpenSwitcher.value) {

            case 'open':
                IndexShowOpen.value = 1;
                n = 1;
                indexMenuOpenSwitcher.value = 'close';
                break;

            case 'close':
                n = 0;
                indexMenuOpenSwitcher.value = 'hide';
                break;

            case 'hide':
                IndexShowOpen.value = 0;
                indexMenuOpenSwitcher.value = 'open';
                break;
        }

    }

    Object.keys(IndexSubHeadingOpen.value).forEach((key, i) => {
        IndexSubHeadingOpen.value[key] = n;
        console.log(i);
    });

}

</script>
