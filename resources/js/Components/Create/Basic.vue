<template>

<div class="h-full">
    <div class="relative flex gap-3 flex-wrap w-full min-w-0 h-fit">

        <!-- form date input -->
        <div class="flex flex-col">
            <label class="font-bold" aria-label="Referenced Date Input" for="acc_date">Created at:</label>
            <input :class="{'border-red-500 focus:border-red-500 border-4 bg-red-200': form2?.errors?.['basicData.ref_date']}" class="w-[141px] border border-black outline-0 focus:border-black focus:ring-0 h-10 leading-none" id="acc_date" placeholder="Search" type="date" v-model="form['basicRefDate']">
            <div v-if="form2?.errors?.['basicData.ref_date']" class="text-red-500">{{ form2?.errors?.['basicData.ref_date'] }}</div>
        </div>

        <!-- form category selection -->
        <div class="flex flex-col w-36">
            <label class="font-bold" aria-label="Category Input font-bold leading-none text-sm" for="medium">Type:</label>
            <select :class="{'border-red-500 focus:border-red-500 border-4 bg-red-200': form2?.errors?.['basicData.medium']}" class="border border-black outline-0 focus:border-black focus:ring-0 h-10" id="medium" v-model="form['basicMedium']">
                <option value="null" disabled>Select one:</option>
                <option value=""></option>
                <option value="9">Evaluation</option>
                <option value="8">Exchange</option>
                <option value="7">Education</option>
                <option value="6">Elaboration</option>
                <option value="5">Fact</option>
                <option value="4">Admin</option>
                <option value="3">Media</option>
                <option value="2">Story</option>
                <option value="1">Idle</option>
            </select>
            <div v-if="form2?.errors?.['basicData.medium']" class="text-red-500">{{ form2?.errors?.['basicData.medium'] }}</div>
        </div>

        <!-- form title input -->
        <div class="grow">
            <div class="flex flex-col grow">
                <div class="flex justify-between">
                    <label class="font-bold" aria-label="Category Input" for="title">Title:</label>
                    <label class="font-bold" aria-label="Category Input" for="title">Public:</label>
                </div>

                <!-- title input -->
                <div class="flex flex-row">
                    <input :class="{'border-red-500 focus:border-red-500 border-4 bg-red-200': form2?.errors?.['basicData.title']}" class="border border-black focus:placeholder-white first-letter:outline-0 focus:border-black focus:ring-0 leading-none h-10 grow" id="title" type="text" v-model="form['basicTitle']">
                    <div class="form_public_background px-3 border-t border-r border-b border-black h-10 flex items-center">
                        <input class="outline-0 focus:border-black focus:ring-0 bg-white" type="checkbox" v-model="form.basicPublic">
                    </div>
                </div>
                <!-- warnings -->
                <button v-if="basicTitleWarning" @click="basicTitelPickerOpen = !basicTitelPickerOpen" type="button" class="absolute top-[32px] right-10 pr-1 flex flex-row items-center">
                    <div class="text-xs text-gray-500"></div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'fill-red-500': usePage().props.value.flash.fromController?.misc.parentId == 1 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : '', 'text-black': usePage().props.value.flash.fromController?.misc.parentId == 1 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : ''}" fill="none" color="rgb(107 114 128)" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </button>

                <!-- titel instant search popup -->
                <div v-if="basicTitelPickerOpen" class="absolute z-50 -top-[5px] left-0 mt-[66px] h-fit w-full text-sm xl:text-lg bg-red-500 border-gray-400 p-1 flex flex-col">

                    <div class="flex flex-row items-center z-50">

                        <div class="text-sm xl:text-base z-50 w-full max-h-52 overflow-y-auto">

                            <div class="text-sm"><b>{{usePage().props.value.flash.fromController?.[0].basicResult?.[0].warning == 2 ? 'Duplicate entry found in database. Please change created at, type or title.' : 'Similar titles found in database:'}}</b></div>

                            <div v-for="(item, index) in usePage().props.value.flash.fromController?.[0]?.basicResult" :key="index" :class="{'bg-gray-100': index % 2 == 0}" class="flex flex-row items-center w-full">

                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </button>

                                <!-- button title picker -->
                                <div class="flex justify-between w-full">
                                    <button type="button" @click.prevent="" class="ml-1 text-gray-500 hover:text-black truncate grow text-left" :class="{'text-red-500': usePage().props.value.flash.fromController[0].basicResult[0].warning == 2, 'hover:text-red-800': usePage().props.value.flash.fromController.misc.parentID == 1 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : ''}" ><div class="truncate">{{ item.title }}</div></button>
                                    <button type="button" @click.prevent="" class="ml-1 text-gray-500 hover:text-black truncate" :class="{'text-red-500': usePage().props.value.flash.fromController.misc.parentID == 3 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : '', 'hover:text-red-800': usePage().props.value.flash.fromController.misc.parentID == 3 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : ''}" ><div class="truncate">{{ item.medium }}</div></button>
                                    <button type="button" @click.prevent="" class="ml-1 text-gray-500 hover:text-black truncate" :class="{'text-red-500': usePage().props.value.flash.fromController.misc.parentID == 3 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : '', 'hover:text-red-800': usePage().props.value.flash.fromController.misc.parentID == 3 ? usePage().props.value.flash.fromController[0].basicResult[0].warning == 2 : ''}" ><div class="truncate">{{ item.refDate }}</div></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="form2?.errors?.['basicData.title']" class="text-red-500">{{ form2?.errors?.['basicData.title'] }}</div>
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
let title_check = 0;
let formPublic = 0;

