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
    <div v-if="IndexShowOpen" v-for="(item, index) in headings" class="mb-3 mt-2 flex flex-col">
        <div class="flex flex-row">
            <!-- main heading number -->
            <div class="justify-end w-10 h-[16px] flex items-center">{{ index + 1}}</div>
            <div class="h-[16px] w-10 flex items-center"></div>
            <div @mouseover="indexLink[index] = 1" @mouseleave="indexLink[index] = 0" class="flex flex-row h-[16px]">
                <button @click.prevent="IndexSubHeadingOpen[index] = !IndexSubHeadingOpen[index]" class="h-[16px] flex items-center font-bold hover:text-lime-600" type="button">
                    {{ item[0] }}
                </button>

                <!-- link button -->
                <button v-show="indexLink[index]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1 hover:stroke-lime-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </button>
            </div>

            <div class="relative grow mx-1 h-[16px] flex items-center">
                <div class="absolute -top-[2px] border-b-2 border-black border-dotted h-[16px] w-full"></div>
            </div>
            <div class="text-xs w-fit h-[16px] flex items-center">
                <div class="">{{ typeof headings[index][1] != 'undefined' ? headings[index][1].length : '' }}</div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                </svg>
            </div>
        </div>

        <IndexSubHeading1 v-if="IndexSubHeadingOpen[index]" :index="index" :data="headings"/>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from '../Components/Detail/IndexSubHeading1.vue'

const props = defineProps(['detail']);

let detailData = ref(['']);

let IndexSubHeadingOpen = ref([]);
let indexMenuOpen = ref(0);
let indexMenuOpenSwitcher = ref('open');
let IndexShowOpen = ref(1);
let indexLink = ref([0]);

let headings = ref([]);
headings.value[0] = ['Arrangement'];
headings.value[0][1] = [];
headings.value[0][1][0] = ['Idea'];
headings.value[0][1][1] = ['Resource'];
headings.value[0][1][2] = ['Intention'];
// headings.value[0][1][0] = [];
// headings.value[0][1][0][1] = ['Level 3-1'];
// // headings.value[0][1][0][1] = ['Level 3-2'];

headings.value[1] = ['Realisation'];
headings.value[1][1] = [];
headings.value[1][1][0] = ['Story'];
headings.value[1][1][1] = ['Programming'];
headings.value[1][1][2] = ['Graphic'];
headings.value[1][1][3] = ['Sound'];

headings.value[2] = ['Impact'];
headings.value[2][1] = [];
headings.value[2][1][0] = ['Rewiews'];
headings.value[2][1][1] = ['Wealth'];
headings.value[2][1][2] = ['Successor'];
headings.value[2][1][3] = ['Test'];

headings.value[3] = ['Impact'];
headings.value[4] = ['Impact'];
headings.value[5] = ['Impact'];
headings.value[6] = ['Impact'];
headings.value[7] = ['Impact'];
headings.value[8] = ['Impact'];
headings.value[9] = ['Impact'];
headings.value[10] = ['Impact'];

onMounted(() => {
    detailData.value = props.detail;
});

watch(() => props.detail, _.debounce( (curr, prev) => {
    detailData.value = props.detail;
}, 500)
);

function textSizeHeading(index) {

    if (typeof headings.value[1][index] != 'undefined') {
        if (headings.value[1][index].search(/\.%\./g) != -1) {
            return '14px';
        }
    }
}

Object.keys(headings.value).forEach((key, i) => {

    IndexSubHeadingOpen.value.push(0);

});

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
    });

}

</script>
