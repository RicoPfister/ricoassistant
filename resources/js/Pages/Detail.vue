<template>

     <!-- title -->
<div class="text-center">
    <h1 class="text-2xl border-b border-black">{{ detailData.basicData?.title }}</h1>
    <div class="text-gray-400 text-sm">Video Game |</div>
</div>

<!-- {{ typeof detailData?.activitytData }} -->

<!-- section statement -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++ -->
<div v-if="typeof detailData?.statementData !== 'undefined'">
    <pre>{{ detailData.statementData.statement[0].statement }}</pre>

    <!-- {{ detailData?.statementData.tag[0][0]  }} -->

    <!-- get tag list -->
    <div class="font-bold mt-2">Tags:</div>
    <div v-if="typeof detailData?.statementData.tag !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData.statementData.tag">

            <!-- {{ item }} -->

            <div class="flex fle-row">
                <div v-for="(item2, index2) in item">
                    <!-- {{  item2['content'] }} -->
                    {{ index2 == 0 ? '@' + item2['content'] : index2 < 4 ? ':' + item2['content'] : '' }}

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>

    <!-- get reference parents -->
    <div class="font-bold mt-2">Reference Parents:</div>
    <div v-if="typeof detailData?.statementData.reference_parents !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData?.statementData.reference_parents[1]">
            <i>{{ item['title'] }}</i>{{ (index !== detailData?.statementData.reference_parents[1].length-1  ? '>' : '') }}
        </div>
    </div>
    <div v-else class="">Main Entry</div>

    <!-- get reference children -->
    <div v-if="typeof detailData?.statementData.reference_children !== 'undefined'" class="flex flex-col">
        <div class="font-bold mt-2">Reference Children:</div>
        <div v-for="(item, index) in detailData?.statementData.reference_children" class="flex flex-row">
            {{ item[0]['ref_db_name'] + '&nbsp;' +  item[0]['title'] + '&nbsp;' + item[0]['ref_date'] }}
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['activityTime'] !== 'undefined'">{{  '&nbsp;' + item[0]['ref_id'][0]['activityTime'] +'min'}}</div>
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['path'] !== 'undefined'">{{ '&nbsp;' + 'File: ' + item[0]['ref_id'].length }}</div>

        </div>
    </div>

</div>

<!-- section activity -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div v-if="typeof detailData?.activitytData?.[0] !== 'undefined'">
    123
</div>

<!-- section source -->
<!-- +++++++++++++++++++++++++++++++++++++++++++ -->


<!-- console.log('ok'); -->

<div v-if="typeof detailData?.sourceData?.files !== 'undefined'">