// let test123 = ref(usePage().props?.errors);
// const test123 = computed(() => usePage().props.value.errors);

const form = useForm({
    'basicMedium': '',
    'basicTitle': '',
    'basicRefDate': '',
    'basicPublic': false,
});

const props = defineProps(['dataParent', 'fromController', 'toParent', 'transfer', 'toChild', 'fromController2', 'fromController_validation']);
let emit = defineEmits(['fromChild', 'fromController_validation']);

function emitRefDate() {
    emit('fromChild', {'section':'basicData', 'subSection':'ref_date', 'form': form.basicRefDate});
}

function emitPublic() {
    // console.log('ok');
    emit('fromChild', {'section':'basicData', 'subSection':'public', 'form': form.basicPublic});
}

// send input to Create.vue
watch(() => form.basicRefDate, (curr, prev) => {
    // console.log(form);
    // emit('fromChild', {'form': {'basicData': form, 'misc': {'parentId': 1}}});
    // console.log('ok');
    emitRefDate();
});

watch(() => form.basicMedium, (curr, prev) => {
    // console.log(form);
    // emit('fromChild', {'form': {'basicData': form, 'misc': {'parentId': 1}}});
    // console.log('ok');
    emit('fromChild', {'section':'basicData', 'subSection':'medium', 'form': form.basicMedium});
});

watch(() => form.basicTitle, (curr, prev) => {
    // console.log(form);
    // emit('fromChild', {'form': {'basicData': form, 'misc': {'parentId': 1}}});
    // console.log('ok');
    emit('fromChild', {'section':'basicData', 'subSection':'title', 'form': form.basicTitle});
});

watch(() => form.basicPublic, (curr, prev) => {
    // console.log(form);
    // emit('fromChild', {'form': {'basicData': form, 'misc': {'parentId': 1}}});
    // console.log('ok');
    emitPublic();
});

