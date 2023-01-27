<template>

<div class="flex flex-col w-full">

    <div class="flex flex-row items-center h-[30px]">

        <!-- add button -->
        <button @click.prevent="tagPopupOpenData" class="relative w-[36px] flex h-full items-center bg-gray-100 border-r border-gray-300 leading-none pl-1" type="button">

            <!-- item counter -->
            <div class="absolute text-[10px] top-0 right-0 text-gray-500 pt-[0px] pr-[6px] flex justify-center w-2 h-full break-all items-center">0</div>

            <!-- tag icon -->
            <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-fit">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699
                1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
        </button>

        <!-- open popup -->
        <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0 z-50">
            <TagPopup :fromController="props.fromController" :toChild="{'tagSelectionListString': tagCollectionInputFormat[0], 'basicTitle': props.toChild.basicTitle}"
            @fromChild="fromChild"/>
        </div>

        <!-- tag input -->
        <div v-if="tagInputShow" class="grow">
            <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent bg-stone-50 pl-2 h-7 leading-none text-sm
            text-gray-500 w-full" type="text" placeholder="Insert tags: @Category:Context:Value(Detail)" v-model="tagCollectionInputFormat[0]">
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

// import MenuEntry from "../Create/MenuEntry.vue";
import TagPopup from "../TagManager/TagPopup.vue";
import * as TagFromStringToGroup from "../../Scripts/tagFromStringToGroup.js"

let props = defineProps(['dataForm', 'dataCommon', 'emitToParent', 'fromParent', 'fromChild', 'toChild', 'fromController']);
let emit = defineEmits(['dataForm', 'dataCommon', 'dataToParent', 'toChild', 'fromChild']);

// let form = useForm({

// });

let tagPopupOpen = ref(0);
let tagCollectionInputIndex = ref(0);
let tagCollectionInputFormat = ref([]);
let tagCollectionGroupFormat = ref([]);
let controllerDataArrived = ref(0);
let fromController = ref('');
let tagInputShow = ref(1);

// onMounted(() => {
//     console.log(props.dataForm.basicTitle);

//     if (typeof props.dataParent.title != 'undefined') {
//         // console.log(props.dataForm.statement);
//         title = props.dataParent.title;
//     } else title = 'No title found';
// })

// function emitToParent() {
//     console.log('test');
//     if(data.tagCollectionString) {
//         tagCollectionInputFormat.value = data;
//         tagPopupOpen.value = 0;
//     }
// }

// onMounted(() => {
//     titleOpen.value = !titleOpen.value;
// });

// listen to controller feedback and opens tag popup
watch(() => props.fromController, (curr, prev) => {
    if (props.fromController?.misc?.parentId == props.toChild?.parentId && props.fromController.misc?.parentIndex == props.toChild?.parentIndex) {
        // console.log('ok');
        tagPopupOpen.value = 1;
    }

}, {deep: true}, 500);

//   tag popup (formerly part of Source.vue)
// ---------------------------------------------------------

// let emit = defineEmits(['dataForm']);

// onMounted(() => {
//     console.log(props.dataForm.basicTitle);

//     if (typeof props.dataParent.title != 'undefined') {
//         // console.log(props.dataForm.statement);
//         title = props.dataParent.title;
//     } else title = 'No title found';
// })

// send tag string to tag popup
// let tagCollectionInputFormat = ref([]);

function fromChild(data) {

    // console.log(data.tagSelectionListString);
    // console.log(TagFromStringToGroup.tagFromStringToGroup(data.tagCollection));

    if (typeof data.tagSelectionListString !== 'undefined') {

        // console.log('ok');

        if (fromController.value.misc.parentId == props.toChild?.parentId && fromController.value.misc.parentIndex == props.toChild.parentIndex) {

            // console.log('ok');
            // console.log(data.tagCollection);
            // tagCollectionInputFormat.value = data.tagCollection;

            if (data.tagSelectionListString !== '') tagCollectionInputFormat.value[0] = data.tagSelectionListString;
            if (data.tagSelectionListGroup !== '') tagCollectionGroupFormat.value[0] = data.tagSelectionListGroup;

            tagPopupOpen.value = 0;
        }
    }

    if (data.tagPreset) emit('fromChild', {'tagPreset': data.tagPreset});
    // console.log(data);
}

