<template>

<div class="flex flex-col w-full">

    <div class="flex flex-row items-center h-[31px] w-full">

        <!-- add button -->
        <button @click.prevent="tagPopupOpenData" class="relative w-[36px] flex h-full items-center bg-gray-100 border-r border-gray-300 leading-none pl-1" type="button">
            <div class="absolute text-[10px] top-0 right-0 text-gray-500 pt-[0px] pr-[6px] flex justify-center w-2 h-full break-all items-center">0</div>
            <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-[18px] h-[18px]">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
            </svg>
        </button>

        <!-- open popup -->
        <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0 z-50">
            <TagPopup :fromController="props.fromController" :toChild="{'tagSelectionListString': tagCollectionInputFormat[0]}" @fromChild="fromChild"/>
        </div>

        <!-- tag input -->
        <div class="grow">
            <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent bg-stone-50 pl-2 h-7 leading-none text-sm text-gray-500 w-full" type="text" placeholder="Insert tags: @Category:Context:Content(Comment)" v-model="tagCollectionInputFormat[0]">
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
let emit = defineEmits(['dataForm', 'dataCommon', 'dataToParent', 'toChild']);

// let form = useForm({

// });

let tagPopupOpen = ref(0);
let tagCollectionInputIndex = ref(0);
let tagCollectionInputFormat = ref({});
let controllerDataArrived = ref(0);

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
    if (props.fromController.misc.parentId == props.toChild.parentId && props.fromController.misc.parentIndex == props.toChild.parentIndex) {
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

    // console.log(data.tagCollection);
    // console.log(TagFromStringToGroup.tagFromStringToGroup(data.tagCollection));

    if (props.fromController.misc.parentId == props.toChild.parentId && props.fromController.misc.parentIndex == props.toChild.parentIndex) {

        // console.log(data.tagCollection);
        // tagCollectionInputFormat.value = data.tagCollection;

        if (data.tagSelectionListString !== '') tagCollectionInputFormat.value[0] = data.tagSelectionListString;

        tagPopupOpen.value = 0;
    }
}

// function tagPopupOpenData(index) {

//     tagCollectionInputIndex.value = index;
//     tagPopupOpen.value = 1;
//     console.log(tagCollectionInputIndex.value);
// }

// request controller data
function tagPopupOpenData() {
    Inertia.post('tag', {'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex});
}

</script>

