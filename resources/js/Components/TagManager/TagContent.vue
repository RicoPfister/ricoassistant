<template>

<div v-if="0" class="h-[calc(100%-35px)] flex items-center justify-center flex-col gap-y-5">
    <h1 class="font-bold">Welcome to the Tag Manager!</h1>
    <p>Here you can choose tags grouped in categories.</p>
    <p>Then you can value the tags and add an discription.</p>
    <p>Let's start by adding the first tag!</p>
</div>

<div class="h-auto flex flex-row bg-gray-100">
        <div class="px-1 flex items-center w-full border-b border-r border-gray-400 bg-gray-300">Tags for Entry:&nbsp;<span>{{ title }}</span></div>
    </div>

<div v-for="(item, index) in tagArray" class="flex flex-col">
    <div class="h-auto flex flex-row leading-none">
        <input class="px-1 flex items-center border-r border-b border-gray-400 w-[180px]" placeholder="Category" v-model="tagArray[index][0]">
        <input class="px-1 flex items-center border-r border-b border-gray-400 w-[140px]" placeholder="Content" v-model="tagArray[index][1]">
        <input class="px-1 flex items-center border-r border-b border-gray-400 w-[120px]" placeholder="Value" v-model="tagArray[index][2]">

        <div class="flex flex-row justify-between pr-1 items-center border-r border-b border-gray-400 w-full grow">
            <input class="grow pl-3 truncate" placeholder="Comment" v-model="tagArray[index][3]">

            <!-- remove button -->
            <button @click="removeTagFromList(index)" class="" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";
import contentBox from "./TagContent.vue";

let props = defineProps(['dataParent', 'dataForm', 'dataTagContent']);
let emit = defineEmits(['dataChild']);

let tagArray = ref([]);
let title = ref('');

// basic title response
watch(() => props.dataParent, _.debounce( (curr, prev) => {

    tagArray.value.push(props.dataParent);
    // console.log(tagArray.value);

}, 500));

function removeTagFromList(index) {
    tagArray.value.splice(index, 1);
}

// get child data
onMounted(() => {
    // console.log(props.dataForm.basicTitle);

    if (props.dataForm.basicTitle) {
        // console.log(props.dataForm.statement);
        title.value = props.dataForm.basicTitle;
    } else title.value = '- (No title set)';

    // check if tag content is available
    if (props.dataTagContent) {
        // tagArray.value = props.dataTagContent[0].split(0);
        // console.log(props.dataTagContent);
        let tagCollectionSplitMain= props.dataTagContent.split(/[@]/);
        let tagCollectionSplitFilter = tagCollectionSplitMain.filter(element => element);

        let tagGroupSplitComment = tagCollectionSplitFilter[0].split(/[(%)]/);
        let tagGroupSplitFilter = tagGroupSplitComment.filter(element => element != ' ');

        let tagGroupSplitmain = tagGroupSplitFilter[0].split(/[:]/);
        let tagGroupSplitmainFilter = tagGroupSplitmain.filter(element => element != ' ');

        if (tagGroupSplitmainFilter[0]) tagArray.value[0] = [];

        for (let i = 0; i < 3; i++) {

            if (tagGroupSplitmainFilter[i]) {
                tagArray.value[0][i] = [tagGroupSplitmainFilter[i]];
            } else tagArray.value[0].push('');
        }

        if (tagGroupSplitmainFilter[1]) tagArray.value[0].push(tagGroupSplitFilter[1]);

        // console.log(tagGroupSplitmainFilter);

    }
})

// listen to tag collection and emit to TagPopUp.vue
watch(() => tagArray.value, (curr, prev) => {
    // console.log('ok');
    emit('dataChild', {'tagCollection': tagArray.value});
}, {deep: true}, 500);

</script>