<!-- get tag list -->
<div class="font-bold">Tags:</div>
    <div v-if="typeof detailData?.sourceData.tag !== 'undefined'" class="flex flex-row">
        <div v-for="(item, index) in detailData.sourceData.tag">

            <!-- {{ item }} -->

            <div class="flex fle-row">
                <div v-for="(item2, index2) in item">
                    <!-- {{  item2['content'] }} -->
                    {{ index2 == 0 ? '@' + item2['content'] : index2 < 4 ? ':' + item2['content'] : '' }}

                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>

    <!-- get reference parents -->
    <div class="font-bold mt-2">Reference Parents:</div>
    <div v-if="typeof detailData?.sourceData?.reference_parents !== 'undefined'" class="flex flex-col">
        <!-- {{ detailData?.sourceData.reference_parents['title'] }} -->
        <div class="flex flex-row">
            <div v-for="(item, index) in detailData?.sourceData.reference_parents">
                <i>{{ item['title'] }}</i>{{ (index !== detailData?.sourceData.reference_parents.length-1  ? ' &nbsp;>&nbsp;' : '') }}
            </div>
        </div>

    </div>
    <div v-else class="">Main Entry</div>

    <!-- get reference children -->
    <div v-if="typeof detailData?.sourceData?.reference_children !== 'undefined'" class="flex flex-col">
        <div class="font-bold mt-2">Reference Children:</div>
        <div v-for="(item, index) in detailData?.sourceData.reference_children" class="flex flex-row">

            {{ item[0]['ref_db_name'] + '&nbsp;' +  item[0]['title'] + '&nbsp;' + item[0]['ref_date'] }}
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['activityTime'] !== 'undefined'">{{  '&nbsp;' + item[0]['ref_id'][0]['activityTime'] +'min'}}</div>
            <div v-if="typeof item[0]?.['ref_id']?.[0]?.['path'] !== 'undefined'">{{ '&nbsp;' + 'File: ' + item[0]['ref_id'].length }}</div>

        </div>
    </div>

    <!-- {{ detailData.sourceData.files }} -->

    <!-- image viewer -->
    <div class="flex flex-col">
        <div v-for="(item, index) in controllerFilesImage">
            <div v-if="index == 0" class="mt-2"><b>Images:</b> [{{ controllerFilesImage.length }}]</div>
            <div class="relative border">
                <img class="w-fit max-w-full" ref="fullscreen" :src="'/storage/inventory/' + item.path" />

                <!-- image menu bar -->
                <div>

                <!-- index number -->
                <div class="absolute bottom-0 left-0 m-2">
                    1
                </div>

                <!-- full screen button -->
                <div class="absolute bottom-0 right-0 m-2">
                    <button v-if="volumeActive == 0" @click.prevent="openFullscreen" class="w-5 h-5 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                            <path fill-rule="evenodd" d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                </div>


            </div>
        </div>

    </div>

    <!-- music player -->
    <div class="flex flex-col">
        <div v-for="(item, index) in controllerFilesSound">
            <div v-if="index == 0" class="mt-2"><b>Sound:</b> [{{ controllerFilesSound.length }}]</div>
            <audio ref="audioControl9999999999999999999999999999999999999999999999" @seeked="audioSeeked()" @seeking="audioSeeked()">
                <source :src="'/storage/inventory/' + item.path" type="audio/mpeg">
                <source :src="'/storage/inventory/' + item.path" type="audio/ogg">
                Your browser does not support the audio element.
            </audio>
            <button @click.prevent="audioControlAction('play')">
                Start
            </button>
        </div>
    </div>

    <!-- video player -->
    <div class="flex flex-col">
        <div v-for="(item, index) in controllerFilesVideo" class="h-96">
            <div v-if="index == 0" class="mt-2"><b>Videos:</b>[{{ controllerFilesVideo.length }}]</div>


                <div ref="fullscreen" class="w-fit max-w-full">

                    <!-- video box -->

                    <div class="relative" @mouseover="videoOverlay = 1" @mouseleave="videoOverlay = 0">
                        <video class="w-full" ref="audioControl" @loadedmetadata="audioControlFunction('loadedmetadata')" @timeupdate="audioControlFunction('timeupdate')" disablePictureInPicture >
                            <source :src="'/storage/inventory/' + item.path" type="video/mp4">
                            <!-- <source src="test.mp4" type="video/mp4"></source> -->
                            Your browser does not support the video tag.
                        </video>

                        <!-- video overlay -->
                        <div v-if="videoOverlay" class="absolute top-0 left-0 h-full w-full grid grid-cols-3">
                            <div @click.prevent="videoOverlayFunction(-5)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-5sec</div>
                            <div @click.prevent="videoOverlayFunction(-60)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-1min</div>
                            <div @click.prevent="videoOverlayFunction(-90)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-15min</div>
                            <div @click.prevent="videoOverlayFunction(-2)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-2sec</div>
                            <div @click.prevent="videoControlAction('playPause')" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M15 6.75a.75.75 0 00-.75.75V18a.75.75 0 00.75.75h.75a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75H15zM20.25 6.75a.75.75 0 00-.75.75V18c0 .414.336.75.75.75H21a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75h-.75zM5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256L5.055 7.061z" />
                                </svg>
                            </div>
                            <div @click.prevent="videoOverlayFunction(5)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+5sec</div>
                            <div @click.prevent="videoOverlayFunction(1800)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+30min</div>
                            <div @click.prevent="videoOverlayFunction(600)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+10min</div>
                            <div @click.prevent="videoOverlayFunction(60)"  class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+1min</div>
                        </div>
                    </div>

                    <!-- video control box -->
                    <div class="flex flex-row items-center h-[15px]s mt-[2px] bg-white">

                        <!-- play/pause button -->
                        <button @click.prevent="videoControlAction('playPause')" class="w-10 h-5 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-7 h-7 -mt-[2px]">
                                <path d="M15 6.75a.75.75 0 00-.75.75V18a.75.75 0 00.75.75h.75a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75H15zM20.25 6.75a.75.75 0 00-.75.75V18c0 .414.336.75.75.75H21a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75h-.75zM5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256L5.055 7.061z" />
                            </svg>
                        </button>

                        <!-- volume button -->
                        <div v-if="volumeActive == 1" @click.prevent="videoControlAction('volume')" class="w-10 h-5 ml-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                                <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM17.78 9.22a.75.75 0 10-1.06 1.06L18.44 12l-1.72 1.72a.75.75 0 001.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 101.06-1.06L20.56 12l1.72-1.72a.75.75 0 00-1.06-1.06l-1.72 1.72-1.72-1.72z" />
                            </svg>
                        </div>

                        <!-- mute button -->
                        <button v-if="volumeActive == 0" @click.prevent="videoControlAction('mute')" class="w-10 h-5 ml-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                                <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                                <path d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                            </svg>
                        </button>

                        <div class="ml-1 w-[60px] flex items-center leading-none h-5">{{ humanTime(currentTime) }}</div>

                        <!-- custom html slider -->
                        <div @change.prevent="videoControlAction('slider')" class="relative slidecontainer flex items-center ml-1 h-full w-5 mt-[2px]">
                            <input ref="slider" type="range" min="0" max="100" value="0" class="slider w-5 z-20" id="myRange">
                            <div class="absolute w-full pointer-events-none z-10">
                                <div class="bg-gray-300 h-[4px] pointer-events-none w-full"></div>
                                <div class="bg-gray-400 h-[4px] pointer-events-none w-full"></div>
                                <div class="bg-gray-300 h-[4px] pointer-events-none w-full"></div>
                            </div>
                        </div>

                        <div class="ml-1 w-[60px] flex items-center leading-none h-5">{{ humanTime(audioControlData?.[0]?.duration)}}</div>

                        <!-- fullscreen button -->
                        <button v-if="volumeActive == 0" @click.prevent="openFullscreen" class="w-10 h-5 ml-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                                <path fill-rule="evenodd" d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>



        </div>
    </div>

    <div class="flex flex-col">
        <div v-for="(item, index) in controllerFilesPDF">
            <div v-if="index == 0" class="mt-2"><b>PDFs:</b>[{{ controllerFilesPDF.length }}]</div>
            <iframe :src="'/storage/inventory/' + item.path"></iframe>
        </div>
    </div>

    <div class="flex flex-col">
        <div v-for="(item, index) in controllerFilesZIP">
            <div v-if="index == 0" class="mt-2"><b>ZIPs:</b>[{{ controllerFilesZIP.length }}]</div>
            <div &#47;storage&#47;inventory&#47; {{ item.path }} />
        </div>
    </div>

    <div class="flex flex-col">
        <div v-for="(item, index) in controllerFilesOther">
            <div v-if="index == 0" class="mt-2"><b>Others:</b>[{{ controllerFilesOther.length }}]</div>
            <div &#47;storage&#47;inventory&#47; {{ item.path }} />
        </div>
    </div>

    <!-- <div class="flex flex-col">
        <div v-for="(item, index) in detailData.sourceData.files">
            <div v-if="index == 0 && item.extension == 'mp4'" class="mt-2"><b>Videos:</b> [{{ index+1 }}]</div>
            <video v-if="item.extension == 'mp4'" width="320" height="240" controls>
                <source :src="'/storage/inventory/' + item.path">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <div class="flex flex-col">
        <div v-for="(item, index) in detailData.sourceData.files">
            <div v-if="index == 0 && item.extension == 'pdf'" class="mt-2"><b>PDF:</b> [{{ index+1 }}]</div>
            <iframe  v-if="item.extension == 'pdf'" :src="'/storage/inventory/' + item.path"></iframe>
        </div>
    </div> -->

