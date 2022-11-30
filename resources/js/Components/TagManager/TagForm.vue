<template>

    <div>
        <div class="flex flex-col">

            <button class="flex flex-row justify-between items-center" type="button">

                <label class="" aria-label="Statement Input" for="statement">Tags:</label>

                <!-- <MenuEntry /> -->

            </button>

            <div class="flex flex-row items-center h-[42px] border border-black">

                <!-- add button -->
                <button @click.prevent="tagPopupOpenData" class="w-[42px] flex justify-center h-full items-center bg-gray-100 border-r border-gray-300" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-fit p-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

                <!-- open popup -->
                <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0">
                    <TagPopup :data-common="props.dataCommon" @tag-popup-open="tagPopupOpen = 0" :data-parent="tagCollectionInputFormat" :data-form="props.dataForm" @data-child="dataChild"/>
                </div>

                <!-- tag input -->
                <div class="grow">
                    <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent w-full" type="text" placeholder="" v-model="tagCollectionInputFormat">
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

let props = defineProps(['dataForm', 'dataCommon']);
// let emit = defineEmits(['dataForm']);

let tagPopupOpen = ref(0);
let tagCollectionInputFormat = ref('');

// onMounted(() => {
//     console.log(props.dataForm.basicTitle);

//     if (typeof props.dataParent.title != 'undefined') {
//         // console.log(props.dataForm.statement);
//         title = props.dataParent.title;
//     } else title = 'No title found';
// })

function dataChild(data) {

    if (data.tagCollection) {

        // console.log(data.tagCollection);

        tagCollectionInputFormat.value = '';

        data.tagCollection.forEach(createTagInputGroup);

        function createTagInputGroup(item, index1) {

            // console.log(item.length-1);

            item.forEach(createTagInputString);

            // tagCollectionInputFormat.value[0] = [];

            function createTagInputString(item2, index2) {

                // console.log(item2);

                let item2Trimmed = item2.toString().trim();

                switch (index2) {
                    case 0:
                        tagCollectionInputFormat.value += '@'+item2Trimmed;
                        break;

                    case 3:
                        tagCollectionInputFormat.value += '('+item2Trimmed+')';
                        break;

                    default:
                        if (item2Trimmed) tagCollectionInputFormat.value += ':'+item2Trimmed;
                }
            }
            // no space at the end when reaching last entry
            // console.log(index1, data.tagCollection.length);
            if (index1 != data.tagCollection.length-1) tagCollectionInputFormat.value += ' ';
        }

        // tagCollectionInputFormat.value = data.tagCollection;
        tagPopupOpen.value = 0;
    }
}

function tagPopupOpenData() {
    tagPopupOpen.value = 1;
}

</script>

