<template>

<div class="flex flex-col w-full h-full">

    <div class="flex flex-row items-center h-[30px]">

        <!-- add button -->
        <button
            @click.prevent="tagPopupOpenData"
            @mouseenter="hoverPopUp(1, props.toChild.parentIndex)"
            @mouseleave="hoverPopUp(0, props.toChild.parentIndex)"
            :class="{'border-l': !tagInputShow, 'border-r': tagInputShow, 'bg-red-300': props?.toChild?.validationError}"
            class="relative w-[37px] flex h-full items-center bg-gray-200 border-gray-300 leading-none pl-1"
            type="button"
        >
            <!-- item counter -->
            <div :class="{'text-black': tagCollectionInputFormat?.[0]}" class="absolute text-[10px] top-0 right-0 text-gray-500 pt-[0px] pr-[6px] flex justify-center w-2 h-full break-all items-center">{{ !tagCollectionInputFormat?.[0] ? 0 : tagCollectionInputFormat?.[0]?.match(/@/g).length < 100 ? tagCollectionInputFormat?.[0]?.match(/@/g).length : 99 }}</div>

            <!-- tag icon -->
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" :color="!tagCollectionInputFormat?.[0]  ? 'gray' : 'green'" :stroke-width="!tagCollectionInputFormat?.[0] ? 1.5 : 2" stroke="currentColor" class="w-[18px] h-fit">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699
                1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="raound" d="M6 6h.008v.008H6V6z" />
            </svg>

            <div @mouseleave="hoverPopUp(0, props.toChild.parentIndex)" v-if="tagContentBox == 1 && tagCollectionInputFormat[0] && tagInputShow == 0" class="absolute p-1 right-9 text-sm border-2 border-black w-[400px] break-all bg-blue-50 z-50 h-[50px] overflow-y-scroll flex justify-center">{{ tagCollectionInputFormat[0] }} </div>
        </button>

        <!-- open popup -->
        <div
            v-if="tagPopupOpen"
            class="absolute h-full w-full top-0 left-0 z-50"
        >
            <TagPopup
                :fromController = "props.fromController2"
                :toChild = "{'tagSelectionListString': tagCollectionInputFormat[0], 'basicTitle': props.toChild.basicTitle, 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex}"
                @fromChild = "fromChild"
            />
        </div>

        <!-- tag input -->
        <div v-if="tagInputShow" class="grow">
            <input
                :class="{'bg-red-200': props?.toChild?.validationError}"
                class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent pl-2 h-7
                leading-none text-sm text-gray-500 w-full"
                type="text"
                placeholder="Insert tags: @Category:Context:Value(Detail)"
                v-model="tagCollectionInputFormat[0]"
            >
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

let props = defineProps(['dataForm', 'dataCommon', 'emitToParent', 'fromParent', 'fromChild', 'toChild', 'fromController', 'fromController2']);
let emit = defineEmits(['dataForm', 'dataCommon', 'dataToParent', 'toChild', 'fromChild']);

// let form = useForm({

// });

let tagPopupOpen = ref(0);
let tagCollectionInputIndex = ref(0);
let tagCollectionInputFormat = ref([]);
let tagCollectionInputFormatNew = ref([]);
let tagCollectionGroupFormat = ref([]);
let controllerDataArrived = ref(0);
let fromController = ref('');
let tagInputShow = ref(1);

let tagContentBox = ref(0);
let tagContentBoxTimeOut = '';