// processing parent props
watch(() => usePage().props.value.flash.fromController, (curr, prev) => {
    if (usePage().props.value.flash.fromController?.misc?.parentId == 1) {

        // console.log(usePage().props.value.flash.fromController);
        // cl(props.dataParent.basicTitleData[0].warning);
        // console.log(typeof props.dataParent.basicTitleData[0]);
        if (usePage().props.value.flash.fromController[0].basicResult[0].warning > 0) {
            basicTitleWarning.value = 1;
            emit('fromChild', {'section':'basicData', 'subSection':'blocking', 'form': 1});
            if (usePage().props.value.flash.fromController[0].basicResult[0].warning == 2) basicTitelPickerOpen.value = 1;
        }
    }
}, {deep: true}, 500);

// basic title checker
function basicTitleChecker() {
    basicTitelPickerOpen.value = 0;
    basicTitleWarning.value = 0;
    emit('fromChild', {'section':'basicData', 'subSection':'blocking', 'form': 0});

    if (form?.basicTitle?.length > 2) {
        setTimeout(() => {
            // console.log(form);
            Inertia.get('/create/titlecheck', {basicRefDate: form.basicRefDate, basicTitle: form.basicTitle, basicMedium: form.basicMedium, parentId:1, id: props?.toChild?.basicData?.id},
            {replace: false, preserveState: true, preserveScroll: true});
        }, 500);
    };
}

// listen if medium/title is auto set
watch(() => props.toChild, (curr, prev) => {

    // console.log('ok');

    if (props?.toChild?.activityData && (form['basicTitle'] == undefined || form['basicTitle'] == '') && (form['basicMedium'] == undefined || form['basicMedium'] == '')) {
        form['basicRefDate'] = Date.dateNow();
        form['basicTitle'] = 'Activity ' +  Date.dateNow();
        form['basicMedium'] = 4;
        // form['titleCheckActive'] = 0;
    }

}, {deep: true});



// watch(() => props.transfer, (curr, prev) => {
//     if (!form['basicTitle'] && !form['basicMedium']) {
//         form['basicTitle'] = props.transfer.basicTitle;
//         form['basicMedium'] = props.transfer.basicMedium;
//     }
// }, {deep: true}, 500);

// watch(() => usePage().rememberedState?.value?.key1?.data?.test, (curr, prev) => {
//     console.log('ok');
// }, {deep: true}, 500);

// send title check


onMounted(() => {
    // console.log(props.dataParent);

        if (props.toChild?.basicData?.medium != undefined & props.toChild?.basicData?.title != undefined) {

        // console.log(props.toChild?.basicData?.restriction);

        if (props.toChild?.basicData?.restriction == 0) formPublic = true;
        else formPublic = false;

        form['basicMedium'] = props.toChild?.basicData?.medium;
        form['basicTitle'] = props.toChild?.basicData?.title;
        form['basicRefDate'] = props.toChild?.basicData?.ref_date;
        form['basicPublic'] = formPublic;

    } else {

        // console.log('ok');
        title_check = 2;
    };

    // if (props.toChild?.basicData?.ref_date) {

    //     form['basicRefDate'] = props.toChild?.basicData?.ref_date;
    // }

    // send form date and public value to create

    emitRefDate();
    emitPublic();
});

watch(() => form, (curr, prev) => {
    // console.log(curr.basicTitle == prev.basicTitle);

    // console.log(title_check);
    if (form?.basicRefDate && form?.basicMedium && form?.basicTitle && title_check > 1) basicTitleChecker();
    else title_check++;
    // console.log(title_check);

}, {deep: true});

// validation error processing

const form2 = useForm('key1', {'test': null});

watch(() => usePage().props.value.errors, (curr, prev) => {

    // console.log(usePage().props.value.errors);
    // console.log(Object.keys(usePage()?.props.value?.errors).length);
    // console.log(Object.keys(form2['errors']).length);

    if (Object.keys(usePage()?.props.value?.errors).length) {

            // console.log('ok');
            form2['errors'] = usePage().props.value.errors;
    }

    // else if (Object.keys(usePage()?.props.value?.errors).length == 0 && Object.keys(form2['errors']).length == 1) {
    //         console.log('ok');
    //         form2['errors'] = '';
    //     }
});

</script>
