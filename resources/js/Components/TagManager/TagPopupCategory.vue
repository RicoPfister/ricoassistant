<template>

<!-- tag categories/content -->
<div class="w-[200px] bg-white">
    <div class="max-h-[500px] border-r border-b border-gray-400 overflow-y-scroll">
        <div v-for="(item, index) in tagCollection" class="flex flex-col bg-white">
            <div class="h-[34px] border-b border-gray-400">

                <button @click.prevent="SubCategoryOpen[index] = !SubCategoryOpen[index]" class="px-2 border-r border-gray-400 h-full flex w-full items-center justify-between" typeP="button">

                    <div class="flex items-center font-bold">{{ item[0] }}</div>

                    <div class="flex flex-row items-center">
                        <div class="text-[12px] text-blue-600">{{ categoryActiveTotal[index] }}</div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>

                </button>

            </div>

            <KeepAlive>
                <SubCategory v-if="SubCategoryOpen[index]" :dataParent="tagCollection[index]" :idParent="index" @data-child="dataChild"/>
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

let props = defineProps(['dataParent', 'dataChild', 'dataCommon']);
let emit = defineEmits(['dataParent', 'idParent', 'dataChild']);



// let tagCollection = ref([['Presets', ['Presets', 'Test A2']], ['Characteristics', ['Test B1', 'Test B2']], ['Administration', ['Lost', 'Lent', 'Rent']], ['Rating Mood', ['Test B1', 'Test B2']], ['Rating Item', ['Test B1', 'Test B2']], ['Rating Media', ['Test B1', 'Test B2']]]);
let categoryActiveTotal = ref([]);

// get TagPopupSubCategory.vue data and emit tag data to TagPopup.vue
function dataChild(data){
    if (typeof categoryActiveTotal.value[data[0]] == 'undefined') categoryActiveTotal.value[data[0]] = 1; else categoryActiveTotal.value[data[0]]++;

    // collect tag data and emit
    emit('dataChild', {'tagSelect': [tagCollection.value[data[0]][0], data[1]]});
}

// watch(() => props.dataCommon, (curr, prev) => {
//     tagCollection.value = props.dataCommon.tagCollection;
// }, {deep: true}, 500);

onMounted(() => {
    tagCollection.value = props.dataCommon.tagCollection;
})

</script>

