<template>

<!-- reference picker popup container -->
<div class="z-40 w-full flex flex-col bg-yellow-50 border-r border-b border-l border-black mb-3">

    <!-- reference picker box -->
    <div class="flex flex-col w-full">

        <!-- popup: found in database -->
        <div class="z-40 px-1">
            <div class=""><b>Reference(s) found in Database:</b></div>
            <div v-for="(item, index) in props.fromController.referencesResult" class="relative flex flex-row items-center w-full justify-between border-b last:border-b-none
            text-gray-500">

            <!-- detail reference popup -->
            <div v-if="detailPopupOpen[index]" class="absolute top-0 left-[18px] bg-yellow-50 w-[calc(100%-18px)] z-40">123</div>
                <div class="flex flex-row items-center w-[700px]">
                    <!-- <div class="flex flex-flow">
                        <button class="w-fit flex justify-center items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-[15px] h-[15px] hover:stroke-black">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018
                                18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                            </svg>
                        </button>
                    </div> -->

                    <!-- <div class="flex flex-row border-r"> -->
                        <!-- <div class="w-fit flex justify-center items-center pl-[3px] pr-[1px]">
                            <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="w-[13px] h-[13px] group-hover:stroke-black">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75
                                6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25
                                16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                            </svg>
                        </div> -->

                        <!-- total inheritances -->
                        <!-- <div class="w-2 flex justify-center group-hover:text-black">
                            {{ item.inheritance.length != '' ? item.inheritance.length : '-' }}
                        </div> -->
                    <!-- </div> -->

                    <!-- reference picker -->
                    <div class="flex flex-row justify-between group text-gray-400 w-full">

                        <!-- left part: reference icon, main reference, inheritance -->
                        <div class="flex flex-row h-[15px] w-full">

                            <!-- icon -->
                            <button type="button" class="flex items-center min-w-fit">
                                <ListIconsMedium :medium="item.medium"/>
                            </button>

                            <!-- inheritance box -->
                            <div class="flex flex-row items-center ml-1 w-full">

                                <button type="button" @click="referencePopupSelect(index)" class="font-bold text-gray-500 hover:text-black truncate max-w-full">
                                    <div class="truncate max-w-full">{{ item.title }}</div>
                                </button>

                                <div v-if="item.inheritance != ''" class="flex items-center w-fit">&nbsp;>&nbsp;</div>

                                <div class="flex flex-row min-w-0 w-0 grow">

                                    <!-- inheritance instances -->
                                    <div v-for="(item2, index2) in item.inheritance" class="flex flex-flow items-center truncate min-w-0">

                                        <!-- inheritance title -->
                                        <div class="pl-0 h-[15px] flex items-center truncate min-w-0">
                                            <div class="truncate min-w-0">{{ item2.title }}</div>
                                        </div>

                                        <!-- separator -->
                                        <div v-if="index2 < item.inheritance.length-1" class="flex items-center w-fit">&nbsp;>&nbsp;</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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
                <div>
                    <div>
                        <ListIconsMedium :medium="item.medium"/>
                     </div>
                    <div class="ml-1 text-gray-500 truncate"><div class="truncate">{{ props.fromController.referencesResult[props.toChild.referenceChecker.rowIndex-1].title }}</div></div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import ListIconsMedium from "../ListIconsMedium.vue";

let detailPopupOpen = ref([]);

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'transfer', 'toParent', 'toChild', 'fromController']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'fromChild', 'medium']);

// 1) receive data from parent
//---------------------------------

onMounted(() => {
    // console.log(1);
    // console.log(props.fromController.misc.row-1);
    // console.log(props.fromController.referencesResult);
});

// 4) send data to parent
//---------------------------------
function referencePopupSelect(rowIndex) {
    // console.log(props.toChild.fromController.referencesResult[rowIndex].basic_id);
    // console.log(props.fromController.referencesResult[rowIndex].basic_id);
    emit('fromChild', {'parentIndex': props.fromController.misc.row, 'parentId': props.fromController.misc.parentId, 'referenceData': {'index': props.fromController.misc.row, 'referenceTitle': props.fromController.referencesResult[rowIndex].title, 'basic_id': props.fromController.referencesResult[rowIndex].basic_id}});
    // emit('fromChild', 'test');
    // referencePickerOpen.value[props.toChild.referenceChecker.rowIndex-1]= 0;
}
</script>
