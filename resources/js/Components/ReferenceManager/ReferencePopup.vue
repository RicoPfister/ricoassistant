<template>

<!-- reference picker popup container -->
<div class="h-fit w-full px-2 flex flex-col bg-white border-r border-b border-l border-black">

    <!-- reference picker box -->
    <div class="flex flex-col z-50 overflow-y-auto max-h-52 text-sm xl:text-base w-full">

        <!-- popup: found in database -->
        <div class="">
            <div class=""><b>Found in Database:</b></div>
            <div v-for="(item, index) in props.fromController.referencesResult" class="flex flex-row items-center w-full">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-black">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </button>

                <!-- button reference picker -->
                <button type="button" @click="referencePopupSelect(index)" class="ml-1 text-gray-500 hover:text-black truncate"><div class="truncate">{{ item.title }}</div></button>
            </div>
        </div>

        <!-- popup: reference input -->
        <div v-if="0" class="">
            <div class="">Input:</div>
            <div class="flex flex-row items-center w-full">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-black">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </button>
                <!-- button reference picker -->
                <div class="ml-1 text-gray-500 truncate"><div class="truncate">{{ props.fromController.referencesResult[props.toChild.referenceChecker.rowIndex-1].title }}</div></div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'transfer', 'toParent', 'toChild', 'fromController']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'fromChild']);

let referencePickerOpen = ref({});

// 1) receive data from parent
//---------------------------------

onMounted(() => {
    // console.log(1);
    // console.log(props.fromController.misc.row-1);
});

// 4) send data to parent
//---------------------------------
function referencePopupSelect(rowIndex) {
    // console.log(props.toChild.fromController.referencesResult[rowIndex].basic_id);
    // console.log(props.fromController.referencesResult[rowIndex].basic_id);
    emit('fromChild', {'parentId': props.fromController.misc.parentId, 'formData': {'index': props.fromController.misc.row, 'referenceTitle': props.fromController.referencesResult[rowIndex].title, 'basic_id': props.fromController.referencesResult[rowIndex].basic_id}});
    // emit('fromChild', 'test');
    // referencePickerOpen.value[props.toChild.referenceChecker.rowIndex-1]= 0;
    // console.log(props.toChild.referencePickerOpen[props.toChild.referenceChecker.rowIndex-1]);
    // console.log(props.toChild.referenceChecker.rowIndex-1);
}
</script>
