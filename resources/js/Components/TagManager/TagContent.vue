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

let props = defineProps(['dataParent', 'dataForm', 'fromParentTagString']);
let emit = defineEmits(['dataChild']);

let tagArray = ref([]);
let title = ref('');

// basic title response
watch(() => props.dataParent, _.debounce( (curr, prev) => {

    // console.log(props.dataParent);

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
    if (props.fromParentTagString) {
        // tagArray.value = props.dataTagContent[0].split(0);
        // console.log(props.fromParentTagString);

        let tagCollectionSplitInGroup = props.fromParentTagString.split(/[\s@]/);
        let tagCollectionSplitInGroupFilter = tagCollectionSplitInGroup.filter(element => element);

        let tagGroupSplitComment = [];
        let tagGroupSplitFilter = [];
        let tagGroupSplitmain = [];
        let tagGroupSplitmainFilter = [];

        tagCollectionSplitInGroupFilter.forEach(tagCollectionEdit);

        function tagCollectionEdit(item, index) {

            // console.log(tagCollectionSplitInGroupFilter.length);
            // console.log(index);

            //? set nested value
            if (tagCollectionSplitInGroupFilter.length > 0) tagArray.value[index] = [];

            // console.log(tagCollectionSplitInGroupFilter);
            // console.log(item);

            // split comment
            tagGroupSplitComment[index] = item.split(/[(%)]/);
            tagGroupSplitFilter[index] = tagGroupSplitComment[index].filter(element => element != ' ');

            // console.log(tagGroupSplitFilter);
            // console.log(tagGroupSplitFilter[0]);

            tagGroupSplitmain[index] = tagGroupSplitFilter[index][0].split(/[:]/);
            tagGroupSplitmainFilter[index] = tagGroupSplitmain[index].filter(element => element != ' ');

            // console.log(tagGroupSplitmainFilter);

            // reset tag array
            // if (tagGroupSplitmainFilter[0][0]) tagArray.value[0] = [];

            // console.log(tagGroupSplitmainFilter);
            // console.log(tagArray);

            // add content tags
            for (let i = 0; i < 3; i++) {
                if (tagGroupSplitmainFilter[index][i]) {
                    // console.log(index, i);
                    tagArray.value[index].push(tagGroupSplitmainFilter[index][i]);
                    // console.log(tagArray.value);
                } else tagArray.value[index].push('');
            }

            // console.log(tagArray);

            // add comment tag
            if (tagGroupSplitmainFilter[index][1]) {
               tagArray.value[index].push(tagGroupSplitFilter[index][1]);
            } else tagArray.value[index].push('');
        }

        // console.log(tagGroupSplitmainFilter);
    }
})

// listen to tag collection and emit to TagPopUp.vue
watch(() => tagArray.value, (curr, prev) => {
    // console.log('ok');
    emit('dataChild', {'tagCollection': tagArray.value});
}, {deep: true}, 500);

</script>
