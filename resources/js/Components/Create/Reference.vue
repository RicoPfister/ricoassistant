<template>

<div>
    <div class="flex flex-col">
        <button class="flex flex-row justify-between items-center" type="button">
            <label class="font-bold" aria-label="Statement Input" for="statement">Reference
            </label>
            <!-- <MenuEntry /> -->
        </button>

        <div class="flex flex-row items-center border border-black h-fit">
            <button class="w-8 flex justify-center items-center bg-gray-100 border-r border-gray-300 h-fit" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-fit h-fit p-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </button>
            <div class="relative grow">
                <!-- reference popup -->
                <ReferencePopup :toChild="form" @fromChild="fromChild" :index="1"/>

                <!-- reference input -->
                <input @input="referenceCheckerFunction('inputCheck')" class="outline-0 focus:ring-0 border-none focus:placeholder-transparent w-full leading-none h-8" type="text" placeholder="" ref="referenceDOM" v-model="form.activityReference[0].title">
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import ReferencePopup from "../ReferenceManager/ReferencePopup.vue"

let referenceDOM = ref('');

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'fromController', 'transfer', 'toParent', 'toChild']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'referenceChecker', 'index']);

const form = useForm({
    activityReference: [{title: '', medium: '', color: ''}],
    referenceChecker: {'rowIndex': '', 'check': '', 'id': 1},
    fromController: {},
    referencePickerOpen: [0],
    parentId: 2
});

// import MenuEntry from "./MenuEntry.vue";

function referenceCheckerFunction(data) {
        // referenceUpdate.value++;
    if (form.referencePickerOpen[0] != 1) {
        form.referenceChecker['rowIndex'] = 1;
        form.referenceChecker['check'] = data;
        form.referenceChecker['id']++;
    }
    else {
        form.referenceChecker['check'] = '';
        form.referencePickerOpen[0] = 0;
    }
}

watch(() => props.referenceChecker, (curr, prev) => {
    console.log('ok');
}, {deep: true}, 500);

// listen to reference placeholder auto set
watch(() => props.toChild.basicTitle, _.debounce( (curr, prev) => {
    if (!reference.value) referenceDOM.value.placeholder = props.toChild.basicTitle;
}, 500));

// save received ReferencePopup data to form
function fromChild(data) {
    // console.log(data);
    if (props.fromController.misc.parentId == 2) {
    form.activityReference[0] = {'title': data.referenceTitle};
    form.referenceChecker['check'] = '';
    }
}

// save fromController data in form
watch(() => props.fromController, (curr, prev) => {
    // console.log('ok');
    if (props.fromController.misc.parentId == 2) {
        form['fromController'] = props.fromController;
        form.referenceChecker.check = 'fromController';
    }

}, {deep: true}, 500);

// listen to form and send changes to Create.vue
watch(() => form, (curr, prev) => {
    emit('toParent', {'referenceReference': form});
}, {deep: true}, 500);

</script>