</div>

</template>

<style>
.slidecontainer {
  width: 100%;
  height: 12px;
}

.slider {
  -webkit-appearance: none;
  width: 100%;
  height: 12px;
  position: relative;
  /* opacity: 10%; */
  background: none;
  /* outline: none; */
  /* opacity: 100%; */
}

/* .slider:hover {
  opacity: 1;
} */

.slider::-webkit-slider-thumb {
  -webkit-appearance: none;
  appearance: none;
  width: 2px;
  height: 12px;
  border-radius: 0;
  border: none;
  background: #000000;
  cursor: pointer;
  position: absolute;
}

.slider::-moz-range-thumb {
  width: 2px;
  height: 12px;
  border-radius: 0;
  border: none;
  background: #000000;
  cursor: pointer;
  position: absolute;
}
</style>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from '../Components/Detail/IndexSubHeading1.vue'

const props = defineProps(['detail']);

let detailData = ref(['']);

let IndexSubHeadingOpen = ref([]);
let indexMenuOpen = ref(0);
let indexMenuOpenSwitcher = ref('open');
let IndexShowOpen = ref(1);
let indexLink = ref([0]);
let volumeActive = ref(0);
let videoOverlay = ref(0);

// controller processing definitions
let controllerFilesImage = ref([]);
let controllerFilesSound = ref([]);
let controllerFilesVideo = ref([]);
let controllerFilesPDF = ref([]);
let controllerFilesZIP = ref([]);
let controllerFilesOther = ref([]);
// let currentTimeOverlap = ref(0);

