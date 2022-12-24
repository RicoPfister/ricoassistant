<template>

<!-- tag content sub menu-->
<div v-for="(item, index) in props.toChild.tagCollection[1]" class="flex flex-col bg-white w-full h-fit">
    <div :class="{'bg-blue-100': categorySubActive[index]}" class="h-[26px] border-b border-gray-400 w-full flex flex-row">
        <div class="border-r border-gray-400 bg-stone-200 flex items-center justify-between h-full w-full">

            <!-- tag sub menu entries -->
            <!-- ++++++++++++++++++++++++++++++ -->

            <!-- left box -->
            <button @click.prevent="categorySubActive[index] = 1; fromChild(index)" class="h-full flex flex-row items-center w-full pl-2" type="button">

                <!-- tag context sub menu icon -->
                <div class="h-fit flex items-center">
                    <svg width="8" height="5">
                        <rect width="2" height="3" style="fill:rgb(0,0,0)" />
                        <rect y="3" width="8" height="2" style="fill:rgb(0,0,0)" />
                        Sorry, your browser does not support inline SVG.
                    </svg>
                </div>

                <!-- tag context title -->
                <div class="flex items-center ml-1 h-full grow">{{ item }}</div>


                <!-- selected indicator -->
                <!-- <div v-if="categorySubActive[index]" class="bg-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" color="none" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                    </svg>
                </div> -->
            </button>

            <!-- right box -->
            <div class="items-center h-full pr-1">

                    <!-- preset menu button -->
                <button @click="tagPresetMenu(index)" class="h-full" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-full h-full py-[2px]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0
                        002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0
                        00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0
                        0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </button>

            <!-- preset popup -->
            <!-- ++++++++++++++++++++++++++++++ -->

                <!-- preset menu popup -->
                <div v-if="tagPresetMenuOpen[index]" class="absolute border border-black bg-stone-200 max-w-[500px]">

                    <!-- create preset entry input -->
                    <div v-if="props.toChild.tagCollection[0] !== 'Preset'" class="flex items-center border-b border-black h-full">
                        <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent pl-1 h-[26px] w-80 truncate" type="text"
                        placeholder="Select or type in a new preset list name..." v-model="tagPresetCollection">
                        <div @click="tagCreatePreset(index)" class="px-2 border-l border-black h-[26px] flex items-center bg-stone-300 text-gray-600 hover:text-black w-fit">Create</div>
                    </div>

                    <!-- list: database tags preset -->
                    <div v-if="props.toChild.tagPreset" v-for="(item2, index2) in props.toChild.tagCollection !== 'Preset' ? props.toChild.tagPreset : ''" class="flex flew-col border-b border-black last:border-b-0 w-full">

                        <!-- button: select preset item -->
                        <button @click.prevent="tagPresetSelected(index, index2)" class="items-center flex flex-row h-[26px] w-full" type="button">

                            <!-- icon: add to preset -->
                            <div class="h-full">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-full p-[3px]">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
                                </svg>
                            </div>
                            <div class="w-full">
                                <div class="text-gray-700 hover:text-black h-full truncate max-w-fit mr-8">{{ item2 }}</div>
                            </div>
                        </button>
                    </div>
                    <div v-else class="p-1">No presets found. Please create one.</div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

let props = defineProps(['toChild']);
let emit = defineEmits(['fromChild']);

let tagPresetCollection = ref('');
let categorySubActive = ref([]);
let tagPresetMenuOpen = ref([]);
let tagPresetGroupCollection = ref({});

// emit data to TagPopupCategory.vue
function fromChild(index) {
    // console.log(props.toChild.tagCollection[0]);
    emit('fromChild', {'tagContextSelected': 1, 'index': props.toChild.index, 'subIndex': index});
}

function tagPresetMenu(index) {
    tagPresetMenuOpen.value[index] = !tagPresetMenuOpen.value[index];
}

function tagPresetSelected(index, index2){
    // console.log('ok');
    // console.log(index2);
    tagPresetMenuOpen.value[index] = !tagPresetMenuOpen.value[index];
    emit('fromChild', {'presetItemSelected': 1, 'presetIndex': index2, 'index': props.toChild.index, 'subIndex': index});
    // console.log(index);
    // console.log('ok');
}

function tagCreatePreset(index) {
    // console.log(index);
    // console.log(props.toChild.index);
    emit('fromChild', {'presetCreate': tagPresetCollection.value, 'index': props.toChild.index, 'subIndex': index});
    tagPresetMenuOpen.value[index] = !tagPresetMenuOpen.value[index];
    tagPresetCollection.value = '';
}

onMounted(() => {
    tagPresetListCreate();
});

watch(() => props.toChild, (curr, prev) => {

    tagPresetListCreate();

}, {deep: true}, 500);

// preset group to string conversion
function tagPresetListCreate() {
    if (props.toChild.tagPresetListItems != '') {
        // console.log(props.toChild.tagPresetListItems.length);

        for(let j = 0; j < props.toChild.tagPresetListItems.length; j++) {
            for(let k = 0; k < props.toChild.tagPresetListItems[j].length; k++) {
                // console.log(props.toChild.tagPresetListItems[j][k]);
                // tagPresetGroupCollection.value[j][0] = '@'+props.toChild.tagPresetListItems[j][k][0]+':'+props.toChild.tagPresetListItems[j][k][1];
                if (!tagPresetGroupCollection.value[j]) tagPresetGroupCollection.value[j] = {};
                tagPresetGroupCollection.value[j][k] = '@'+props.toChild.tagPresetListItems[j][k][0]+':'+props.toChild.tagPresetListItems[j][k][1];
            }
        }
    }
}

</script>
