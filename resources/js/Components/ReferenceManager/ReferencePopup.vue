<template>

<!-- reference picker popup container -->
<div v-if="(referencePickerOpen[props.toChild.referenceChecker.rowIndex-1])" class="h-fit w-full px-2 flex flex-col bg-white border-r border-b border-l border-black">

    <!-- reference picker box -->
    <div class="flex flex-col z-50 overflow-y-auto max-h-52 text-sm xl:text-base w-full">

        <!-- popup: found in database -->
        <div class="">
            <div class=""><b>Found in Database:</b></div>
            <div v-for="(item, index) in props.toChild.fromController.referencesResult" class="flex flex-row items-center w-full">
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
        <div v-if="props.toChild.reference[props.toChild.referenceChecker.rowIndex-1].title" class="">
            <div class="">Input:</div>
            <div class="flex flex-row items-center w-full">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-black">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </button>
                <!-- button reference picker -->
                <div class="ml-1 text-gray-500 truncate"><div class="truncate">{{ props.toChild.reference[props.toChild.referenceChecker.rowIndex-1].title }}</div></div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'transfer', 'toParent', 'toChild']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'fromChild']);

let referencePickerOpen = ref({});

// 1) receive data from parent
// 2) send data to controller
//---------------------------------
watch(() => props.toChild, (curr, prev) => {

    // console.log(props.toChild);

    // console.log(props.toChild.reference[0].parentId);

    // check and receive data from controller
    if (props.toChild.referenceChecker.check == 'fromController') {
        referencePickerOpen.value[props.toChild.referenceChecker.rowIndex-1] = 1;
    }

    // check if reference popup ***selection*** has been fired and send request to controller
    else if (props.toChild.referenceChecker.check == 'lastUsed' && ( props.toChild.referencePickerOpen[props.toChild.referenceChecker.rowIndex-1] == 0 || typeof props.toChild.referencePickerOpen[props.toChild.referenceChecker.rowIndex-1] == 'undefined' )) {
        Inertia.post('refcheck', { reference: props.toChild.referenceChecker.check, row: props.toChild.referenceChecker.rowIndex, parentId: props.toChild.parentId }, {replace: true,  preserveState: true, preserveScroll: true});
    }

    // check if reference form ***input*** has been and send request to controller
    else if (props.toChild.referenceChecker.check == 'inputCheck' && ( props.toChild.referencePickerOpen[props.toChild.referenceChecker.rowIndex-1] == 0 || typeof props.toChild.referencePickerOpen[props.toChild.referenceChecker.rowIndex-1] == 'undefined' ) && props.toChild.reference[props.toChild.referenceChecker.rowIndex-1].title.length > 2) {
        setTimeout(() => {
            Inertia.post('refcheck', { reference: props.toChild.reference[props.toChild.referenceChecker.rowIndex-1].title, row: props.toChild.referenceChecker.rowIndex, parentId: props.toChild.referenceChecker.parentId}, {replace: false,  preserveState: true, preserveScroll: true});
        }, 500);
    }

}, {deep: true}, 500);

// 4) send data to parent
//---------------------------------
function referencePopupSelect(rowIndex) {

    // console.log(props.toChild.fromController.referencesResult[rowIndex].basic_id);

    emit('fromChild', {'index': props.toChild.referenceChecker.rowIndex, 'referenceTitle': props.toChild.fromController.referencesResult[rowIndex].title, 'basic_id': props.toChild.fromController.referencesResult[rowIndex].basic_id});
    referencePickerOpen.value[props.toChild.referenceChecker.rowIndex-1]= 0;
    // console.log(props.toChild.referencePickerOpen[props.toChild.referenceChecker.rowIndex-1]);
    console.log(props.toChild.referenceChecker.rowIndex-1);

}
</script>
