<template>

     <!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.basicData?.title }}</h1>
    <div class="text-gray-400 text-sm">Video Game |</div>
</div>

<!-- {{ typeof detailData?.activitytData }} -->

<!-- section statement -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++ -->
<div v-if="typeof detailData?.statementData !== 'undefined'">
    <pre>{{ detailData.statementData.statement[0].statement }}</pre>

    <!-- {{ detailData?.statementData.tag[0][0]  }} -->

    <!-- get tag list -->
    <div class="font-bold mt-2">Tags:</div>
    <div v-if="typeof detailData?.statementData.tag !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData.statementData.tag">

            <!-- {{ item }} -->

            <div class="flex fle-row">
                <div v-for="(item2, index2) in item">
                    <!-- {{  item2['content'] }} -->
                    {{ index2 == 0 ? '@' + item2['content'] : index2 < 4 ? ':' + item2['content'] : '' }}

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>

    <!-- get reference parents -->
    <div class="font-bold mt-2">Reference Parents:</div>
    <div v-if="typeof detailData?.statementData.reference_parents !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData?.statementData.reference_parents[1]">
            <b>{{ item['title'] }}</b>{{ (index !== detailData?.statementData.reference_parents[1].length-1  ? '>' : '') }}
        </div>
    </div>
    <div v-else class="">Main Entry</div>

    <!-- get reference children -->
    <div v-if="typeof detailData?.statementData.reference_children !== 'undefined'" class="flex flex-col">
        <div class="font-bold mt-2">Reference Children:</div>
        <div v-for="(item, index) in detailData?.statementData.reference_children" class="flex flex-row">
            {{ item[0]['ref_db_name'] + '&nbsp;' +  item[0]['title'] + '&nbsp;' + item[0]['ref_date'] }}
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['activityTime'] !== 'undefined'">{{  '&nbsp;' + item[0]['ref_id'][0]['activityTime'] +'min'}}</div>
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['path'] !== 'undefined'">{{ '&nbsp;' + 'File: ' + item[0]['ref_id'].length }}</div>

        </div>
    </div>

</div>

<!-- section activity -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div v-if="typeof detailData?.activitytData?.[0] !== 'undefined'">
    123
</div>

<!-- section source -->
<!-- +++++++++++++++++++++++++++++++++++++++++++ -->
<div v-if="typeof detailData?.sourceData?.[0] !== 'undefined'">



<!-- get tag list -->
<div class="font-bold">Tags:</div>
    <div v-if="typeof detailData?.sourceData.tag !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData.sourceData.tag">

            <!-- {{ item }} -->

            <div class="flex fle-row">
                <div v-for="(item2, index2) in item">
                    <!-- {{  item2['content'] }} -->
                    {{ index2 == 0 ? '@' + item2['content'] : index2 < 4 ? ':' + item2['content'] : '' }}

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>

    <!-- get reference parents -->
    <div v-if="typeof detailData?.sourceData?.reference_parents !== 'undefined'" class="flex flex-col">
        <div class="font-bold mt-2">Reference Parents:</div>
        <!-- {{ detailData?.sourceData.reference_parents['title'] }} -->
        <div class="flex flex-row">
            <div v-for="(item, index) in detailData?.sourceData.reference_parents">
                <b>{{ item['title'] }}</b>{{ (index !== detailData?.sourceData.reference_parents.length-1  ? '>' : '') }}
            </div>
        </div>

    </div>
    <div v-else class="">Main Entry</div>

    <!-- get reference children -->
    <div v-if="typeof detailData?.sourceData?.reference_children !== 'undefined'" class="flex flex-col">
        <div class="font-bold mt-2">Reference Children:</div>
        <div v-for="(item, index) in detailData?.sourceData.reference_children" class="flex flex-row">

            {{ item[0]['ref_db_name'] + '&nbsp;' +  item[0]['title'] + '&nbsp;' + item[0]['ref_date'] }}
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['activityTime'] !== 'undefined'">{{  '&nbsp;' + item[0]['ref_id'][0]['activityTime'] +'min'}}</div>
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['path'] !== 'undefined'">{{ '&nbsp;' + 'File: ' + item[0]['ref_id'].length }}</div>

        </div>
    </div>
    <!-- {{ detailData.sourceData[0].extension }} -->

    <div v-if="detailData.sourceData[0].extension == 'jpg' || detailData.sourceData[0].extension == 'png'">
        <div class="font-bold mt-2">Images:</div>
        <img :src="'/storage/inventory/' + detailData.sourceData[0].path" />
    </div>

    <div v-if="detailData.sourceData[0].extension == 'mp4'">
        <div class="font-bold mt-2">Videos:</div>
        <video width="320" height="240" controls>
            <source :src="'/storage/inventory/' + detailData.sourceData[0].path" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    </div>

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
