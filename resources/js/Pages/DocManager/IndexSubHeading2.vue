<template>

    <!-- heading loop-->
    <div
        v-for="(item, index2) in props.data[props.index+1][props.index1][1]" class="flex flex-col mt-[2px]"
        :style="{ 'margin-top': index2 == 0 ? '3px' : '', 'margin-bottom': index2+1 == props?.data[props.index+1][props.index1][1]?.length ? 'px' : ''}"
    >

        <!-- {{ item[0] }} -->

        <div class="flex flex-row">

            <div v-if="IndexSubHeadingOpen[index1] == 0 | IndexSubHeadingOpen[index1] == undefined" class="invisible">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </div>
            <div v-else class="invisible">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </div>

            <!-- heading number -->
            <div class="justify-end w-[15px] h-[16px] flex items-center">{{ index + 1}}</div>
            <div class="h-[16px] w-[35px] flex items-center">{{ '.' + (props.index1 + 1) + '.' + (index2 + 1) }}</div>

            <!-- heading text -->
            <button
                @click.prevent="$emit('fromChild', {'jumpToChapter': (props.index+1)+'.'+(props.index1+1)+'.'+(index2+1)})"
                class="h-[16px] flex items-center hover:text-lime-600s ml-1 hover:text-lime-600"
                type="button">{{ item[1] }}
            </button>

        </div>
    </div>

    </template>

    <script setup>

    import { ref, onMounted, computed, watch } from 'vue';

    const props = defineProps(['data', 'index', 'index1']);
    let emit = defineEmits(['fromChild']);

    let IndexSubHeadingOpen = ref([]);

    </script>
