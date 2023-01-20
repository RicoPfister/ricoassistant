<template>




<!-- section activity -->
<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++ -->
<div v-if="typeof detailData?.activitytData?.[0] !== 'undefined'">
    123
</div>

<!-- section source -->
<!-- +++++++++++++++++++++++++++++++++++++++++++ -->


<!-- console.log('ok'); -->

<div v-if="typeof detailData?.sourceData?.files !== 'undefined'">
    <div class="font-bold mt-2 bg-black text-white w-full">Source</div>




    <!-- get reference parents -->
    <div class="font-bold mt-2 bg-gray-300 w-full mb-1">Reference Parents</div>
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



    <SourceMediaList v-if="controllerFilesImage.length > 0" :detail="props.detail" :controllerFilesImage="controllerFilesImage" :volumeActive="volumeActive"/>

































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
import SourceMediaList from '../Components/Detail/Source/MediaList.vue'

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
let fullscreen = {'image': ref()};



</script>