// let audioControl = ref([{'duration': 0, 'currentTime': 0}]);
let audioControl = ref();
let playPauseStatus = ref(0);
// let audioControlData = ref([{'duration': 0, 'currentTime': 0}]);
let audioControlData = ref();
let currentTime = ref(0);
let currentTimeTotal = ref(0);
let slider = ref();
let fullscreen = ref();

onMounted(() => {
    console.log(audioControl.value);
    controller_collection_processing();
    // detailData.value = props?.detail;

    // audioControlData2.value =  audioControl.value[0]?.duration;
    console.log(audioControl.value?.[0]?.readyState);
    // console.log( readyState);
});

watch(() => props.detail, _.debounce( (curr, prev) => {
    controller_collection_processing()
    // detailData.value = props.detail;
}, 500)
);

// watch(() => audioControl,  (curr, prev) => {
//     console.log('ok');
//     audioControlData.value =  audioControl.value;

// },
// );

function videoOverlayFunction(command) {

    currentTimeTotal.value = audioControl.value[0].currentTime;

    // change current time to new value bases on user selection
    currentTimeTotal.value += command;
    console.log(command);

    console.log(currentTimeTotal.value);
    console.log(audioControlData.value[0].duration);

    if (currentTimeTotal.value > audioControlData.value[0].duration) {
        currentTimeTotal.value = audioControlData.value[0].duration;
        audioControl.value[0].currentTime = audioControlData.value[0].duration;
    }

    else if (currentTimeTotal.value < 0) {
        currentTimeTotal.value = 0;
        audioControl.value[0].currentTime = 0;
    }


    else {
        console.log('ok');
        audioControl.value[0].currentTime = currentTimeTotal.value;
    }

    // else {
    //     audioControl.value[0].currentTime = currentTime.value
    // }

    console.log(currentTimeTotal.value);

    // console.log(audioControl.value[0].currentTime);

    console.log(currentTime.value);
    console.log(playPauseStatus.value);

}

function controller_collection_processing() {
    // console.log(props?.detail?.sourceData);
    // console.log(audioControlData2?.value);
    // console.log(audioControlData2?.value[0]?.readyState);

    detailData.value = props?.detail;
    // console.log(detailData.value.sourceData.files)

    if (props?.detail?.sourceData?.files) {
        // console.log('ok');

        controllerFilesImage.value = [];
        controllerFilesSound.value = [];
        controllerFilesVideo.value = [];
        controllerFilesPDF.value = [];
        controllerFilesZIP.value = [];
        controllerFilesOther.value = [];

        props?.detail?.sourceData?.files.forEach((item, index) => controller_files_processing(item, index));

        function controller_files_processing(item, index) {
            console.log(item);
            console.log(item.extension);
            if (item.extension == 'jpg' || item.extension == 'png' || item.extension == 'gif') controllerFilesImage.value.push(item);
            else if (item.extension == 'mp3' || item.extension == 'ogg') controllerFilesSound.value.push(item);
            else if (item.extension == 'mp4') controllerFilesVideo.value.push(item);
            else if (item.extension == 'pdf' || item.extension == 'txt') controllerFilesPDF.value.push(item);
            else if (item.extension == 'zip' || item.extension == 'rar' || item.extension == '7z') controllerFilesZIP.value.push(item);
            else controllerFilesOther.value.push(item);
        }

        // console.log(controllerFilesImage.value);
        // console.log(controllerFilesPDF.value);
    }
}

