<template>

<!-- reference picker popup container -->
<div class="z-40 w-full flex flex-col bg-gray-200 border-r border-b border-l border-black mb-8">

    <!-- reference picker box -->
    <div class="flex flex-col w-full">

        <!-- popup: found in database -->
        <div class="z-40 px-2 pb-1">
            <div class=""><b>Reference(s) found in Database:</b></div>
            <div @mouseleave="detailPopupOpen[index] = 0; showInheritanceTitleActive = 0; showInheritanceIndexActive = 0;" v-for="(item, index) in props.fromController.referencesResult" class="relative flex flex-row items-center
            justify-between border-b last:border-b-none text-gray-500">

            <!-- detail reference popup -->
            <div v-if="detailPopupOpen[index]" class="absolute top-0 left-[18px] bg-stone-300 w-[calc(100%-18px)] z-40 flex flex-col">

                <!-- title and inheritances -->
                <div class="flex flex-col border">
                    <div>
                        <button @click="referencePopupSelect(index)" v-if="showInheritanceTitleActive == 0" type="button" class="truncate font-bold ml-1 hover:text-black w-[700px] text-start">{{ item.title }}</button>
                    </div>
                    <div>
                        <div v-for="(item2, index2) in item.inheritance">
                            <div v-if="showInheritanceTitleActive == index2+1" class="truncate ml-1 w-[700px] text-start">{{ item2.title }}</div>
                        </div>
                    </div>
                </div>

                <!-- detail reference info row -->
                <div class="flex flex-row border-t">

                    <!-- inheritance index -->
                    <button class="flex justify-center pl-1 items-center pr-1 hover:text-black">{{ !showInheritanceIndexActive ? item?.inheritance?.length+1 : item.inheritance.length+1-showInheritanceIndexActive }}</button>

                    <!-- button previous reference -->
                    <button @click.prevent="showInheritanceSwitchher('previous', index)" class="border-l w-5 flex items-center justify-center text-center bg-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                        </svg>
                    </button>

                    <!-- button next reference -->
                    <button @click.prevent="showInheritanceSwitchher('next', index)" class="border-l w-5 flex items-center justify-center text-center bg-slate-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>

                    <!-- updated at -->
                    <div class="border-l flex w-fit px-1">{{ showInheritanceIndexActive == 0 ? item.updated_at?.slice(0, 11) : props?.fromController?.referencesResult[showInheritanceIndexActive+1]?.updated_at?.slice(0, 11) }}</div>

                    <!-- medium-->
                    <!-- <div class="border-l flex w-fit pl-1">{{ props.fromController.referencesResult[showInheritanceIndexActive-1].medium_name[0] }}</div> -->
                    <div class="border-l flex w-fit pl-1">{{ showInheritanceIndexActive == 0 ? item?.medium_name?.[0] : props.fromController.referencesResult[showInheritanceIndexActive+1]?.medium_name?.[0] }}</div>
                </div>
            </div>

            <div class="flex flex-row items-center w-[700px]">
                <!-- reference picker -->
                <div class="flex flex-row justify-between group text-gray-400 w-full">

                    <!-- left part: reference icon, main reference, inheritance -->
                    <div class="flex flex-row w-full items-center h-[18px]">

                        <!-- icon -->
                        <button @mouseover="detailPopupOpen[index] = 1" type="button" class="flex items-center min-w-fit h-full">
                            <ListIconsMedium :medium="item.medium"/>
                        </button>

                        <!-- inheritance box -->
                        <div class="flex flex-row items-center ml-1 w-full h-fit">

                            <button type="button" @click="referencePopupSelect(index)" class="font-bold text-gray-500 hover:text-black truncate max-w-full">
                                <div class="truncate max-w-full p-0 leading-none">{{ item.title }}</div>
                            </button>

                            <div v-if="item.inheritance != null && item.inheritance != ''" class="flex items-center w-fit">&nbsp;>&nbsp;</div>

                            <div class="flex flex-row min-w-0 w-0 grow">

                                <!-- inheritance instances -->
                                <div v-for="(item2, index2) in item.inheritance" class="flex flex-flow items-center truncate min-w-0">

                                    <!-- inheritance title -->
                                    <div class="pl-0 h-[15px] flex items-center truncate min-w-0">
                                        <div class="truncate min-w-0 items-center">{{ item2?.title }}</div>
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

                <!-- tag icon/button -->
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
let showInheritanceTitleActive = ref(0);
let showInheritanceIndexActive = ref(0);

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'transfer', 'toParent', 'toChild', 'fromController']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'fromChild', 'medium']);

// 1) receive data from parent
//---------------------------------

onMounted(() => {
    // console.log(1);
    // console.log(props.fromController.misc.row-1);
    // console.log(props.fromController.referencesResult);
    // showInheritanceIndexActive.value = props.fromController.inheritance.length+1;
});

// 4) send data to parent
//---------------------------------
function referencePopupSelect(rowIndex) {
    // console.log(props.toChild.fromController.referencesResult[rowIndex].basic_id);
    // console.log(props.fromController.referencesResult[rowIndex].basic_id);
    emit('fromChild', {'parentIndex': props.fromController.misc.row, 'parentId': props.fromController.misc.parentId, 'color': props.fromController.referencesResult[rowIndex].color, 'referenceData': {'index': props.fromController.misc.row, 'title': props.fromController.referencesResult[rowIndex].title, 'basic_id': props.fromController.referencesResult[rowIndex].basic_id}});
    // emit('fromChild', 'test');
    // referencePickerOpen.value[props.toChild.referenceChecker.rowIndex-1]= 0;
}

function showInheritanceSwitchher(switcher, index) {
    // console.log(showInheritanceValue.value.innerHTML = 'qdfadsf');
    // showInheritanceValue.value.innerHTML = '123';
    // showInheritanceValue.value.innerTEXT = '123';

    if (switcher == 'next') {
        if (showInheritanceIndexActive.value != props.fromController.referencesResult[index].inheritance.length) {
            showInheritanceTitleActive.value++;
            showInheritanceIndexActive.value++;
        } else {
            showInheritanceTitleActive.value = 0;
            showInheritanceIndexActive.value = 0;
        }
    };

    if (switcher == 'previous') {
        if (showInheritanceIndexActive.value > 0) {
            showInheritanceTitleActive.value--;
            showInheritanceIndexActive.value--;
        } else {
            showInheritanceTitleActive.value = props.fromController.referencesResult[index].inheritance.length;
            showInheritanceIndexActive.value = props.fromController.referencesResult[index].inheritance.length;
        }
    }

    // console.log(showInheritanceIndexActive.value);
}

function addtab() {
    emit('addtab');
}

</script>
