<template>

    <!-- upload content box -->

<!-- hidden file list/preview -->
<div v-if="1" class="flex flex-col my-2">

<!-- source list -->
<!-- ------------------------------------------------------ -->

<div class="border-b-2 border-black font-bold">Minutes and Reference</div>

<div class="py-1">
    <!-- activity group -->
    <div v-for="(item, index) in props.detailData.activityTo">
        <!-- {{ item }} -->
        <div class="flex flex-row">
            <!-- index indicator -->
            <div class="truncate w-[60px] flex justify-between items-center"><span class="bg-black text-white px-1 mr-1 font-bold h-5 flex items-center">{{ parseInt(index)+1 }}</span><b>{{ item.activityTime }}</b></div>

            <div class="ml-1">
                <ReferenceParentsList :reference="props.detailData" :index="index"/>
            </div>
        </div>

        <!-- {{ props.detailData.reference_parents[index].title }} -->
    </div>
</div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

import ReferenceParentsList from './ReferenceParentsList.vue';

const props = defineProps(['detailData']);

</script>
