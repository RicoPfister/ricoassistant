<template>

    <div class="relative h-screen flex items-end justify-center">

        <!-- background -->
        <img src="/storage/home/table.jpg" class="w-full">

        <!-- frame -->
        <div class="absolute w-[700px] top-0 my-[50px]">
            <div class="document bg-[#FFFFED] h-[calc(100vh-100px)] shadow-2xl overflow-y-scroll p-14">

                <!-- index -->
                <div>
                    <Index :fromController="props.fromController" />
                </div>

                <!-- content -->
                <div class="mt-3">
                    <Content :fromController="props.fromController" />
                </div>

            </div>
        </div>
    </div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import Index from './Index.vue'
import Content from './Content.vue'

const props = defineProps(['fromController']);

</script>
