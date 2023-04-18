<template>

    <div class="relative h-screen flex items-end justify-center bg-cover bg-no-repeat bg-bottom" style="background-image: url(/storage/create/background_unsplash_edited.avif)">

        <!-- background -->
        <!-- <div class="flex flex-col w-full">
            <img src="/storage/create/sky_unsplash.avif" class="">
            <img src="/storage/home/table.jpg" class="">
        </div> -->

        <!-- frame -->
        <div :class="'top-['+marginTop+'px]'" class="absolute w-[700px] h-[calc(100%-0px)]">
            <div class="py-7 bg-[#FFFFF0] px-12 shadow-2xl h-[calc(100%-100px)]">
                <div ref="documentWindow" :class="'h-[calc(100vh-100px-' + marginTop + 'px)]'" class="document overflow-y-scroll">

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

        <!-- decoration -->
        <div>
            <img v-bind="randomItem[0]" src="/storage/create/bretzel.png" alt="Random pic nic item on a table">
            <img v-bind="randomItem[1]" src="/storage/create/tea.png" alt="Random pic nic item on a table">
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

let randomItem = ref([]);

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
}

// watch(() => props?.fromChild, _.debounce( (curr, prev) => {

//     }, 500)
// );

function randomItem1() {

    for (let index=0; index<1; index++) {
        randomItem.value[0] = {};
        randomItem.value[1] = {};
        // randomItem.value[1] = {'class': {}, 'visible': ''};

        let randomValue1 = Math.floor(Math.random() * 2);
        let randomValue2 = Math.floor(Math.random() * 2);
        console.log(randomValue1);
        console.log(randomValue2);

        let height = ' h-[200px]';
        let bottom = [' bottom-[200px]', ' bottom-[100px]'];
        let rotation = [' rotate-12', ' rotate-45'];
        let visibilty = [' invisible', ' visible']

        randomItem.value[0]['class'] = 'absolute left-[50px]' + height + rotation[randomValue1] + bottom[randomValue1] + visibilty[randomValue1];
        // randomItem.value[0]['visible'] = randomValue1;

        randomItem.value[1]['class'] = 'absolute right-[50px]' + height + bottom[randomValue1] + visibilty[randomValue2];
        // randomItem.value[0]['visible'] = randomValue2;
    }
}

onMounted(() => {
    randomItem1();
});

</script>
