<template>

<!-- upload content box -->

<!-- hidden file list/preview -->
<div v-if="1" class="flex flex-col my-2">

    <!-- source list -->
    <!-- ------------------------------------------------------ -->

    <div class="border-b-2 border-black font-bold">File List</div>

    <div class="py-1">
        <div v-for="(item, index) in controllerFiles.listGroup">
            <div v-for="(item2, index2) in controllerFiles[controllerFiles.listGroup[index]].value" :class="{'border-b border-gray-300': index != controllerFiles.image.length-1}" class="flex flex-col w-full">
                <div class="flex flex-row justify-between w-full items-center">

                    <div class="flex items-center bg-black text-white h-[16px] px-1 font-bold w-fit text-sm mr-1">{{ item2.index+1 }}</div>

                    <div class="w-[24px]">
                        <TagList :check="index"/>
                    </div>

                    <div class="truncate grow ml-1">{{ item2.item.path }}</div>

                    <div class="lex justify-end flex flex-row w-[270px] grow">
                        <!-- index/file name -->
                        <div class="w-fit">{{ Date.DBToList(item2.item.created_at) }}</div>
                        <div class="flex justify-center w-10 ml-1">{{ item2?.item?.extension?.split('/')[1].length <= 4 ? item2.item.extension.split('/')[1] : '' }}</div>
                        <div class="flex justify-end w-[70px]">{{ Number.fileSize(item2.item.size) }}</div>
                    </div>
                </div>
            </div>
        </div>
        <ImageController v-if="controllerFiles.image.value.length > 0" :image="controllerFiles.image.value"/>
        <MusicController v-if="controllerFiles.music.value.length > 0" :music="controllerFiles.music.value"/>
        <VideoController v-if="controllerFiles.video.value.length > 0" :video="controllerFiles.video.value"/>
        <DocumentController v-if="controllerFiles.document.value.length > 0" :document="controllerFiles.document.value"/>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

import * as Date from '../../../Scripts/date.js'
import * as Number from '../../../Scripts/number.js'
import TagList from '../TagIcons.vue';

import ImageController from './ImageController.vue';
import VideoController from './VideoController.vue';
import DocumentController from './DocumentController.vue';
import MusicController from './MusicController.vue';

// import * as Fullscreen from '../../../Scripts/fullscreen.js'

const props = defineProps(['detailData']);

// let controllerFilesImage = ref([]);
// let controllerFilesSound = ref([]);
// let controllerFilesVideo = ref([]);
// let controllerFilesPDF = ref([]);
// let controllerFilesZIP = ref([]);
// let controllerFilesOther = ref([]);

let controllerFiles = {
    image: ref([]),
    music: ref([]),
    video: ref([]),
    document: ref([]),
    package: ref([]),
    other: ref([]),
    listGroup: ['image', 'music', 'video', 'document', 'package', 'other'],
}

function controller_collection_processing() {

    // console.log('ok');

    if (props?.detailData?.sourceData?.files) {

        props?.detailData?.sourceData?.files.forEach((item, index) => controller_files_processing(item, index));

        function controller_files_processing(item, index) {

            // console.log(index);
            // console.log(item.extension);

            if (item.extension == 'image/jpeg' || item.extension == 'image/png' || item.extension == 'image/gif' || item.extension == 'image/webp') controllerFiles.image.value.push({'item': item, 'index': index});
            else if (item.extension == 'audio/mpeg' || item.extension == 'audio/ogg') controllerFiles.music.value.push({'item': item, 'index': index});
            else if (item.extension == 'video/mp4' | item.extension == 'video/unknown') controllerFiles.video.value.push({'item': item, 'index': index});
            else if (item.extension == 'application/pdf' || item.extension == 'application/txt') controllerFiles.document.value.push({'item': item, 'index': index});
            else if (item.extension == 'application/zip' || item.extension == 'application/rar' || item.extension == '7z') controllerFiles.package.value.push({'item': item, 'index': index});
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
