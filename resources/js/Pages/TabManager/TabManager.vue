<template>
<Header>

<div class="flex flex-row w-full gap-32 justify-center">

    <div v-for="(item, componentIndex) in tabContainerAmount" class="lg:w-[755px]">

        <!-- container -->
        <div class="">

            <!-- tab-bar -->
            <div class="flex flex-row border-b border-lime-500 gap-1 mt-5">

                <!-- generate tab(s) -->
                <div v-for="(item, tabIndex) in tabs[componentIndex]" :key="tabs[componentIndex]" :style="{background: currentTab[componentIndex] != tabIndex+1 ? '#84cc16' : '#4d7c0f'}" class="text-lime-200 font-bold rounded-t-xl w-fit px-3 flex items-center h-6">

                    <button @click="currentTab[componentIndex] = tabIndex+1" type="button">
                        {{ item }}
                    </button>

                    <!-- remove tab symbol-->
                    <button @click="tabs[componentIndex].splice(tabIndex, 1); currentTab[componentIndex] > 1 ? currentTab[componentIndex]-- : ''; componentSet[componentIndex].splice(tabIndex, 1); details.splice(tabIndex, 1); details.length == 0 ? tabContainerAmount-- : ''
                        " type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" color="white" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-4 h-4 pl-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- new -->
                <!-- <div class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-3 flex items-center">New
                    <svg xmlns="http://www.w3.org/2000/svg" color="white" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-4 h-4 pl-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div> -->

                <!-- random -->
                <!-- <div class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-3 flex items-center">Ricomizer
                    <svg xmlns="http://www.w3.org/2000/svg" color="white" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-4 h-4 pl-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div> -->

                <!-- add entry -->
                <button @click="totalTab[componentIndex]++; tabs[componentIndex].push('Tab ' + (totalTab[componentIndex]) ); currentTab[componentIndex] = tabs[componentIndex].length; lastTab[componentIndex]++; componentSet[componentIndex].push(0)" class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-2 flex items-center h-6">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                    </svg>
                </button>

                <!-- search -->
                <button class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-2 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </button>
            </div>

            <!-- navpathbar -->

            <div class="lg:text-base text-md h-10 flex items-center border-l border-r border-b border-lime-500 px-3 pt-2 rounded-b-xl leading-none bg-lime-100" >

                <div v-if="tabs[componentIndex][currentTab[componentIndex]-1] == 'Featured Posts'" class="flex flex-wrap items-center">

                    <div class="flex flex-row mb-2 items-center">

                        <!-- home symbol -->
                        <div class="flex items-center">
                            <Link href="/" as="button" class="">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                </svg>
                            </Link>
                            &nbsp;>&nbsp;
                        </div>

                        <div class="flex items-center"><span class="underline">Search</span>&nbsp;>&nbsp;</div>
                            <div class="flex flex-row">
                                <div class="mr-2">20 results found.</div>
                            </div>
                    </div>

                    <div class="flex flex-wrap mb-2 items-center gap-2">

                        <!-- tag -->
                        <div class="flex flex-row items-center w-fit bg-lime-200 rounded-xl px-3 leading-none">
                            <div class="flex items-center">#Collection:Featured</div>
                            <div class="">
                                <svg xmlns="http://www.w3.org/2000/svg" color="black" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-5 h-5 pl-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                        </div>

                        <!-- tag -->
                        <div class="flex flex-row items-center w-fit bg-lime-200 rounded-xl px-3 leading-none">
                            <div class="flex items-center">#Category:Mixed</div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="black" fill="none" viewBox="0 0 24 24" stroke-width="4" stroke="currentColor" class="w-5 h-5 pl-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pt-2">
                <!-- <Component :is="" /> -->
                <List v-if="component[componentSet[componentIndex][currentTab[componentIndex]-1]] === 'List'" :key="componentSet[componentIndex]" @addtab="tabContainerAmount = 2" :list="props.filter" />
                <Detail v-if="component[componentSet[componentIndex][currentTab[componentIndex]-1]] === 'Detail'" :detail="detailShow"/>
                <NewTab v-if="component[componentSet[componentIndex][currentTab[componentIndex]-1]] === 'NewTab'" />
            </div>
        </div>
    </div>
</div>

</Header>
</template>

<script setup>

import { Link } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed, watch } from 'vue';

import Header from "../../Layouts/MainNav.vue";
import List from "../List.vue";
import NewTab from "./NewTab.vue"
import Detail from "../Detail.vue"

const props = defineProps(['filter', 'detail']);

let data1 = 123;
let data2 = "";
let detailsTabsCounter = ref(1);

let component = ['NewTab', 'List', 'Detail'];
let componentSet = ref([[1], [2]]);
let tabs = ref([['Featured Posts'], []]);
let currentTab = ref([1, 1]);
let totalTab = ref([0, 0]);
let lastTab = ref([0, 0]);
let lastTabDetails = ref([0, 0]);
let tabContainerAmount = ref(1);
// let listData = ref([props.filter]);

// add detail tab

let details = ref([[]]);
let detailShow = ref([]);

watch(() => props.detail, _.debounce( (curr, prev) => {

    // if (tabs.value[1].length != 0) {
    //     componentSet.value[1].push(2);
    // }

    componentSet.value[1].push(2);

    lastTabDetails.value[1]++;

    tabs.value[1].push('Details '+ (lastTabDetails.value[1]));
    lastTab.value[1]++;
    currentTab.value[1] = tabs.value[1].length;

    // fill detail arrays
    details.value[currentTab.value[1]-1] = props.detail;
    detailShow.value = details.value[currentTab.value[1]-1];

}, 500)
);

// tab changed
watch(() => currentTab.value[1], _.debounce( (curr, prev) => {
    // alert('ok1');
    // check if tab is already stored
    if (details.value[currentTab.value[1]-1]) {
        // alert('ok2');
        detailShow.value = details.value[currentTab.value[1]-1];
    }
}, 500)
);

</script>