let tagCheck = 0;
// let tagContentBoxTimeOut = ref();

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
watch(() => props.fromController2, (curr, prev) => {
    if (props.fromController2?.misc?.parentId == props.toChild?.parentId && props.fromController2.misc?.parentIndex == props.toChild?.parentIndex) {
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

    console.log(data);
    // console.log(data.tagSelectionListString);
    // console.log(TagFromStringToGroup.tagFromStringToGroup(data.tagCollection));

    if (data.tagSelectionListString == '' && data.tagSelectionListString != 'cancel') {
        // console.log('empty');

        tagCollectionInputFormat.value[0] = "";
        tagPopupOpen.value = 0;
    }

    else if (typeof data.tagSelectionListString !== 'undefined' && data.tagSelectionListString != 'cancel') {

        // console.log(data.tagSelectionListString != '');
        // console.log(tagCollectionInputFormat.value[0]);

        if (fromController.value.misc.parentId == props.toChild?.parentId && fromController.value.misc.parentIndex == props.toChild.parentIndex) {

            console.log('ok');
            // console.log(data.tagCollection);
            // tagCollectionInputFormat.value = data.tagCollection;

            // if (data.tagSelectionListString != '') tagCollectionInputFormat.value[0] = data.tagSelectionListString;
            // if (data.tagSelectionListGroup != '') tagCollectionGroupFormat.value[0] = data.tagSelectionListGroup;
            if (data.tagSelectionListString != '') tagCollectionInputFormat.value[0] = data.tagSelectionListString;
            if (data.tagSelectionListGroup != '') tagCollectionGroupFormat.value[0] = data.tagSelectionListGroup;

            console.log(tagCollectionInputFormat.value[0]);

            tagPopupOpen.value = 0;
        }
    }

    else tagPopupOpen.value = 0;

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
    emit('fromChild', {'tagList': tagCollectionGroupFormat.value[0], 'tagString':tagCollectionInputFormat.value[0], 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex, 'component': 'tag'});
}, {deep: true}, 500);

// after split group to string send it back to parent as groups
watch(() => tagCollectionInputFormat.value[0], (curr, prev) => {

    // console.log(tagCollectionInputFormat.value);

    // if (typeof tagCollectionInputFormat.value[0] != 'undefined' && tagCollectionInputFormat.value[0] != '') {
        // console.log(tagCollectionInputFormat.value[0]);
        if (tagCheck == 1) {
            emit('fromChild', {'tagList': TagFromStringToGroup.tagFromStringToGroup(tagCollectionInputFormat.value[0]), 'tagString': tagCollectionInputFormat.value[0], 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex, 'component': 'tag'});
            tagCheck == 0;
        }

    // }
}, {deep: true}, 500);

// listen to fromController and save it in fromController
watch(() => props.fromController2, (curr, prev) => {
    // console.log('ok');
    // console.log(props?.fromController);
    if (props?.fromController2) {
        // console.log('ok');
        fromController.value = props.fromController2};
}, {deep: true}, 500);

watch(() => props?.toChild?.formTags, (curr, prev) => {

    console.log(props?.toChild?.formTags);

    if (props?.toChild?.formTags != undefined && props?.toChild?.formTags != '' && props?.toChild?.formTags?.length > 0) {

        console.log(props?.toChild?.formTags, tagCollectionInputFormat.value, tagCollectionInputFormat.value.length);

        if (props?.toChild?.formTags) {

            console.log('ok');

            // commented out because of errors
            tagCollectionInputFormatNew.value = [''];

            if (typeof props.toChild.formTags != 'string') {

                console.log('ok');
                props.toChild.formTags.forEach(createTagInputGroup)
            }
        }

        // else if (props?.toChild?.parentId == 4 && props?.toChild?.formTags?.length > 0) {

        //     console.log('ok');
        //     props.toChild.formTags.forEach(createTagInputGroup);
        // }

        else if (props?.toChild?.parentId == 3) {

            tagCollectionInputFormat.value[0] = props?.toChild?.formTags;
        }

        // tagCollectionInputFormat.value[0] = '';
    }

    else {
        console.log(props?.toChild?.formTags);

        tagCollectionInputFormat.value[0] = '';
    }

    // else {
    //     console.log('ok');
    //     tagCollectionInputFormat.value = '';
    // }

}, {deep: true});

onMounted(() => {

    // console.log('ok');

    if (props?.fromController) {
        fromController.value = props.fromController2;
    };

    if (typeof props.toChild?.tagInputShow !== 'undefined') {
        tagInputShow.value = props.toChild.tagInputShow;
    }

    // if (props?.toChild?.formTags) {

    //     if (props?.toChild?.formTags) {

    //         tagCollectionInputFormat.value = [''];

    //         if (typeof props.toChild.formTags != 'string') props.toChild.formTags.forEach(createTagInputGroup)
    //         if (typeof props.toChild.formTags == 'string') tagCollectionInputFormat.value[0] = props.toChild.formTags;
    //     };
    // }

    // if (props?.toChild?.formTags?.length > 0) {
    //     console.log('ok');
    //     tagCollectionGroupFormat.value = props.toChild.formTags;
    // }
})

function createTagInputGroup(item, index1) {

    // console.log(index1);
    // console.log(item);

    item.forEach(createTagInputString);

    function createTagInputString(item2, index2) {

        // console.log(index2);
        // console.log(item2);
        // console.log(tagCollectionInputFormat.value);

        if (item2 != null) {
            let item2Trimmed = item2.toString().trim();

            // console.log(index2);
            // console.log(item2);
            // console.log(item2Trimmed);

            switch (index2) {

                case 0:
                    // console.log(item2Trimmed);
                    // console.log(tagCollectionInputFormat.value);
                    // console.log(item2);
                    tagCollectionInputFormatNew.value[0] += '@'+item2Trimmed;
                    // console.log(tagCollectionInputFormat.value);
                    break;

                case 3:
                tagCollectionInputFormatNew.value[0] += '('+item2Trimmed+')';
                    // console.log(tagCollectionInputFormat.value);
                    break;

                default:
                    // console.log('ok');
                    if (item2Trimmed) tagCollectionInputFormatNew.value[0] += ':'+item2Trimmed;
                    // console.log(tagCollectionInputFormat.value);
            }
        }
    }
    // prevent space at the end of the string
    // console.log(props?.toChild?.formTags.length);
    if (index1 !== props?.toChild?.formTags.length-1) tagCollectionInputFormatNew.value[0] += ' ';
    console.log(tagCollectionInputFormat.value == tagCollectionInputFormatNew.value);
    if (tagCollectionInputFormat.value != tagCollectionInputFormatNew.value) tagCollectionInputFormat.value = tagCollectionInputFormatNew.value;
}

// console.log(tagCollectionInputFormat.value);

function hoverPopUp(status, index) {
    // console.log(status, index);

    if (status == 1) {
        tagContentBoxTimeOut = setTimeout(function() {
            tagContentBox.value = status;
        }, 1000);
    }

    else if (status == 0) {
        clearTimeout(tagContentBoxTimeOut);
        tagContentBox.value = status;
    }
    // tagContentBox.value = status;
}

</script>

