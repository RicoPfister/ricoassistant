<template>

<div v-if="0" class="h-[calc(100%-35px)] flex items-center justify-center flex-col gap-y-5">
    <h1 class="font-bold">Welcome to the Tag Manager!</h1>
    <p>Here you can choose tags grouped in categories.</p>
    <p>Then you can value the tags and add an discription.</p>
    <p>Let's start by adding the first tag!</p>
</div>

<div class="h-auto flex flex-row bg-gray-100">
        <div class="px-1 flex items-center w-full border-b border-r border-gray-400 bg-gray-300">Tags related to entry:&nbsp;<span class="font-bold">{{ title }}</span></div>
    </div>

<div v-for="(item, index) in tagArray" class="flex flex-col">
    <div class="h-auto flex flex-row leading-none">
        <input class="px-1 flex items-center border-r border-b border-gray-400 w-[180px]" placeholder="Category" v-model="tagArray[index][0]">
        <input class="px-1 flex items-center border-r border-b border-gray-400 w-[140px]" placeholder="Content" v-model="tagArray[index][1]">
        <input class="px-1 flex items-center border-r border-b border-gray-400 w-[120px]" placeholder="Value" v-model="tagArray[index][2]">

        <div class="flex flex-row justify-between items-center border-r border-b border-gray-400 w-full grow h-6">
            <input class="grow pl-1 truncate h-full" placeholder="Details" v-model="tagArray[index][3]">

            <!-- edit menu button -->
            <div @mouseover="tagEditMenu[index] = 1" @mouseleave="tagEditMenu[index] = 0" class="relative border-l border-gray-400 h-full w-fit flex flex-row leading-none pr-1">

                <div class="flex items-center leading-none">
                <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-fit h-full hover:stroke-2 leading-none
                pl-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213
                    1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26
                    1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125
                    0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55
                    0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125
                    1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0
                    010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072
                    1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>

            <!-- edit menu popup -->
            <div v-if="tagEditMenu[index]" class="absolute top-0 right-0 flex flex-row h-full border-l border-gray-400 px-1 bg-stone-100">

                <!-- swap up -->
                <button @click.prevent="swapdownTagRow(index)" class="w-fit flex items-center leading-none h-full" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-fit h-full hover:stroke-2
                    leading-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>

                <!-- swap down -->
                <button @click.prevent="swapupTagRow(index)" class="w-fit flex items-center leading-none h-full" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-fit h-full hover:stroke-2
                    leading-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                </button>

                <!-- duplicate button -->
                <button @click.prevent="duplicateTagRow(index)" class="w-fit flex items-center leading-none h-full" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-fit h-full
                    hover:stroke-2 leading-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

                <!-- remove button -->
                <button @click.prevent="removeTagFromList(index)" class="w-fit flex items-center leading-none h-full" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-fit h-full hover:stroke-2
                    leading-none">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";
import contentBox from "./TagContent.vue";
import * as TagFromStringToGroup from "../../Scripts/tagFromStringToGroup.js"

let props = defineProps(['toChild']);
let emit = defineEmits(['fromChild']);

let tagArray = ref([]);
let title = ref('');
let tagEditMenu = ref([]);

// let tagDuplication = ref([]);

// basic title response
watch(() => props.toChild.tagSelection, _.debounce( (curr, prev) => {

    console.log(props.toChild.tagSelection);
    // console.log(props.toChild);

    // console.log(TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelection));
    // tagArray.value.push(TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelection));
    if (typeof props.toChild.tagSelection !== 'undefined') tagArray.value.push(props.toChild.tagSelection);

}, 500));

watch(() => props.toChild.tagSelectionListString, _.debounce( (curr, prev) => {

    // console.log(props.toChild.tagSelectionList);
    // tagArray.value = TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelectionList);
    // tagArray.value = props.toChild.tagSelectionList;

    // if (props.toChild.tagSelectionList[0].length > 0) {
    //     console.log('ok');
    //     // console.log(TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagInputList));
    //     tagArray.value = TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelectionList);
    // }
    //    console.log('ok');
    if (typeof props.toChild.tagSelectionListString !== 'undefined') {
        // console.log('ok');
        // console.log(TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagInputList));
        tagArray.value = TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelectionListString);
    }

}, 500));

function removeTagFromList(index) {
    // tagArray.value.push(props.dataParent);
    tagArray.value.splice(index, 1);
}

function duplicateTagRow(index) {
    // tagDuplication = tagArray.value[index];
    // console.log(tagDuplication);
    console.log(tagArray.value[index]);
    tagArray.value.splice(index, 0, []);
    tagArray.value[index][0] = tagArray.value[index+1][0];
    tagArray.value[index][1] = tagArray.value[index+1][1];
    tagArray.value[index][2] = tagArray.value[index+1][2];
    tagArray.value[index][3] = tagArray.value[index+1][3];
    // tagArray.value[index] = tagDuplication;
}

function swapupTagRow(index) {
    // console.log(index);
    if (index > 0) tagArray.value.splice(index-1, 2, tagArray.value[index], tagArray.value[index-1]);
}

function swapdownTagRow(index) {
    // console.log('ok');
    if (index+1 < tagArray.value.length) tagArray.value.splice(index, 2, tagArray.value[index+1], tagArray.value[index]);
}

// get child data
onMounted(() => {

    // listen to and set Basic.vue title if available
    if (props.toChild.basicTitle) {
        title.value = props.toChild.basicTitle;
        // alternate title text
    } else title.value = '';
    // console.log(props.toChild);

    // check if tag string can be convertet to tag select
    // console.log(TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelectionList));
    // console.log(props.toChild.tagSelectionListString);

    if (props.toChild.tagSelectionListString.length > 0) {
        // console.log('ok');
        // console.log(TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagInputList));
        tagArray.value = TagFromStringToGroup.tagFromStringToGroup(props.toChild.tagSelectionListString);
    }
})

// listen to tag collection changes and emit to tagPopup.vue
watch(() => tagArray.value, (curr, prev) => {
    console.log(tagArray.value);
    emit('fromChild', {'tagSelectionListGroup': tagArray.value});
}, {deep: true}, 500);

</script>
