<template>

<!-- tag category/context dropdown box -->
<div class="w-[200px] bg-white">
    <div class="max-h-[500px] border-r border-gray-400 overflow-y-scroll">

        <!-- tag category dropdown -->
        <div v-for="(item, index) in tagCollection" class="flex flex-col bg-white h-full leading-none p-0 m-0">
            <div class="border-b border-gray-400 h-6 leading-none p-0 m-0 bg-lime-200">

                <!-- category box -->
                <!-- ------------------ -->
                <div class="border-r border-gray-400 h-full flex w-full items-center justify-between">

                    <!-- left box -->
                    <div class="flex flex-row items-center h-full leading-none p-0 m-0">

                        <!-- tag category title -->
                        <button type="button" @click.prevent="SubCategoryOpen[index] = !SubCategoryOpen[index]" class="flex items-center font-bold pl-1 h-full leading-none p-0 m-0">{{ item[0] }}</button>

                        <!-- total context tags indicator -->
                        <button @click.prevent="newTag(index)" class="pl-1 h-full flex items-center text-xs leading-none p-0 m-0 hover:text-blue-600" type="button">{{ '['+ (typeof categoryActiveTotal[index] !== 'undefined' ? categoryActiveTotal[index] : 0) +'/'+ props.fromController?.tagCollection[index][1].length +']' }}</button>

                        <!-- new tag context button -->
                        <!-- <button @click="newTag(index)" class="ml-1 hover:text-blue-600 h-full flex items-center text-xs leading-none p-0 m-0" type="button">+</button> -->
                    </div>

                    <!-- right box -->

                    <!-- dropdown indicator area -->
                    <button @click.prevent="SubCategoryOpen[index] = !SubCategoryOpen[index]" class="flex flex-row items-center grow justify-end h-full leading-none p-0 m-0" ttype="button">

                        <!-- dropdown open indicator -->
                        <div class="flex items-center h-full leading-none p-0 m-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 pr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            </svg>
                        </div>
                    </button>
                </div>
            </div>

            <!-- tag context dropdown -->
            <KeepAlive>
                <SubCategory v-if="SubCategoryOpen[index]" :toChild="{'tagCollection': tagCollection[index], 'index': index, 'tagPreset': tagCollection.slice(-1)[0][0] == 'Preset' ? tagCollection.slice(-1)[0][1] : '', 'tagPresetCollection': props.toChild.tagPresetCollection}" @fromChild="fromChild"/>
            </KeepAlive>

        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import SubCategory from "./TagPopupSubCategory.vue";

let SubCategoryOpen = ref([]);
let tagCollection = ref([]);
let tagPresetGroupCollection = ref([]);

let props = defineProps(['fromController', 'toChild', 'fromChild']);
let emit = defineEmits(['fromChild', 'toChild']);

// let

// let tagCollection = ref([['Presets', ['Presets', 'Test A2']], ['Characteristics', ['Test B1', 'Test B2']], ['Administration', ['Lost', 'Lent', 'Rent']], ['Rating Mood', ['Test B1', 'Test B2']], ['Rating Item', ['Test B1', 'Test B2']], ['Rating Media', ['Test B1', 'Test B2']]]);
let categoryActiveTotal = ref([]);

// get TagPopupSubCategory.vue data and emit tag data to TagPopup.vue
function fromChild(data){

    // send preset data to TagPop.vue
    if (data.presetData) {
        emit('fromChild', {'presetData': data.presetData});
    }

    if (typeof categoryActiveTotal.value[data.index] == 'undefined') categoryActiveTotal.value[data.index] = 1; else categoryActiveTotal.value[data.index]++;

    if (data.index == 'new') {
        emit('fromChild', {'tagSelectionCategory': tagCollection.value[data.index][0], 'tagSelectionContext': ''});
    }

    if (data.tagContextSelected) {
        // console.log(tagCollection.value[data.index][1][data.subIndex]);
        emit('fromChild', {'tagSelectionCategory': tagCollection.value[data.index][0], 'tagSelectionContext': tagCollection.value[data.index][1][data.subIndex]});
    }
}

// watch(() => props.dataCommon, (curr, prev) => {
//     tagCollection.value = props.dataCommon.tagCollection;
// }, {deep: true}, 500);

onMounted(() => {

    if (props.fromController?.tagCollection) {
        // console.log(props.fromController?.tagCollection);
        tagCollection.value = props.fromController.tagCollection
    };
    // tagCollection.value.push(['Preset', ['Admin123', 'Movie Rating']]);
})

function newTag(data) {
    // console.log('ok');
    emit('fromChild', {'tagSelectionCategory': tagCollection.value[data][0], 'tagSelectionContext': ''});
}

</script>

