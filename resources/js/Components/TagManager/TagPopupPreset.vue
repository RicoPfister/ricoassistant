<template>

<!-- tag category/context dropdown box -->
<div class="w-[200px] bg-white">
    <div class="max-h-[500px] border-r border-gray-400 overflow-y-scroll">

        <!-- tag category dropdown -->
        <div v-for="(item, index) in props.toChild.tagPresetCollection" class="flex flex-col bg-white h-full leading-none p-0 m-0">
            <div  class="border-b border-gray-400 h-6 leading-none p-0 m-0 bg-stone-300">

                <!-- category box -->
                <!-- ------------------ -->
                <div class="border-r border-gray-400 h-full flex w-full items-center justify-between">

                    <!-- left box -->
                    <div class="group flex flex-row items-center h-full leading-none p-0 m-0">

                        <!-- tag category title -->
                        <button :disabled="!props.toChild.tagPresetCollection[index]?.[1]" type="button" @click.prevent="PresetSelect(index)" class="flex items-center enabled:font-bold disabled:text-gray-500 pl-1 h-full leading-none p-0 m-0">{{ item[0] }}</button>

                        <!-- total context tags indicator -->
                        <div class="h-full">

                        <button :disabled="!props.toChild.tagPresetCollection[index]?.[1]" @click="tagPresetGroupOpen[index] = !tagPresetGroupOpen[index]" class="pl-1 h-full flex items-center text-xs leading-none p-0 m-0 enabled:hover:text-blue-600 disabled:text-gray-500" type="button">{{ props.toChild.tagPresetCollection[index]?.[1] ? '['+ props.toChild.tagPresetCollection[index][1].length +']' : '[0]' }}</button>

                <!-- preset popup -->
                <!-- ++++++++++++++++++++++++++++++ -->

                <!-- preset menu popup -->
                <div v-if="tagPresetGroupOpen[index]" class="absolute border border-black bg-stone-200 max-w-[500px]">

<!-- list: database tags preset -->
<div v-for="(item3, index3) in props.toChild.tagPresetCollection[index][1]" class="flex flew-col border-b border-black last:border-b-0 w-full">

    <!-- button: select preset item -->
    <button @click.prevent="tagPresetSelected(index, index2)" class="items-center flex flex-row h-[26px] w-full" type="button">

        <!-- icon: add to preset -->

        <div class="w-full">
            <div class="text-gray-700 hover:text-black h-full truncate max-w-fit mr-8 pl-1"><span class="font-bold">{{ item3[0] }}</span>{{ ': '+item3[1] }}</div>
        </div>
    </button>

</div>

<!-- preset dropdown: show group items -->
<div v-if="0" v-for="(item2, index2) in props.toChild.tagPresetCollection" class="flex flew-col border-b border-black last:border-b-0 w-full">
    <!-- button: select preset item -->
    <div class="items-center flex flex-row h-[26px] w-full">
        <div class="text-gray-700 h-full truncate max-w-fit mr-8 pl-1 flex items-center">{{ item2[0] }}</div>
    </div>
</div>
<!-- <div v-else class="p-1">No presets found. Please create one.</div> -->
</div>









                    </div>
                        <!-- new tag context button -->
                        <!-- <button @click="newTag(index)" class="ml-1 hover:text-blue-600 h-full flex items-center text-xs leading-none p-0 m-0" type="button">+</button> -->
                    </div>










                    <!-- right box -->
                    <div class="grow"></div>

                    <div class="w-fit flex flex-row items-center justify-end h-full pl-1">




                    <!-- dropdown indicator area -->
                    <button @click.prevent="tagPresetMenuOpen[index] = !tagPresetMenuOpen[index]" class="h-full" ttype="button">

                        <!-- dropdown open indicator -->
                        <div class="flex items-center h-full">
                            <div class="h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full p-[2px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0
                                    002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0
                                    00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0
                                    0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                                </svg>
                            </div>
                        </div>
















<!-- preset popup -->
            <!-- ++++++++++++++++++++++++++++++ -->

                <!-- preset menu popup -->
                <div v-if="tagPresetMenuOpen[index]" class="absolute border border-black bg-stone-200 max-w-[500px]">

