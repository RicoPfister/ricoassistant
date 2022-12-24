<template>

<!-- container -->
<div class="bg-white h-full w-full flex flex-col">

    <!-- ??? -->
    <div class="relative border-r border-gray-400 h-full w-full">

        <!-- header -->
        <div class="flex flex-row border-b border-gray-400 justify-between">

            <div class="px-2 flex flex-row items-center justify-left border-r border-gray-400 grow">

                <div class="text-xl font-bold flex ml-1">New Entry Manager</div>

                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="blue" class="w-5 h-5 ml-1">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </div>

            </div>

            <div class="flex flex-row ">
                <button :disabled="Object.keys(componentSelected).length == 0" @click="emitData" class="px-2 disabled:opacity-25 enabled:bg-green-200 h-[34px] flex items-center enabled:hover:bg-green-300" type="button">
                    <div class="flex flex-row items-center">
                        <div>
                            <!-- continue icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>Continue</div>
                    </div>
                </button>
            </div>
        </div>

        <div class="flex justify-center mt-5 mb-10">
            <div class="flex flex-col gap-y-3">
                <div class="font-bold ml-4">Choose at least one subject and continue:</div>
                <div class="flex flex-row items-center" v-for="(item, index) in FormSectionIcons.FormSections" >

                    <!-- checked icon -->
                    <div class="w-4">
                        <svg v-if="componentSelected[index]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>

                    <!-- form button -->
                    <button @click.prevent="componentSelectedEdit(index)" :class="item[4], componentSelected[index] ? item[3] : ''" class="bg-gray-100 border p-1 ml-1 px-2 rounded-xl w-fit flex flew-row items-center" type="button">

                        <!-- subject icon -->
                        <svg :class="item[2]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="item[5]" />
                        </svg>
                        <div><b>{{ item[0] }}</b> {{ item[1] }}</div>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import * as FormSectionIcons from "../../Scripts/SVGIcons.js"

const props = defineProps(['dataParent', 'dataForm']);
let emit = defineEmits(['dataChild']);

function componentSelectedEdit(index) {
    if (componentSelected.value[index] == 1) delete componentSelected.value[index];
    else componentSelected.value[index] = 1;
}

function emitData() {
    emit('dataChild', {'componentSelected': componentSelected.value});
};

let componentSelected = ref({});

onMounted(() => {
    if (props.dataParent.sectionSelected) {
        componentSelected.value = props.dataParent.sectionSelected;
    }
})

</script>

