<template>

    <div class="relative h-screen flex items-end justify-center">

        <!-- background -->
        <img src="/storage/home/table.jpg" class="w-full">

        <!-- frame -->
        <div :class="'top-['+marginTop+'px]'" class="absolute w-[700px] border">
            <div class="py-7 bg-[#FFFFED] px-12 shadow-2xl">
                <div ref="documentWindow" :class="'h-[calc(100vh-100px-' + marginTop + 'px)]'" class="document overflow-y-scroll border border-gray-100">

                    <!-- title -->
                    <div class="text-center">
                        <!-- <h1 class="text-2xl border-b border-black">{{ detailData.title }}</h1> -->
                        <h1 class="text-2xl border-b border-black">Test</h1>
                        <div class="text-gray-400 text-sm">Video Game | 1986</div>
                    </div>

                    <!-- <button @click="fromChild"></button> -->

                    <!-- index -->
                    <div class="">
                        <Index :fromController="props.fromController" @fromChild="fromChild" />
                    </div>

                    <!-- content -->
                    <div class="mt-3">
                        <Content :fromController="props.fromController" @fromChild="fromChild"/>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import Index from './Index.vue'
import Content from './Content.vue'

const props = defineProps(['fromController', 'fromChild']);

let documentWindow = ref('');
let chapterRef = ref();
let marginTop = ref(40);

function fromChild(data) {
    // console.log(data?.chapterRef);
    // console.log(data?.jumpToChapter);

    if (data?.jumpToChapter != undefined) {
        console.log(chapterRef.value);
        // console.log(chapterRef.value.value[0]);
        // console.log(chapterRef.value.value[data?.jumpToChapter].getBoundingClientRect().top);
        documentWindow.value.scrollTo({left: 0, top: chapterRef.value.value[data.jumpToChapter].getBoundingClientRect().top-24-marginTop.value, behavior: "smooth"});
    }

    if (data?.chapterRef != undefined) {
        chapterRef.value = data.chapterRef;
    }

    // chapterRef =


}

// watch(() => props?.fromChild, _.debounce( (curr, prev) => {

//     }, 500)
// );

</script>
