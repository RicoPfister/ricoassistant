<template>

<div class="z-30">
    <div class="flex flex-col z-30">
        <div class="flex flex-row items-center z-30">

            <!-- select reference button -->
            <button @click.prevent="referenceCheckerFunction('lastUsed')" class="w-[42px] flex justify-center h-full items-center bg-gray-100 border-r border-gray-300" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-auto h-fit p-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>

            <div class="relative grow z-20">

                <!-- reference popup -->
                <div class="absolute z-10 top-[28px] -left-[33px] w-[calc(100%+34px)]">
                    <ReferencePopup v-if="props.fromController" :fromController="props.fromController" @fromChild="fromChild"/>
                </div>

                <!-- reference input -->
                <input @input="referenceCheckerFunction(props.toChild.parentIndex, props.toChild.parentId, 'inputCheck')"  class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent w-full bg-stone-50" ref="referenceDOM"  type="text" :placeholder="placeholderText" v-model="form.reference[props.toChild.parentIndex-1].referenceTitle">
            </div>
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

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'dataToParent', 'transfer', 'toParent', 'toChild', 'fromChild', 'fromController']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'referenceChecker', 'index', 'fromChild']);

let form = useForm({
    reference: {0: {'title': '', 'basic_id': ''}},
    // fromController: {},
    referencePickerOpen: [0],
    key: 1,
});

// check database Sreference
function referenceCheckerFunction(index, id, check) {
    console.log(index);
    console.log(id);
    console.log(check);

    if (form.referencePickerOpen[index-1] != 1) {
        console.log('ok');
        // form.referenceChecker['rowIndex'] = index;
        // form.referenceChecker['parentId'] = id;
        // form.referenceChecker['check'] = check;
        // form.referenceChecker['key']++;

        // check if reference popup ***selection*** has been fired and send request to controller
        if (check == 'lastUsed' && ( form.referencePickerOpen[index-1] == 0 || typeof form.referencePickerOpen[index-1] == 'undefined' )) {
            Inertia.post('refcheck', { reference: check, index, parentId: id}, {replace: true,  preserveState: true, preserveScroll: true});
        }

        // check if reference form ***input*** has been and send request to controller
        else if (check == 'inputCheck' && ( form.referencePickerOpen[index-1] == 0 || typeof form.referencePickerOpen[index-1] == 'undefined' ) &&
        form.reference[index-1].referenceTitle.length > 2) {
            console.log('ok');
            setTimeout(() => {
                Inertia.post('refcheck', { reference: form.reference[index-1].referenceTitle, row: index, parentId: id}, {replace: false,  preserveState: true, preserveScroll: true});
            }, 500);
        }
    }
    else {
        form.referenceChecker['check'] = '';
        form.referencePickerOpen[index-1] = 0;
    }
}

// watch(() => props.toChild, _.debounce( (curr, prev) => {
//     console.log(props.toChild);

// }, 500));

// save received ReferencePopup.vue data to form
function fromChild(data) {
    // console.log(data.formData.index);
    form.reference[data.referenceData.index-1] = data.referenceData;
    emit('fromChild', {'reference': form, 'parentId': data.parentId});
}

// listen to title placeholder auto set
watch(() => props.transfer, (curr, prev) => {
    if (props.transfer.misc.parentId == 1 && (props.transfer.basicData.basicTitle || props.transfer.basicData.basicTitle == '') && !form.reference[0].title) {
        // console.log(props.transfer.basicData.basicTitle);
        if (props.transfer.basicData.basicTitle == '') referenceDOM.value.placeholder = placeholderText.value
        else referenceDOM.value.placeholder = props.transfer.basicData.basicTitle;
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

// listen to form and send changes to Create.vue
// watch(() => form, (curr, prev) => {
//
// }, {deep: true}, 500);

// onMounted(() => {
//  form.parentId = props.toChild.parentId;
//  form.referenceChecker.rowIndex = ;
// })

</script>