<!-- create preset entry input -->
<div class="flex items-center border-b border-black h-full">
    <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent pl-1 h-[26px] w-80 truncate" type="text"
    placeholder="Select or type in a new preset list name..." v-model="tagPresetCreateInput">
    <div @click="tagCreatePreset(index)" class="px-2 border-l border-black h-[26px] flex items-center bg-stone-300 text-gray-600 hover:text-black w-fit">Create</div>
</div>

<!-- list: database tags preset -->
<div v-if="props.toChild.tagPresetCollection.length > 0" v-for="(item2, index2) in props.toChild.tagPresetCollection" class="flex flew-col border-b border-black last:border-b-0 w-full">

    <!-- button: select preset item -->
    <button @click.prevent="tagPresetSelected(index, index2)" class="items-center flex flex-row h-[26px] w-full" type="button">

        <!-- icon: add to preset -->
        <div class="h-full">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-full p-[3px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
            </svg>
        </div>
        <div class="w-full">
            <div class="text-gray-700 hover:text-black h-full truncate max-w-fit mr-8">{{ item2[0] }}</div>
        </div>
    </button>

</div>
<div v-else class="p-1">No presets found. Please create one.</div>

<!-- preset dropdown: show group items -->
<div v-if="0" v-for="(item2, index2) in props.toChild.tagPresetCollection" class="flex flew-col border-b border-black last:border-b-0 w-full">
    <!-- button: select preset item -->
    <div class="items-center flex flex-row h-[26px] w-full">
        <div class="text-gray-700 h-full truncate max-w-fit mr-8 pl-1 flex items-center">{{ item2[0] }}</div>
    </div>
</div>
<!-- <div v-else class="p-1">No presets found. Please create one.</div> -->
</div>








                    </button>
                </div>
                </div>
            </div>





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
let tagPresetMenuOpen = ref([]);
let tagPresetCreateInput = ref('');
let tagPresetGroupOpen = ref([]);

let props = defineProps(['fromController', 'toChild', 'fromChild']);
let emit = defineEmits(['fromChild', 'toChild']);

// let tagCollection = ref([['Presets', ['Presets', 'Test A2']], ['Characteristics', ['Test B1', 'Test B2']], ['Administration', ['Lost', 'Lent', 'Rent']], ['Rating Mood', ['Test B1', 'Test B2']], ['Rating Item', ['Test B1', 'Test B2']], ['Rating Media', ['Test B1', 'Test B2']]]);
let categoryActiveTotal = ref([]);

// get TagPopupSubCategory.vue data and emit tag data to TagPopup.vue
function fromChild(data){

    // send preset data to TagPop.vue
    if (data.presetData) {
        emit('fromChild', {'presetData': data.presetData});
    }

    if (typeof categoryActiveTotal.value[data.index] == 'undefined') categoryActiveTotal.value[data.index] = 1; else categoryActiveTotal.value[data.index]++;

    // if (data.index == 'new') {
    //     emit('fromChild', {'tagSelectionCategory': tagCollection.value[data.index][0], 'tagSelectionContext': 'new'});
    // }

    if (data.tagContextSelected) {
        console.log(tagCollection.value[data.index][1][data.subIndex]);
        emit('fromChild', {'tagSelectionCategory': tagCollection.value[data.index][0], 'tagSelectionContext': tagCollection.value[data.index][1][data.subIndex]});
    }
}

// watch(() => props.dataCommon, (curr, prev) => {
//     tagCollection.value = props.dataCommon.tagCollection;
// }, {deep: true}, 500);

onMounted(() => {
    tagCollection.value = props.fromController.tagCollection;
    // tagCollection.value.push(['Preset', ['Admin123', 'Movie Rating']]);
})

// function newTag(data) {
//     emit('fromChild', {'tagSelectionCategory': tagCollection.value[data][0], 'tagSelectionContext': 'new'});
// }

function PresetSelect(index) {
    // console.log(index);
    emit('fromChild', {'tagSelectionPreset': index});
}

</script>

