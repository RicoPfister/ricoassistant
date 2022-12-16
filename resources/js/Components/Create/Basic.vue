<template>

<div class="h-full">
    <div class="flex gap-3 flex-wrap w-full min-w-0 h-fit">
        <div class="flex flex-col">
            <label class="font-bold" aria-label="Referenced Date Input" for="acc_date">Date*:</label>
            <input class="w-[141px] border border-black outline-0 focus:border-black focus:ring-0 h-9 leading-none" id="acc_date" placeholder="Search" type="date" v-model="form['basicRefDate']">
        </div>

        <div class="flex flex-col lg:max-w-fit">
            <label class="font-bold" aria-label="Category Input font-bold leading-none text-sm" for="medium">Medium*:</label>
            <select class="border border-black outline-0 focus:border-black focus:ring-0 h-9 leading-none" id="medium" v-model="form['basicMedium']">
                <option value="null" disabled>Select one:</option>
                <option value=""></option>
                <optgroup label="Idea:">
                    <option value="1">Sound</option>
                    <option value="2">Picture</option>
                    <option value="3">Video</option>
                    <option value="4">Letter</option>
                    <option value="5">Interactivity</option>
                </optgroup>
                <optgroup label="Identity:">
                    <option value="6">System</option>
                    <option value="7">Location</option>
                    <option value="8">Self Awareness</option>
                    <option value="9">Self Reproduction</option>
                    <option value="10">External Activation</option>
                    <option value="11">External Motivation</option>
                </optgroup>
            </select>
        </div>

        <div class="grow">
            <div class="relative flex flex-col grow">
                <label class="font-bold" aria-label="Category Input" for="title">Title*:</label>

                <!-- title input -->
                <input @input="basicTitleChecker()" class="focus:placeholder-white border border-black outline-0 focus:border-black focus:ring-0 leading-none h-9" id="title" type="text" v-model="form['basicTitle']">

                <!-- warnings -->
                <button v-if="basicTitleWarning" @click="basicTitelPickerOpen = !basicTitelPickerOpen" type="button" class="absolute top-[29px] right-0 pr-1 flex flex-row items-center">
                    <div class="text-xs text-gray-500"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'fill-yellow-400': props.fromController.misc.parentId == 1 ? props.fromController[0].basicResult[0].warning == 2 : '', 'text-black': props.fromController.misc.parentId == 1 ? props.fromController[0].basicResult[0].warning == 2 : ''}" fill="none" color="rgb(107 114 128)" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </button>

                <!-- titel instant search popup -->
                <div v-if="basicTitelPickerOpen" class="absolute z-50 -top-[10px] left-0 mt-[66px] h-fit w-full text-sm xl:text-lg bg-white border-r border-b border-l border-gray-400 p-1 flex flex-col">

                    <div class="flex flex-row items-center z-50">

                        <div class="text-sm xl:text-base z-50 w-full max-h-52 overflow-y-auto">

                            <div class="text-sm"><b>Found in Database:</b></div>

                            <div v-for="(item, index) in props.fromController[0].basicResult" :key="index" :class="{'bg-gray-100': index % 2 == 0}" class="flex flex-row items-center w-full">

                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </button>

                                <!-- button title picker -->
                            <div class="flex justify-between w-full">
                                <button type="button" @click.prevent="" class="ml-1 text-gray-500 hover:text-black truncate grow text-left" :class="{'text-red-500': props.fromController[0].basicResult[0].warning == 2, 'hover:text-red-800': props.fromController.misc.parentID == 1 ? props.fromController[0].basicResult[0].warning == 2 : ''}" ><div class="truncate">{{ item.title }}</div></button>
                                <button type="button" @click.prevent="" class="ml-1 text-gray-500 hover:text-black truncate" :class="{'text-red-500': props.fromController.misc.parentID == 3 ? props.fromController[0].basicResult[0].warning == 2 : '', 'hover:text-red-800': props.fromController.misc.parentID == 3 ? props.fromController[0].basicResult[0].warning == 2 : ''}" ><div class="truncate">{{ item.ref_date }}</div></button>
                            </div>
                        </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import * as Date from "../../Scripts/date.js"

let basicTitelPickerOpen = ref(0);
let basicTitleWarning = ref(0);

const form = useForm({
    'basicMedium': '',
    'basicTitle': '',
    'basicRefDate': Date.dateNow(),
});

const props = defineProps(['dataParent', 'fromController', 'toParent', 'transfer', 'toChild']);
let emit = defineEmits(['fromChild']);

// send input to Create.vue
watch(() => form, (curr, prev) => {
    // console.log(form);
    // emit('fromChild', {'form': {'basicData': form, 'misc': {'parentId': 1}}});
    // console.log('ok');
    emit('fromChild', {'section':'basicData', 'subSection':'refDate', 'form': form.basicRefDate});
    emit('fromChild', {'section':'basicData', 'subSection':'medium', 'form': form.basicMedium});
    emit('fromChild', {'section':'basicData', 'subSection':'title', 'form': form.basicTitle});
}, {deep: true}, 500);

// processing parent props
watch(() => props.fromController, (curr, prev) => {
    if (props.fromController.misc.parentId == 1) {

        // console.log(props.fromController);
        // cl(props.dataParent.basicTitleData[0].warning);
        // console.log(typeof props.dataParent.basicTitleData[0]);
        if (props.fromController[0].basicResult[0].warning > 0) {
            basicTitleWarning.value = 1;
            if (props.fromController[0].basicResult[0].warning == 2) basicTitelPickerOpen.value = 1;
        }
    }
}, {deep: true}, 500);

// basic title checker
function basicTitleChecker() {
    basicTitelPickerOpen.value = 0;
    basicTitleWarning.value = 0;

    if (form.basicTitle.length > 2) {
        setTimeout(() => {
            Inertia.post('titlecheck', {basicRefDate: form.basicRefDate, basicTitle: form.basicTitle, parentId:1},
            {replace: false,  preserveState: true, preserveScroll: true});
        }, 500);
    };
}

// listen if medium/title is auto set
watch(() => props.transfer, (curr, prev) => {
    // console.log(props.transfer);
    if (!form['basicTitle'] && !form['basicMedium']) {
        form['basicTitle'] = props.transfer.basicTitle;
        form['basicMedium'] = props.transfer.basicMedium;
    }
}, {deep: true}, 500);

</script>
