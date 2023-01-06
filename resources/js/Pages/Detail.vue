<template>

     <!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.basicData?.title }}</h1>
    <div class="text-gray-400 text-sm">Video Game |</div>
</div>

<!-- {{ typeof detailData?.activitytData }} -->

<div v-if="typeof detailData?.statementData?.[0] !== 'undefined'">
    {{ detailData.statementData[0].statement }}
</div>

<div v-if="typeof detailData?.activitytData?.[0] !== 'undefined'">
    123
</div>

<div v-if="typeof detailData?.sourceData?.[0] !== 'undefined'">
    456
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from '../Components/Detail/IndexSubHeading1.vue'

const props = defineProps(['detail']);

let detailData = ref(['']);

let IndexSubHeadingOpen = ref([]);
let indexMenuOpen = ref(0);
let indexMenuOpenSwitcher = ref('open');
let IndexShowOpen = ref(1);
let indexLink = ref([0]);

onMounted(() => {
    detailData.value = props?.detail;
});

watch(() => props.detail, _.debounce( (curr, prev) => {
    detailData.value = props.detail;
}, 500)
);

</script>