function videoControlAction(command, data) {

    // console.log(currentTimeTotal.value);

    // console.log(audioControlData2.value);
    // console.log(audioControl.value?.[0]?.readyState);
    // audioControlData.value =  audioControl.value;
    // audioControl.value = audioControl.value;
    audioControlFunction();

    console.log(audioControl.value);

    if (command == 'volume') {
        audioControl.value[0].volume = 0.5;
        volumeActive.value = !volumeActive.value;
    }

    if (command == 'mute') {
        audioControl.value[0].volume = 0;
        volumeActive.value = !volumeActive.value;
    }

    if (command == 'playPause') {

        console.log(currentTime.value);
        console.log(currentTimeTotal.value);
        console.log(audioControlData.value[0].duration);
        console.log(playPauseStatus.value);

        console.log(playPauseStatus.value);

        if (playPauseStatus.value == 0 || (audioControl.value[0].currentTime == 0 || currentTimeTotal.value == audioControlData.value[0].duration)) {

            console.log( audioControl.value[0].currentTime);
            // console.log(audioControlData.value[0].duration);

            if(currentTimeTotal.value == audioControlData.value[0].duration) {
                console.log('ok'); audioControl.value[0].currentTime = 0
                currentTimeTotal.value = 0;
            }

            console.log(playPauseStatus.value);
            console.log(audioControl.value[0].currentTime);


            audioControl.value[0].play();
            playPauseStatus.value = 1;
        }

        else {
            audioControl.value[0].pause();
            playPauseStatus.value = 0;
        }

        console.log(playPauseStatus.value);
    }




    else if (command == 'slider') {

        // console.log(slider.value[0].value);

        // console.log(audioControl.value[0].currentTime);
        // audioControl.value[0].currentTime = 30;
        // console.log(audioControl.value[0].currentTime);
        // console.log(slider.value[0].value);
        // console.log(audioControlData.value[0].currentTime);
        // $duration_ratio =
        currentTime.value = audioControlData.value[0].duration / 100 * slider.value[0].value;
        audioControl.value[0].currentTime = currentTime.value;

        // console.log(audioControlData.value[0].duration);
        // console.log(slider.value[0].value);
        // console.log( audioControlData.value[0].duration / 100 * slider.value[0].value)
        // console.log(data);
    }
}

// watch(() => audioControl[0] (curr, prev) => {
//     console.log('ok');
//     console.log(audioControl.value);

//     audioControlData2.value =  audioControl.value[0].duration;
//     console.log( audioControlData2.value );

// }, {'deep': true};

// watch(() => audioControl, (curr, prev) => {


// console.log(audioControl.value);
// audioControlFunction();
// }, {deep: true}, 500);

function audioControlFunction(command) {

    console.log(command);

    if (command == 'loadedmetadata') {
        audioControlData.value =  audioControl.value;
    }

    else if (command == 'timeupdate') {
        // console.log(slider.value);
        // console.log(audioControlData.value[0].currentTime);
        currentTime.value = audioControl.value[0].currentTime;
        audioControlData.value[0].duration / 100 * slider.value[0].value;
        slider.value[0].value = 100 / audioControlData.value[0].duration * audioControl.value[0].currentTime;
        // console.log(100 / audioControlData.value[0].duration * audioControl.value[0].currentTime);
        // console.log(audioControlData.value[0].duration);
        // console.log(currentTime.value);
        // slider.value[0].value = 50;
        // console.log(Math.round(parseInt(audioControl.value[0].currentTime)));
        // console.log(audioControl.value[0].currentTime);
        // console.log(currentTime.value);
        if (audioControl.value[0].currentTime == audioControlData.value[0].duration) {

            currentTimeTotal.value = audioControlData.value[0].duration;
            playPauseStatus.value = 0;
            console.log(playPauseStatus.value);
            // console.log(audioControlData.value[0].duration );
        }

    }

    // console.log(audioControlData.value);
}


// duration in human time

function humanTime(d) {

    var h = Math.floor(d / 3600);
    var m = Math.floor((d % 3600) / 60);
    var s = Math.floor((d % 3600) % 60);

    var hDisplay = h + ":";
    var mDisplay = m.toString().padStart(2, '0') + ":";
    var sDisplay = s.toString().padStart(2, '0');

    return hDisplay + mDisplay + sDisplay;
  }

//   fullscreen function
function openFullscreen() {

    console.log(navigator.userAgent );
    console.log(fullscreen.value);

    fullscreen.value[0].requestFullscreen();
    // fullscreen.value.requestFullscreen();

}

</script>
