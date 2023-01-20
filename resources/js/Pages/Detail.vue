<template>

<!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.basicData?.title }}</h1>
    <div class="text-gray-400 text-sm">Video Game |</div>
</div>

<!-- *****section statement***** -->
<div  v-if="typeof detailData?.statementData !== 'undefined'">
    <!-- textbox -->
    <pre>{{ detailData?.statementData?.statement[0]?.statement }}</pre>

    <!-- Lists -->
    <TagList :tag="props?.detail?.statementData?.tag"/>
    <ReferenceList :reference="detailData.statementData"/>
</div>

<!-- *****section source***** -->
<div v-if="typeof detailData?.sourceData !== 'undefined'">

    <!-- source title -->
    <div class="font-bold mt-2 bg-black text-white w-full">Source</div>

    <!-- media list -->
    <SourceMediaList :detailData="detailData" />

    <!-- Lists -->
    <TagList :tag="props.detail.sourceData.tag" />
    <ReferenceList :reference="props.detail.sourceData" />
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from '../Components/Detail/IndexSubHeading1.vue';
import SourceMediaList from '../Components/Detail/Source/MediaList.vue';
import TagList from '../Components/Detail/TagList.vue';
import ReferenceList from '../Components/Detail/ReferenceList.vue';

const props = defineProps(['detail']);

let detailData = ref(['']);



onMounted(() => {
    detailData.value = props?.detail;
});

watch(() => props.detail, _.debounce( (curr, prev) => {
    detailData.value = props?.detail;
    }, 500)
);

</script>
