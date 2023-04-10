<template>

<!-- index container -->
<div class="">

    <!-- index -->
    <div class="flex flex-row gap-1 items-center">

        <!-- title -->
        <button @click="IndexCollapsState('switch')" class="flex flex-row items-center gap-1 hover:text-lime-600">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>

            <div>Index</div>
        </button>

        <!-- title menu -->
        <div v-show="indexMenuOpen" class="flex flex-row">
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

    <!-- heading -->
    <div v-if="IndexShowOpen" v-for="(item, index) in headings[0]" class="mb-[10px] flex flex-col">
        <div class="flex flex-row">

            <!-- main heading number -->
            <button
                class="flex flex-row hover:text-blue-600"
                @click.prevent="IndexSubHeadingOpen[index] = !IndexSubHeadingOpen[index]"
            >
                <div v-if="IndexSubHeadingOpen[index] == 0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                </div>
                <div v-else>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>

                <!-- main chapter title -->
                <div class="justify-end h-[16px] w-[15px] flex items-center mr-[33px]">{{index}}</div>
                <!-- <div class="h-[16px] w-[35px] flex items-center border"></div> -->
            </button>

            <div
            class="flex flex-row h-[16px]">

                <!-- heading text button -->
                <button
                    @click.prevent="$emit('fromChild', {'jumpToChapter': index})"
                    class="h-[16px] flex items-center font-bold hover:text-lime-600"
                    type="button">
                    {{ item[0][1] }}
                </button>

                <!-- heading text button -->
                <!-- <div v-else class="h-[16px] flex items-center font-bold cursor-default">
                    {{ item[0] }}
                </div> -->

                <!-- link button -->
                <!-- <button v-show="indexLink[index]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 hover:stroke-lime-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                    </svg>
                </button> -->
            </div>

            <!-- ending part -->
            <div v-if="typeof item[1] != 'undefined'" class="flex flex-row grow" >

                <!-- leading dots -->
                <div class="relative grow mx-1 h-[16px] flex items-center" >
                    <!-- <div class="absolute -top-[3px] border-b border-black h-[16px] w-full"></div> -->
                </div>

                <!-- infos / collaps icon -->
                <!-- <div class="w-fit h-[16px] flex items-center">
                    <div class="">
                        {{ item[1].length }}</div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                </div> -->
            </div>
        </div>

        <IndexSubHeading1 v-if="IndexSubHeadingOpen[index]" :data="headings" :index="index" @fromChild="fromChild"/>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from './IndexSubHeading1.vue'

const props = defineProps(['fromController']);
let emit = defineEmits(['fromChild']);

let detailData = ref(['']);

let IndexSubHeadingOpen = ref([]);
let indexMenuOpen = ref(0);
let indexMenuOpenSwitcher = ref('open');
let IndexShowOpen = ref(1);
let indexLink = ref([0]);
// let window_scroll = ref('');

let headings = ref([]);
// headings.value[0] = ['Arrangement'];
// headings.value[0][1] = [];
// headings.value[0][1][0] = ['Idea'];
// headings.value[0][1][1] = ['Resource'];
// headings.value[0][1][2] = ['Intention'];
// headings.value[0][1][0][1] = [];
// headings.value[0][1][0][1][0] = ['H1 Level 3-1'];
// headings.value[0][1][0][1][1] = ['H2 Level 3-2'];

// headings.value[1] = ['Realisation'];
// headings.value[1][1] = [];
// headings.value[1][1][0] = ['Story'];
// headings.value[1][1][1] = ['Programming'];
// headings.value[1][1][2] = ['Graphic'];
// headings.value[1][1][3] = ['Sound'];
// headings.value[1][1][0][1] = [];
// headings.value[1][1][0][1][0] = ['H2 Level 3-1'];
// headings.value[1][1][0][1][1] = ['H2 Level 3-2'];
// headings.value[1][1][0][1][2] = ['H2 Level 3-3'];

// headings.value[2] = ['Impact'];
// headings.value[2][1] = [];
// headings.value[2][1][0] = ['Rewiews'];
// headings.value[2][1][1] = ['Wealth'];
// headings.value[2][1][2] = ['Successor'];
// headings.value[2][1][0][1] = [];
// headings.value[2][1][0][1][0] = ['Level 3-1'];
// headings.value[2][1][0][1][1] = ['Level 3-2'];

// headings.value[3] = ['Register'];
// headings.value[4] = ['Register'];
// headings.value[5] = ['Register'];
// headings.value[6] = ['Register'];
// headings.value[7] = ['Register'];
// headings.value[8] = ['Register'];
// headings.value[9] = ['Register'];

// headings.value[10] = ['Register'];
// headings.value[10][1] = [];
// headings.value[10][1][0] = ['Idea'];
// headings.value[10][1][1] = ['Resource'];
// headings.value[10][1][2] = ['Intention'];
// headings.value[10][1][3] = ['Intention'];
// headings.value[10][1][4] = ['Intention'];
// headings.value[10][1][4][1] = [];
// headings.value[10][1][4][1][0] = ['H1 Level 3-1'];
// headings.value[10][1][4][1][1] = ['H2 Level 3-2'];

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

function createHeadings() {

    headings.value = props.fromController;

    // console.log(props.fromController);

    // props.fromController.forEach(element => {

    //     console.log(element);

    //     const heading_level = element[0].split('.');
    //     console.log((heading_level || []).length);

    //     switch ((heading_level || []).length) {
    //         case 1:
    //             headings.value[heading_level[0]-1] = [element[1]];
    //             break;

    //         case 2:
    //             if (headings.value[heading_level[0]-1][1] == undefined) headings.value[heading_level[0]-1][1] = [];
    //             headings.value[heading_level[0]-1][1].push([element[1]]);
    //             break;

    //         default:
    //             break;
    //     }

    // });
}

onMounted(() => {

    createHeadings();
});

function fromChild(data) {
    emit('fromChild', data);
}

</script>
