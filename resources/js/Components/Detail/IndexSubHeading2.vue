<template>

    <!-- heading loop-->
    <div v-for="(item, index2) in props.data[props.index][1][props.index1][1]" class="flex flex-col">

        <div class="flex flex-row">

            <!-- heading number -->
            <div class="justify-end w-[18px] h-[16px] flex items-center text-xs">{{ index + 1}}</div>
            <div class="h-[16px] w-[35px] flex items-center text-xs">{{ '.' + (props.index1 + 1) + '.' + (index2 + 1) }}</div>

            <!-- heading text -->
            <button @click.prevent=""
                class="h-[16px] flex items-center hover:text-lime-600s ml-2 text-xs hover:text-lime-600"
                type="button">{{ props.data[props.index][1][props.index1][1][index2][0]  }}
            </button>

        </div>
    </div>

    </template>

    <script setup>

    import { ref, onMounted, computed, watch } from 'vue';

    const props = defineProps(['data', 'index', 'index1']);

    let IndexSubHeadingOpen = ref([]);

    </script>