// function tagPopupOpenData(index) {

//     tagCollectionInputIndex.value = index;
//     tagPopupOpen.value = 1;
//     console.log(tagCollectionInputIndex.value);
// }

// request controller data
//! triple inertia.post => see popup preset and single inertia.post
function tagPopupOpenData() {
    Inertia.post('tag', {'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex});
}

// send changes to parent
// send to parent: listen to tag changes
// console.log(tagCollectionGroupFormat.value);
watch(() => tagCollectionGroupFormat.value, (curr, prev) => {
    // console.log(tagCollectionGroupFormat.value[0]);
    emit('fromChild', {'tagList': tagCollectionGroupFormat.value[0], 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex, 'component': 'tag'});
}, {deep: true}, 500);

watch(() => tagCollectionInputFormat.value[0], (curr, prev) => {
    // console.log(tagCollectionInputFormat.value[0]);
    if (typeof tagCollectionInputFormat.value[0] !== 'undefined') {
        emit('fromChild', {'tagList': TagFromStringToGroup.tagFromStringToGroup(tagCollectionInputFormat.value[0]), 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex, 'component': 'tag'});
    }
}, {deep: true}, 500);

// listen to fromController and save it in fromController
watch(() => props.fromController, (curr, prev) => {
    // console.log('ok');
    // console.log(props?.fromController);
    if (props?.fromController) {
        // console.log('ok');
        fromController.value = props.fromController};
}, {deep: true}, 500);

watch(() => props?.toChild?.formTags, (curr, prev) => {
    // console.log('ok');
    if (props?.toChild?.formTags && !tagCollectionInputFormat.value.length > 0 ) {
        // console.log('ok');
    tagCollectionInputFormat.value = [''];
    props.toChild.formTags.forEach(createTagInputGroup);
};

}, {deep: true}, 500);

onMounted(() => {
    // console.log(props.toChild);

    // if (props?.toChild?.editTag) {
    //     console.log(props.toChild.editTag);
    //     props.toChild.editTag[0].forEach(createTagInputGroup);
    // }

    if (props?.fromController) {
        fromController.value = props.fromController;
    };

    if (typeof props.toChild?.tagInputShow !== 'undefined') {
        // console.log(data);
        tagInputShow.value = props.toChild.tagInputShow;
    }
    // tagCollection.value.push(['Preset', ['Admin123', 'Movie Rating']]);

    if (props?.toChild?.formTags) {





// console.log(props.toChild.formTags);
// console.log(tagCollectionInputFormat.value );




// tagCollectionInputFormat.value= [];
// console.log(tagCollectionInputFormat.value);

// if (!props?.toChild?.formTags?.[1]) props.toChild.formTags[0].forEach(createTagInputGroup);
if (props?.toChild?.formTags) {
    tagCollectionInputFormat.value = [''];
    props.toChild.formTags.forEach(createTagInputGroup)
};


















// console.log(tagCollectionInputFormat.value);

// tagCollectionInputFormat.value = [];
// tagCollectionInputFormat.value[0] = tagCollectionInputFormat.value;



















    }
})

function createTagInputGroup(item, index1) {

item.forEach(createTagInputString);

function createTagInputString(item2, index2) {

    if (item2 != null) {
        let item2Trimmed = item2.toString().trim();

        // console.log(index2);
        // console.log(item2);
        // console.log(item2Trimmed);
        // console.log(tagCollectionInputFormat.value);

        switch (index2) {

            case 0:
                // console.log(item2Trimmed);
                // console.log(tagCollectionInputFormat.value);
                // console.log(item2);
                tagCollectionInputFormat.value[0] += '@'+item2Trimmed;
                // console.log(tagCollectionInputFormat.value);
                break;

            case 3:
                tagCollectionInputFormat.value[0] += '('+item2Trimmed+')';
                // console.log(tagCollectionInputFormat.value);
                break;

            default:
                if (item2Trimmed) tagCollectionInputFormat.value[0] += ':'+item2Trimmed;
                // console.log(tagCollectionInputFormat.value);
        }
    }
}
// prevent space at the end of the string
if (index1 !== props?.toChild?.formTags[0].length-1) tagCollectionInputFormat.value[0] += ' ';

}

</script>

