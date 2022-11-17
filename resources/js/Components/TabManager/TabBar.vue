<template>

<div class="flex flex-row justify-between">

    <!-- content tab container -->
    <div class="flex flex-row">

        <!-- first tab -->
        <div class="h-[30px] border-l border-t border-r border-gray-400 rounded-t-xl flex items-center w-fit bg-gray-300 hover:font-bold z-[100]">

            <!-- menu area -->
            <div @mouseleave="tabMenuOpen[1] = 0" class="relative flex items-center h-full pl-2">
                <button @click.prevent="tabMenuOpen[1] = !tabMenuOpen[1]" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                </button>

                <div v-if="tabMenuOpen[1]" class="absolute top-[29px] -left-[1px]">
                    <TabMenu />
                </div>
            </div>

            <!-- text area -->
            <div @click.prevent="" class="text-lg flex items-center pl-1 pr-2 font-bold cursor-default">
                <div>New Entry</div>
            </div>

        </div>

        <!-- following tabs -->
        <div v-for="(item, index) in 4" :style="{'z-index': 100-(index+1)}" class="h-[30px] border-l border-t border-r border-gray-400 rounded-t-xl flex items-center w-fit bg-gray-200 -ml-2">

            <div @mouseleave="tabMenuOpen[index+2] = 0" class="relative flex items-center h-full pl-4">
                <button @click.prevent="tabMenuOpen[index+2] = !tabMenuOpen[index+2]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                </button>

                <div v-if="tabMenuOpen[index+2]" class="absolute top-[29px] -left-[1px] ml-2">
                <TabMenu />
                </div>
            </div>

            <button class="text-lg flex items-center pl-1 pr-2 font-bold">
                <div>{{ index+1 }}</div>
            </button>
        </div>
    </div>

    <!-- tabmanager menu container -->
    <div class="flex flex-row">

        <!-- menu tabs -->
        <div class="h-[30px] border-l border-t border-r border-gray-400 rounded-t-xl flex items-center w-fit bg-gray-300 hover:font-bold z-[99]">

            <!-- menu button -->
            <button @mouseleave="tabMenuOpen[0] = 0" class="relative flex items-center h-full px-2 ">
                <div @click.prevent="tabMenuOpen[0] = !tabMenuOpen[0]">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                    </svg>
                </div>

                <div v-if="tabMenuOpen[0]" class="absolute top-[29px] -left-[0px]">
                    <TabMenu />
                </div>
            </button>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, shallowRef, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import TabMenu from './TabMenu.vue'

let tabMenuOpen = ref([0]);

</script>
