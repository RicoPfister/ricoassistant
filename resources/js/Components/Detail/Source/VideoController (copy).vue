<template>

<div class="flex flex-col h-fit">
    <div v-for="(item, index) in props.video" class="">
        <div v-if="index == 0" class="mt-2"><b>Videos:</b>[{{ props.video.length }}]</div>

            <div ref="fullscreen" class="w-fit max-w-full">

                <!-- video box -->

                <div class="relative" @mouseover="videoOverlay = 1" @mouseleave="videoOverlay = 0">
                    <video class="w-full" ref="audioControl" @loadedmetadata="audioControlFunction('loadedmetadata')" @timeupdate="audioControlFunction('timeupdate')" disablePictureInPicture >
                        <source :src="'/storage/inventory/' + item.item.path" type="video/mp4">
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
                        <div @click.prevent="videoOverlayFunction(1800)"  class="relative flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">
                            <div>+30min</div>
                            <div class="absolute bottom-0 left-0 bg-black text-white m-2 p-1 leading-none">{{ item.index+1 }}</div>
                        </div>
                        <div @click.prevent="videoOverlayFunction(600)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+10min</div>
                        <div @click.prevent="videoOverlayFunction(60)"  class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">
                            +1min
                        </div>
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

                    <div class="ml-1 w-[60px] flex items-center leading-none h-5">{{ Date.humanTime(currentTime) }}</div>

                    <!-- custom html slider -->
                    <div @change.prevent="videoControlAction('slider')" class="relative slidecontainer flex items-center ml-1 w-5 mt-[2px]">
                        <input ref="slider" type="range" min="0" max="100" value="0" class="slider w-5 z-20" id="myRange">
                        <div class="absolute w-full pointer-events-none z-10">
                            <div class="bg-gray-300 h-[4px] pointer-events-none w-full"></div>
                            <div class="bg-gray-400 h-[4px] pointer-events-none w-full"></div>
                            <div class="bg-gray-300 h-[4px] pointer-events-none w-full"></div>
                        </div>
                    </div>

                    <div class="ml-1 w-[60px] flex items-center leading-none h-5">{{ Date.humanTime(audioControlData?.[0]?.duration)}}</div>

                    <!-- fullscreen button -->
                    <button v-if="volumeActive == 0" @click.prevent="openFullscreen(index)" class="w-10 h-5 ml-1 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                            <path fill-rule="evenodd" d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
    </div>
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
  top: 0;
  background: #000000;
  cursor: pointer;
  position: absolute;
}

.slider::-moz-range-thumb {
  width: 2px;
  height: 12px;
  border-radius: 0;
  border: none;
  top: 0;
  background: #000000;
  cursor: pointer;
  position: absolute;
}
</style>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

import * as Date from '../../../Scripts/date.js'

const props = defineProps(['video']);

let audioControl = ref();
let playPauseStatus = ref(0);
let audioControlData = ref();
let currentTime = ref(0);
let currentTimeTotal = ref(0);
let slider = ref();
let fullscreen = ref();

let IndexSubHeadingOpen = ref([]);
let indexMenuOpen = ref(0);
let indexMenuOpenSwitcher = ref('open');
let IndexShowOpen = ref(1);
let indexLink = ref([0]);
let volumeActive = ref(0);
let videoOverlay = ref(0);

function videoOverlayFunction(command) {

currentTimeTotal.value = audioControl.value[0].currentTime;

// change current time to new value bases on user selection
currentTimeTotal.value += command;
// console.log(command);

// console.log(currentTimeTotal.value);
// console.log(audioControlData.value[0].duration);

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

    // console.log(currentTime.value);
    // console.log(currentTimeTotal.value);
    // console.log(audioControlData.value[0].duration);
    // console.log(playPauseStatus.value);

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

function audioControlFunction(command) {

// console.log(command);

if (command == 'loadedmetadata') {
    audioControlData.value =  audioControl.value;
}

else if (command == 'timeupdate') {
    // console.log('slider', slider.value);
    // console.log(audioControlData.value);
    // console.log(audioControlData.value[0].duration);
    // console.log(audioControl.value[0].currentTime);

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
    // slider.value[0].value = 75;
}

// console.log(audioControlData.value);


}

function openFullscreen(data) {
    fullscreen.value[data].requestFullscreen();
}




</script>
