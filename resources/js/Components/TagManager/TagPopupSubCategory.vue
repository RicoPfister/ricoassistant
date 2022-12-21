<template>

<!-- tag categories/content -->
<div v-for="(item, index) in props.toChild.tagCollection[1]" class="flex flex-col bg-white w-full h-5">
    <div :class="{'bg-blue-100': categorySubActive[index]}" class="h-[34px] border-b border-gray-400 w-full flex flex-row">
        <button @click.prevent="categorySubActive[index] = 1; fromChild(index)" class="px-2 border-r border-gray-400 h-full flex items-center w-full" type="button">

            <!-- tag context svg -->
            <div class="h-fit flex items-center">
                <svg width="8" height="5">
                    <rect width="2" height="3" style="fill:rgb(0,0,0)" />
                    <rect y="3" width="8" height="2" style="fill:rgb(0,0,0)" />
                    Sorry, your browser does not support inline SVG.
                </svg>
            </div>

            <!-- tag context title -->
            <div class="flex items-center ml-1">{{ item }}</div>
            <div v-if="categorySubActive[index]">
                <svg xmlns="http://www.w3.org/2000/svg" color="none" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
            </div>
        </button>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

let props = defineProps(['toChild']);
let emit = defineEmits(['fromChild']);

let categorySubActive = ref([]);

// emit data to TagPopupCategory.vue
function fromChild(index, check) {
    emit('fromChild', {'index': props.toChild.index, 'subIndex': index});
}

</script>

