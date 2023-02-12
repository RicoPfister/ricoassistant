<template>

<!-- upload content box -->
<div class="">

<!-- hidden file list/preview -->
<div v-if="1" class="flex flex-col my-2">

    <!-- source list -->
    <!-- ------------------------------------------------------ -->
    <div class="">

        <div class="border-b-2 border-black font-bold">File List</div>

        <div class="py-1">
            <div  v-for="(item, index) in controllerFiles.image.value" :class="{'border-b border-gray-300': index != controllerFiles.image.length-1}" class="flex flex-col w-full">
                <div class="flex justify-between w-full">

                    <!-- index/file name -->
                    <div class="truncate grow"><span class="bg-black text-white px-1 font-bold">{{ index+1 }}</span> {{ item.item.path }}</div>

                    <!-- size/tag/remove -->
                    <div class="flex flex-row items-center min-w-fit">
                        <div class="">{{ Math.round(item.item.size/1000/1000 * 1000)/1000 + ' MB' }}</div>

                            <!-- tag button -->
                            <!-- <button class="" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" color="lightgray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1 hover:stroke-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                            </button> -->

                         </div>
                </div>
            </div>
        </div>
    </div>

    <!-- source tags -->
    <!-- ------------------------------------------------------ -->
    <div class="border-b-2 border-black font-bold">Tags</div>
    <div class="pt-2 w-full">
        <div v-for="(item, index) in props.detailData.sourceData.tag" class="flex flex-row flex-wrap">

            <!-- tag index -->
            <div class="truncate"><span class="bg-black text-white px-1 mr-1 font-bold">{{ index+1 }}</span> {{ item.path }}</div>

            <div v-for="(item2, index2) in item" class="mb-1 mr-1">
                <!-- tag groups -->
                <div class="truncate bg-lime-200 rounded-xl px-2 w-fit"> {{ '@'+item2[0] + ':' + item2[1] + ':' + item2[2] + '(' + item2[3] + ')' }} </div>
            </div>
        </div>
    </div>

    <!-- source preview-->
    <div class="border-black border-b-2 font-bold my-1">File Preview (if available)</div>
    <div class="flex flex-wrap mt-1 gap-1">
        <div v-for="(item, index) in controllerFiles.image.value" class="">

                <div class="relative border-2 h-36">
                    <!-- <img :src="preview[index]" class="w-[214px] max-h-full"> -->
                    <img class="w-[214px] max-h-full" :ref="fullscreen.image" :src="'/storage/inventory/' + item.item.path" />










    <!-- image menu bar -->
    <div>

    <!-- index number -->
    <div class="absolute bottom-0 left-0 m-2">
    {{ index+1 }}
    </div>

    <!-- full screen button -->
    <!-- <div class="absolute bottom-0 right-0 m-2">
        <button v-if="props.volumeActive == 0" @click.prevent="Fullscreen.openFullscreen(fullscreen.image.value[index])" class="w-5 h-5 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                <path fill-rule="evenodd" d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z" clip-rule="evenodd" />
            </svg>
        </button>
    </div> -->


</div>













                </div>

        </div>
    </div>
</div>
</div>







</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

import * as Fullscreen from '../../../Scripts/fullscreen.js'

const props = defineProps(['detailData']);

let fullscreen = {'image': ref()};

// let controllerFilesImage = ref([]);
// let controllerFilesSound = ref([]);
// let controllerFilesVideo = ref([]);
// let controllerFilesPDF = ref([]);
// let controllerFilesZIP = ref([]);
// let controllerFilesOther = ref([]);

let controllerFiles = {
    image: ref([]),
    sound: ref([]),
    video: ref([]),
    doucument: ref([]),
    paackage: ref([]),
    other: ref([]),
}

function controller_collection_processing() {

    console.log('ok');

    if (props?.detailData?.sourceData?.files) {

        props?.detailData?.sourceData?.files.forEach((item, index) => controller_files_processing(item, index));

        function controller_files_processing(item, index) {

            // console.log(index);
            // console.log(item.extension);

            if (item.extension == 'jpg' || item.extension == 'png' || item.extension == 'gif') controllerFiles.image.value.push({'item': item, 'index': index});
            else if (item.extension == 'mp3' || item.extension == 'ogg') controllerFiles.sound.value.push({'item': item, 'index': index});
            else if (item.extension == 'mp4') controllerFiles.video.value.push({'item': item, 'index': index});
            else if (item.extension == 'pdf' || item.extension == 'txt') controllerFiles.pdf.value.push({'item': item, 'index': index});
            else if (item.extension == 'zip' || item.extension == 'rar' || item.extension == '7z') controllerFiles.zip.value.push({'item': item, 'index': index});
            else controllerFiles.other.value.push({'item': item, 'index': index});
        }
    }
}

onMounted(() => {
    controller_collection_processing();
});

watch(() => props.detailData, _.debounce( (curr, prev) => {
    controller_collection_processing();
    }, 500)
);

</script>
