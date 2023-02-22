<template>

<!-- title -->
<div class="flex flex-col mb-3">
    <div class="flex flex-row justify-between">
        <h1 class="text-2xl border-b border-black grow flex justify-center">{{ detailData.basicData?.title }}</h1>
        <div class="w-6 border-b border-black "></div>
    </div>
    <div class="flex flex-row justify-between text-gray-400 text-sm">
        <div class="flex justify-center flex-row grow">
            <div class="">{{ detailData.basicData?.medium_name }}</div>
            <div>&nbsp;|&nbsp;</div>
            <div class="">{{ detailData.basicData?.ref_date }}</div>
            <div>&nbsp;| By:&nbsp;</div>
            <div class="">{{ detailData.basicData?.user_name }}</div>
        </div>

        <button @click.prevent="edit" type="button" class="w-6 flex justify-end">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
            </svg>
        </button>
    </div>
</div>

<!-- *****section statement***** -->
<div v-if="typeof detailData?.statementData !== 'undefined'" class="">
    <!-- textbox -->
    <pre>{{ detailData?.statementData?.statement?.statement }}</pre>

    <!-- Lists -->
    <TagList v-if="props.detail.statementData.tag" :tag="props.detail.statementData.tag"/>
    <ReferenceParentsList :reference="detailData.statementData"/>
    <ReferenceChildrenList :reference="detailData.statementData"/>
</div>

<!-- *****section activity***** -->
<div v-if="typeof detailData?.activityData !== 'undefined'">

    <!-- source title -->
    <div class="font-bold mt-2 bg-black text-white w-full">Activity</div>

    <!-- time list -->
    <ActivityList :detailData="detailData.activityData" />

    <!-- Lists -->
    <TagList v-if="props.detail.activityData.tag.length > 0" :tag="props.detail.activityData.tag" />
    <ReferenceChildrenList :reference="detailData.activityData"/>
</div>

<!-- *****section source***** -->
<div v-if="typeof detailData?.sourceData !== 'undefined'">

    <!-- source title -->
    <div class="font-bold mt-2 bg-black text-white w-full">Source</div>

    <!-- media list -->
    <SourceMediaList :detailData="detailData" />

    <!-- Lists -->
    <TagList v-if="props.detail.sourceData.tag" :tag="props.detail.sourceData.tag" />
    <ReferenceParentsList v-if="props?.detail?.sourceData && !props?.detail?.statementData" :reference="detailData.sourceData"/>
    <ReferenceChildrenList :reference="detailData.sourceData"/>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import IndexSubHeading1 from '../Components/Detail/IndexSubHeading1.vue';
import SourceMediaList from '../Components/Detail/Source/MediaList.vue';
import ReferenceChildrenList from '../Components/Detail/ReferenceChildrenList.vue';
import ReferenceParentsList from '../Components/Detail/ReferenceParentsList.vue';
import TagList from '../Components/Detail/TagList.vue';
import ActivityList from '../Components/Detail/ActivityList.vue';

const props = defineProps(['detail']);

let detailData = ref({});

onMounted(() => {
    detailData.value = props?.detail;
    // console.log(detailData.value);
});

watch(() => props?.detail, _.debounce( (curr, prev) => {
    detailData.value = props.detail;
    // console.log(detailData.value);
    }, 500)
);

function edit() {
    // send form with adjusted reference (only direct parent reference without the tree path)

    if (typeof detailData?.value?.activityData !== 'undefined') {

        // console.log(detailData.value.activityData.reference[0]);
        let refCollection = {};
        refCollection['activityData'] = {};
        refCollection['activityData']['reference_parents'] = [];

        detailData.value.activityData.reference_parents.forEach((item, index) => convertFormReference(item, index));

            function convertFormReference(item, index) {

                // console.log(item);

                refCollection['activityData']['reference_parents'].push(detailData.value.activityData.reference_parents[index][0]);
            }
    }

    Inertia.post('edit', detailData.value);
}

</script>
