<template>

    <div class="flex flex-col h-full">
        <div class="relative flex flex-row items-center h-full">

            <!-- select reference button -->
            <button @click.prevent="referenceCheckerFunction(props.toChild.parentIndex, props.toChild.parentId, 'lastUsed')" class="relative
            w-[36px] flex h-full items-center
            bg-gray-100 border-r border-gray-300 leading-none pl-1" type="button">

                <!-- item counter -->
                <div class="absolute text-[10px] top-0 right-0 text-gray-500 pt-[0px] pr-[6px] flex justify-center w-2 h-full break-all
                items-center">0</div>

                <!-- tag icon -->
                <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="w-[18px] h-fit">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25
                    2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                </svg>
            </button>

            <div class="grow">

                <!-- reference popup -->
                <div class="absolute z-40 top-[31px] -left-[1px] w-[calc(100%+2px)]">
                    <ReferencePopup v-if="form.referencePickerOpen.value" :fromController="props.fromController" @fromChild="fromChild"/>
                </div>

                <!-- reference input -->
                <input @input="referenceCheckerFunction(props.toChild.parentIndex, props.toChild.parentId, 'inputCheck')"  class="outline-0
                focus:ring-0 focus:border-black
                border-none focus:placeholder-transparent w-full bg-stone-50 pl-2 h-7 leading-none text-sm text-gray-500" ref="referenceDOM"
                type="text"
                :placeholder="placeholderText" v-model="form.reference.value[0].title">
            </div>
        </div>

</div>

</template>

<script setup>

// props: ***props.fromChild*** (referenceTitle / basic_id) | ***props.fromController*** (misc.parentId) | ***componentId***
// emit: ***toParent*** (form)

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import ReferencePopup from "../ReferenceManager/ReferencePopup.vue"

let referenceDOM = ref('');
let placeholderText = ref("Insert existing title as reference");

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'dataToParent', 'transfer', 'toParent', 'toChild',
'fromChild', 'fromController', 'transferCreate']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'referenceChecker', 'index', 'fromChild', 'toChild']);

// let form = useForm({
//     reference: [{'referenceTitle': ''}],
//     referencePickerOpen: 0,
//     key: 1,
// });

let form = {
    'reference': ref([{}]),
    'referencePickerOpen': ref(0),
};

// check database Sreference
// send to parent: statement input data
function referenceCheckerFunction(index, id, check) {

    // console.log('ok');
    // console.log(index);
    // console.log(id);
    // console.log(check);

    if (form.referencePickerOpen.value != 1) {
        // console.log('ok');
        // form.referenceChecker['rowIndex'] = index;
        // form.referenceChecker['parentId'] = id;
        // form.referenceChecker['check'] = check;
        // form.referenceChecker['key']++;

        // console.log(check);
        // check if reference popup ***selection*** has been fired and send request to controller
        if (check == 'lastUsed' && ( form.referencePickerOpen.value == 0 || typeof form.referencePickerOpen.value == 'undefined')) {
            // console.log('ok');
            Inertia.post('refcheck', { reference: check, row: index, parentId: id}, {replace: true,  preserveState: true, preserveScroll: true});
        }

        // check if reference form ***input*** has been and send request to controller
        else if (check == 'inputCheck' && ( form.referencePickerOpen.value == 0 || typeof form.referencePickerOpen.value == 'undefined' ) &&
        form.reference.value[0].title.length > 2) {
            console.log('ok');
            setTimeout(() => {
                Inertia.post('refcheck', { reference: form.reference.title, row: index, parentId: id}, {replace: false,
                preserveState: true, preserveScroll: true});
            }, 500);
        }
    }

    else {
        // form.referenceChecker['check'] = '';
        form.referencePickerOpen = 0;
    }

    if (typeof form?.reference.value[0]?.title != 'undefined') {
        emit('fromChild', {'reference': '', 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex,
        'color': '', 'component': 'reference'});
    }
}

// watch(() => props.toChild, _.debounce( (curr, prev) => {
//     console.log(props.toChild);

// }, 500));

// save received ReferencePopup.vue data to form
function fromChild(data) {
    // console.log(data.referenceData);
    // form.reference.value = [];
    // console.log(form.reference.value);
    // form.reference.value[0] = '';
    // console.log(form.reference.value);
    form.reference.value[0] = data.referenceData;
    // console.log(form.reference.value);
    emit('fromChild', {'reference': form.reference.value, 'parentId': data.parentId, 'parentIndex': data.parentIndex, 'color': data.color, 'component':
    'reference'});
    // console.log(form.reference.value);
    // console.log(props.toChild.parentIndex);
    form.referencePickerOpen.value = 0;
    // console.log(form.reference.value);
}

// listen to title placeholder auto set
watch(() => props.transferCreate, (curr, prev) => {
    // console.log('ok');
    // console.log(props.transferCreate.title);
    // if (props.transfer.misc.parentId == 1 && (props.transfer.basicData.basicTitle || props.transfer.basicData.basicTitle == '') && !form.reference[0].title) {
    if (props.transferCreate.title != 'undefined') {

        // console.log(props.transfer.basicData.basicTitle);
        if (props.transferCreate.title == '') referenceDOM.value.placeholder = placeholderText.value
        else referenceDOM.value.placeholder = props.transferCreate.title;
    }
}, {deep: true}, 500);

watch(() => props.fromController, (curr, prev) => {

    // console.log(props.fromController);
    // console.log(props.toChild);

    if(props.fromController.misc?.parentId == props.toChild?.parentId && props.fromController?.misc.row == props.toChild?.parentIndex) {
        form.referencePickerOpen.value = 1;
    }

}, {deep: true}, 500);

// listen to reference controller data and save data to form
// watch(() => props.fromController, (curr, prev) => {

    // console.log('ok');

    // save fromController data in form
    // if (props.fromController.misc.parentId == 2) {
    //     form['fromController']['referencesResult'] = props.fromController.referencesResult;
    //     form['fromController']['misc'] = props.fromController.misc;
    //     form.referenceChecker.check = 'fromController';
    // }

// }, {deep: true}, 500);


watch(() => props.toChild, (curr, prev) => {
    if (props?.toChild?.parents_reference && !form?.reference?.value[0].title) {
        console.log(props.toChild.parents_reference);
        form.reference.value = [{}];
        form.reference.value[0].title = props.toChild.parents_reference
    };

}, {deep: true}, 500);

onMounted(() => {

    if (props?.toChild?.formParentReference) {
        // console.log(props.toChild.formParentReference);
        // console.log(form.reference.referenceTitle);
        form.reference.value[0].title = props.toChild.formParentReference[0][0].title;
    }

    if (props?.toChild?.parents_reference) {
        // console.log('ok');
        // console.log(props.toChild.parents_reference);
        // console.log(form.reference.referenceTitle);
        // form.reference.referenceTitle = props.toChild.formParentReference[0][0].title;
        form.reference.value[0].title = props.toChild.parents_reference;
    }
//  form.parentId = props.toChild.parentId;
//  form.referenceChecker.rowIndex = ;
})


// function InputData() {
//     emit('fromChild', {'section':'statementData', 'subSection': 'statement', 'form': form.statement});
// }

</script>

