<template>

    <div class="flex flex-col h-fit space-y-10">
        <div v-for="(item, index) in props.video" class="gap-5">
            <div v-if="index == 0" class="my-2"><b>Videos </b>[{{ props.video.length }}]:</div>

                <div>

                    <!-- video box -->

                    <div class="relative border" @mouseover="videoOverlay[index] = 1" @mouseleave="videoOverlay[index] = 0">
                        <div ref="fullscreen">
                            <video class="w-full" ref="audioControl" @loadedmetadata="audioControlFunction(index, 'loadedmetadata')" @timeupdate="audioControlFunction(index, 'timeupdate')" disablePictureInPicture >
                                <source :src="item.item.path + '/' + item.item.file" type="video/mp4">
                                <track v-if="item?.item?.subtitle_english" :src="item?.item?.path + '/1-1-1.vtt'" label="English" kind="subtitles" srclang="en" default>
                                <!-- <source :src="'DiskStation/1492 - Conquest of Paradise/1492.Conquest.of.Paradise.1992.720p.BluRay.x264.anoXmous_.mp4'" type="video/mp4"> -->
                                <!-- <source :src="'storage/inventory/test.mp4'" type="video/mp4"> -->
                                <!-- <source :src="'/DiskStation/Artist/The.Artist.2011.720p.BluRay.x264.YIFY.mp4'" type="video/mp4"> -->
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <!-- video overlay -->
                        <div v-if="videoOverlay[index]" class="absolute top-0 left-0 h-full w-full grid grid-cols-3">
                            <div @click.prevent="videoOverlayFunction(index, -5)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-5sec</div>
                            <div @click.prevent="videoOverlayFunction(index, -60)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-1min</div>
                            <div @click.prevent="videoOverlayFunction(index, -90)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-15min</div>
                            <div @click.prevent="videoOverlayFunction(index, -2)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">-2sec</div>
                            <div @click.prevent="videoControlAction(index, 'playPause')" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6">
                                    <path d="M15 6.75a.75.75 0 00-.75.75V18a.75.75 0 00.75.75h.75a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75H15zM20.25 6.75a.75.75 0 00-.75.75V18c0 .414.336.75.75.75H21a.75.75 0 00.75-.75V7.5a.75.75 0 00-.75-.75h-.75zM5.055 7.06C3.805 6.347 2.25 7.25 2.25 8.69v8.122c0 1.44 1.555 2.343 2.805 1.628l7.108-4.061c1.26-.72 1.26-2.536 0-3.256L5.055 7.061z" />
                                </svg>
                            </div>
                            <div @click.prevent="videoOverlayFunction(index, 5)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+5sec</div>
                            <div @click.prevent="videoOverlayFunction(index,1800)"  class="relative flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">
                                <div>+30min</div>
                                <div class="absolute bottom-0 left-0 bg-black text-white m-2 p-1 leading-none">{{ item.index+1 }}</div>
                            </div>
                            <div @click.prevent="videoOverlayFunction(index, 600)" class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">+10min</div>
                            <div @click.prevent="videoOverlayFunction(index, 60)"  class="flex items-center justify-center bg-gray-50 opacity-50 hover:opacity-75" type="button">
                                +1min
                            </div>
                        </div>
                    </div>

                    <!-- video control box -->
                    <div class="flex flex-row items-center h-[15px]s mt-[2px] bg-white">

                        <!-- pause button -->
                        <button v-if="playPauseStatus[index] == undefined || playPauseStatus[index] == 0" @click.prevent="videoControlAction(index, 'playPause')" class="w-10 h-5 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 -mt-[2px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 5.25v13.5m-7.5-13.5v13.5" />
                            </svg>
                        </button>

                        <!-- play button -->
                        <button v-if="playPauseStatus[index] == 1" @click.prevent="videoControlAction(index, 'playPause')" class="w-10 h-5 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 -mt-[2px]">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                        </button>

                        <!-- volume button -->
                        <button v-if="volumeActive[index] != 1" @click.prevent="videoControlAction(index, 'mute')" class="w-7 h-5 ml-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                                <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM18.584 5.106a.75.75 0 011.06 0c3.808 3.807 3.808 9.98 0 13.788a.75.75 0 11-1.06-1.06 8.25 8.25 0 000-11.668.75.75 0 010-1.06z" />
                                <path d="M15.932 7.757a.75.75 0 011.061 0 6 6 0 010 8.486.75.75 0 01-1.06-1.061 4.5 4.5 0 000-6.364.75.75 0 010-1.06z" />
                            </svg>
                        </button>

                        <!-- mute button -->
                        <button v-if="volumeActive[index] ==  1" @click.prevent="videoControlAction(index, 'volume')" class="w-7 h-5 ml-1 flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" color="red" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                                <path d="M13.5 4.06c0-1.336-1.616-2.005-2.56-1.06l-4.5 4.5H4.508c-1.141 0-2.318.664-2.66 1.905A9.76 9.76 0 001.5 12c0 .898.121 1.768.35 2.595.341 1.24 1.518 1.905 2.659 1.905h1.93l4.5 4.5c.945.945 2.561.276 2.561-1.06V4.06zM17.78 9.22a.75.75 0 10-1.06 1.06L18.44 12l-1.72 1.72a.75.75 0 001.06 1.06l1.72-1.72 1.72 1.72a.75.75 0 101.06-1.06L20.56 12l1.72-1.72a.75.75 0 00-1.06-1.06l-1.72 1.72-1.72-1.72z" />
                            </svg>
                        </button>

                        <div class="ml-1 w-[60px] flex items-center leading-none h-5">{{ Date.humanTime(currentTime) }}</div>

                        <!-- custom html slider -->
                        <div @change.prevent="videoControlAction(index, 'slider')" class="relative slidecontainer flex items-center ml-1 w-5 mt-[2px]">
                            <input ref="slider" type="range" min="0" max="100" value="0" class="slider w-5 z-20" id="myRange">
                            <div class="absolute w-full pointer-events-none z-10">
                                <div class="bg-gray-300 h-[4px] pointer-events-none w-full"></div>
                                <div class="bg-gray-400 h-[4px] pointer-events-none w-full"></div>
                                <div class="bg-gray-300 h-[4px] pointer-events-none w-full"></div>
                            </div>
                        </div>

                        <!-- remaining playtime indicator -->
                        <div class="ml-1 w-[60px] flex items-center leading-none h-5">{{ Date.humanTime(audioControlData[index]?.duration)}}</div>

                        <!-- fullscreen button -->
                        <button v-if="1" @click.prevent="openFullscreen(index)" class="w-10 h-5 ml-1 flex items-center">
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
        appearance: none;
        width: 100%;
        height: 12px;
        position: relative;
        background: none;
    }


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
            /* position: absolute; */
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

    /* Remove dotted outline from range input element focused in Firefox */
    .slider::-moz-focus-outer { border: 0; }

    </style>

    <script setup>

    import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

    import * as Date from '../../../Scripts/date.js'

    const props = defineProps(['video']);

    let audioControl = ref([]);
    let playPauseStatus = ref([]);
    let audioControlData = ref([]);
    let currentTime = ref([]);
    let currentTimeTotal = ref([]);
    let slider = ref([]);
    let fullscreen = ref([]);

    let IndexSubHeadingOpen = ref([]);
    let indexMenuOpen = ref(0);
    let indexMenuOpenSwitcher = ref('open');
    let IndexShowOpen = ref(1);
    let indexLink = ref([0]);
    let volumeActive = ref([]);
    let videoOverlay = ref([]);

    function videoOverlayFunction(index, command) {

    currentTimeTotal.value[index]= audioControl.value[index].currentTime;

    // change current time to new value bases on user selection
    currentTimeTotal[index][index].value += command;
    // console.log(command);

    // console.log(currentTimeTotal[index].value);
    // console.log(audioControl[index]Data[index].value[0].duration);

    if (currentTimeTotal.value[index]> audioControlData.value[index].duration) {
        currentTimeTotal.value[index]= audioControlData.value[index].duration;
        audioControl.value[index].currentTime = audioControlData.value[index].duration;
    }

    else if (currentTimeTotal.value[index]< 0) {
        currentTimeTotal.value[index]= 0;
        audioControl.value[index].currentTime = 0;
    }


    else {
        console.log('ok');
        audioControl.value[index].currentTime = currentTimeTotal[index].value;
    }

    // else {
    //     audioControl.value[index].currentTime = currentTime.value
    // }

    console.log(currentTimeTotal[index].value);

    // console.log(audioControl.value[index].currentTime);

    // console.log(currentTime.value);
    // console.log(playPauseStatus.value[index]);

    }

    function videoControlAction(index, command, data) {

        // console.log(currentTimeTotal[index].value);

        // console.log(audioControl[index]Data[index]2.value);
        // console.log(audioControl.value[index]?.[0]?.readyState);
        // audioControl[index]Data[index].value =  audioControl.value[index];
        // audioControl.value[index] = audioControl.value[index];
        audioControlFunction();

        // console.log(audioControl.value[index]);

        if (command == 'volume') {
            audioControl.value[index].volume = 0.5;
            volumeActive.value[index] = !volumeActive.value[index];
        }

        if (command == 'mute') {
            audioControl.value[index].volume = 0;
            volumeActive.value[index] = !volumeActive.value[index];
        }

        if (command == 'playPause') {

            // console.log(currentTime.value);
            // console.log(currentTimeTotal[index].value);
            // console.log(audioControl[index]Data[index].value[0].duration);
            // console.log(playPauseStatus.value[index]);

            console.log(playPauseStatus.value[index]);

            if (playPauseStatus.value[index] == 0 || (audioControl.value[index].currentTime == 0 || currentTimeTotal.value[index]== audioControlData.value[index].duration)) {

                console.log(audioControl.value);

                console.log(audioControl.value[index].currentTime);
                // console.log(audioControlData.value[index].duration);

                if(currentTimeTotal.value[index]== audioControlData.value[index].duration) {
                    console.log('ok'); audioControl.value[index].currentTime = 0
                    currentTimeTotal.value[index]= 0;
                }

                console.log(playPauseStatus.value[index]);
                console.log(audioControl.value[index].currentTime);


                audioControl.value[index].play();
                playPauseStatus.value[index] = 1;
            }

            else {
                audioControl.value[index].pause();
                playPauseStatus.value[index] = 0;
            }

            console.log(playPauseStatus.value[index]);
        }

        else if (command == 'slider') {

            // console.log(slider.value[0].value);

            // console.log(audioControl.value[index].currentTime);
            // audioControl.value[index].currentTime = 30;
            // console.log(audioControl.value[index].currentTime);
            // console.log(slider.value[0].value);
            // console.log(audioControl[index]Data[index].value[0].currentTime);
            // $duration_ratio =
            currentTime.value = audioControlData.value[index].duration / 100 * slider.value[index].value;
            audioControl.value[index].currentTime = currentTime.value;

            // console.log(audioControlData.value[index].duration);
            // console.log(slider.value[0].value);
            // console.log( audioControlData.value[index].duration / 100 * slider.value[0].value)
            // console.log(data);
        }
    }

    function audioControlFunction(index, command) {

    // console.log(command);

    if (command == 'loadedmetadata') {
        audioControlData.value[index] =  audioControl.value[index];
    }

    else if (command == 'timeupdate') {
        // console.log('slider', slider.value);
        // console.log(audioControlData.value[index]);
        // console.log(audioControlData.value[index].duration);
        // console.log(audioControl.value[0].currentTime);

        // console.log(slider.value[index]);
        // console.log(audioControlData.value[index].currentTime);
        currentTime.value = audioControl.value[0].currentTime;
        audioControlData.value[index].duration / 100 * slider.value[index].value;
        slider.value[index].value = 100 / audioControlData.value[index].duration * audioControl.value[0].currentTime;
        // console.log(100 / audioControlData.value[index].duration * audioControl.value[0].currentTime);
        // console.log(audioControlData.value[index].duration);
        // console.log(currentTime.value);
        // slider.value[index].value = 50;
        // console.log(Math.round(parseInt(audioControl.value[0].currentTime)));
        // console.log(audioControl.value[0].currentTime);
        // console.log(currentTime.value);
        if (audioControl.value[index].currentTime == audioControlData.value[index].duration) {

            currentTimeTotal.value[index]= audioControlData.value[index].duration;
            playPauseStatus.value[index] = 0;
            console.log(playPauseStatus.value[index]);
            // console.log(audioControlData.value[index].duration );
        }
        // slider.value[index].value = 75;
    }

    // console.log(audioControlData.value[index]);


    }

    function openFullscreen(data) {
        fullscreen.value[data].requestFullscreen();
    }




    </script>
