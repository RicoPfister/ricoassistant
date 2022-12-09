<template>

<!-- reference picker popup container -->
<div v-if="referencePickerOpen[0]" class="z-50 absolute top-0 left-0 mt-8 h-fit w-full bg-white border-r border-b border-l border-gray-400 px-2 flex flex-col">

    <!-- reference picker box -->
    <div class="flex flex-col z-50 overflow-y-auto max-h-52 text-sm xl:text-base w-full ">

        <!-- selected reference -->
        <div class="">
            <div class=""><b>Input:</b></div>
            <div v-for="item in form.activityReference" class="flex flex-row items-center w-full">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </button>
                <!-- button reference picker -->
                <button type="button" @click.prevent="form.activityReference[props.index-1] = {id: item.id}; form.value.activityReference[props.index-1].title = item.title; activityDiagramColorTag[props.index-1] = item.color, referencePickerOpen[props.index-1] = !props.referencePickerOpen[props.index-1]" class="ml-1 text-gray-500 hover:text-black truncate"><div class="truncate">{{ item.title }}</div></button>
            </div>
        </div>

        <!-- found in database -->
        <div class="">
            <div class=""><b>Found in Database:</b></div>
            <div v-for="(item, index) in form.fromController.referencesResult" class="flex flex-row items-center w-full">
                <button>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                </button>

                <!-- button reference picker -->
                <button type="button" @click="referencePopupSelect(index)" class="ml-1 text-gray-500 hover:text-black truncate"><div class="truncate">{{ item.title }}</div></button>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'transfer', 'toParent', 'referencePickerOpen', 'fromParent', 'index']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'fromChild']);

let referencePickerOpen = ref({});
let fromController = ref({});
let form = ref();

onMounted(() => {
    form.value = props.fromParent;
})

// 1.1 data received from parent
//---------------------------------
// watch(() => form.value, (curr, prev) => {

// }, {deep: true}, 500);

// 1) receive data from parent
// 2) send data to controller
//---------------------------------
watch(() => props.fromParent, (curr, prev) => {

    form.value = props.fromParent;

    if (form.value.referenceChecker.check == 'fromController') {
        console.log(props.fromParent);
        if (fromController.value) {
            console.log(referencePickerOpen.value[form.value.fromController.misc.row-1]);
            referencePickerOpen.value[form.value.fromController.misc.row-1] = 1;
            console.log('controller ok');
        }
    }

    if (form.value.referenceChecker.check == 'lastUsed' && ( referencePickerOpen.value[form.value.referenceChecker.rowIndex-1] == 0 || typeof referencePickerOpen.value[form.value.referenceChecker.rowIndex-1] == 'undefined' )) {
        Inertia.post('refcheck', { activityReference: form.value.referenceChecker.check, row: form.value.referenceChecker.rowIndex }, {replace: true,  preserveState: true, preserveScroll: true});
    }

    // else if (referencePickerOpen.value[form.value.referenceChecker.rowIndex-1] == 1) referencePickerOpen.value[form.value.referenceChecker.rowIndex-1] = 0;
    else if (form.value.referenceChecker.check == 'inputCheck' && ( referencePickerOpen.value[form.value.referenceChecker.rowIndex-1] == 0 || typeof referencePickerOpen.value[form.value.referenceChecker.rowIndex-1] == 'undefined' ) && form.value.activityReference[form.value.referenceChecker.rowIndex-1].title.length > 2) {
        setTimeout(() => {
            Inertia.post('refcheck', { activityReference: form.value.activityReference[form.value.referenceChecker.rowIndex-1].title, row: form.value.referenceChecker.rowIndex}, {replace: false,  preserveState: true, preserveScroll: true});
        }, 500);
    }

}, {deep: true}, 500);

// 4) send data to parent
//---------------------------------
function referencePopupSelect(rowIndex) {

    // console.log(props.index-1);

    emit('fromChild', {'rowIndex': props.index, 'referenceTitle': form.value.fromController.referencesResult[rowIndex].title});
    referencePickerOpen.value[props.index] = 0;

    // console.log(form.value.fromController.referencesResult[rowIndex].title);
}

// console.log(form.value);

</script>
