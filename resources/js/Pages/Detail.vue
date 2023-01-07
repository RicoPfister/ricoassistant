<template>

     <!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.basicData?.title }}</h1>
    <div class="text-gray-400 text-sm">Video Game |</div>
</div>

<!-- {{ typeof detailData?.activitytData }} -->

<!-- section statement -->
<div v-if="typeof detailData?.statementData !== 'undefined'">
    <pre>{{ detailData.statementData.statement[0].statement }}</pre>

    <!-- get tag list -->
    <div v-if="typeof detailData?.statementData.tag !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData.statementData.tag">

            <div class="flex fle-row">
                <div v-for="(item2, index2) in item">
                    <!-- {{ item2 }} -->
                    {{ index2 == 0 ? '@' + item[index2]['content'] : index2 < 3 ? ':' + item[index2]['content'] : '' }}
                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>

    <!-- get reference parent -->
    <div v-if="typeof detailData?.statementData.reference_parent !== 'undefined'" class="flex flex-row">
        {{ detailData?.statementData.reference_parent[1][0]['title'] }}
    </div>

</div>

<!-- section activity -->
<div v-if="typeof detailData?.activitytData?.[0] !== 'undefined'">
    123
</div>

<!-- section source -->
<div v-if="typeof detailData?.sourceData?.[0] !== 'undefined'">
    <!-- <img :src=""> -->
    <!-- {{ detailData.sourceData[0].path }} -->
    <img :src="'/storage/inventory/' + detailData.sourceData[0].path" />
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
