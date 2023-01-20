<template>

    <div>
        <div class="flex flex-col">

            <button class="flex flex-row justify-between items-center" type="button">

                <label v-if="titleOpen" class="" aria-label="Statement Input" for="statement">Tags:</label>

                <!-- <MenuEntry /> -->

            </button>

            <div :class="({'border-t': titleOpen})" class="flex flex-row items-center h-[42px] border-l border-b border-r border-black">

                <!-- add button -->
                <button @click.prevent="tagPopupOpenData" class="w-[42px] flex justify-center h-full items-center bg-gray-100 border-r border-gray-300" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-auto h-fit p-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

                <!-- open popup -->
                <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0 z-50">
                    <TagPopup :data-common="props.dataCommon" @tag-popup-open="tagPopupOpen = 0" :data-parent="tagCollectionInputFormat" :data-form="props.dataForm"/>
                </div>

                <!-- tag input -->
                <div class="grow">
                    <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent w-full bg-stone-50" type="text" placeholder="Insert tag codes: @Category:Context:Content(Comment)" v-model="tagCollectionInputFormat">
                </div>

            </div>

        </div>
    </div>

    </template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

// import MenuEntry from "../Create/MenuEntry.vue";
import TagPopup from "../TagManager/TagPopup.vue";

let props = defineProps(['dataForm', 'dataCommon', 'emitToParent', 'fromParent', 'fromChild']);
let emit = defineEmits(['dataForm', 'dataCommon', 'dataToParent']);

let tagPopupOpen = ref(0);
let tagCollectionInputFormat = ref('');
let titleOpen = ref(1);
let controllerDataArrived = ref(0);

// onMounted(() => {
//     console.log(props.dataForm.basicTitle);

//     if (typeof props.dataParent.title != 'undefined') {
//         // console.log(props.dataForm.statement);
//         title = props.dataParent.title;
//     } else title = 'No title found';
// })

function emitToParent() {
    // console.log('test');
    if(data.tagCollectionString) {
        tagCollectionInputFormat.value = data;
        tagPopupOpen.value = 0;
    }
}

// request controller data
function tagPopupOpenData() {
    Inertia.post('tag');
}

onMounted(() => {
    titleOpen.value = !titleOpen.value;
});

// listen to controller feedback and opens tag popup
watch(() => props.dataCommon, (curr, prev) => {
    tagPopupOpen.value = 1;
}, {deep: true}, 500);

</script>

