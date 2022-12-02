
<template>

<div>
    <!-- source container -->
    <div class="flex flex-col">

        <div class="flex flex-row justify-between items-center" type="button">

            <label class="" aria-label="Statement Input" for="statement">Source*: </label>

            <MenuEntry @data-child="dataChildMenuEntry"/>

        </div>

        <!-- upload content box -->
        <div class="bg-blue-50 border border-black p-3">
            <div class="flex flex-row justify-between">
                <div class="flex flex-row">
                    <input class="hidden" id="fileinput" @change="FileChange($event, index)" type="file" multiple>
                    <label class="cursor-pointer px-2 hover:bg-gray-300 font-bold border border-gray-300 bg-gray-200" for="fileinput">Upload files</label>
                    <div class="">&nbsp;(max. <b>10 MB</b> in total):</div>
                </div>

                <!-- clear list -->
                <button v-if="InputData != ''" @click.prevent="InputData.splice(0, InputData.length); preview.splice(0, InputData.length); uniqueKey = 1" class="flex flex-row items-center group hover:text-red-500" type="button">
                    <div class="">Reset List</div>
                    <svg xmlns="http://www.w3.org/2000/svg" color="none" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:stroke-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- hidden file list/preview -->
            <div v-if="InputData[0]" class="flex flex-col my-2">

                <!-- source list -->
                <!-- ------------------------------------------------------ -->
                <div class="">
                    <div class="flex justify-between border-b-2 border-black">
                        <div class="font-bold">Source List</div>
                    </div>

                    <div class="py-1">
                        <div  v-for="(item, index) in InputData" :class="{'border-b border-gray-300': index != InputData.length-1}" class="flex flex-col w-full">
                            <div class="flex justify-between w-full">

                                <!-- index/file name -->
                                <div class="truncate grow"><span class="bg-black text-white px-1 font-bold">{{ item.key }}</span> {{ item.filename }}</div>

                                <!-- size/tag/remove -->
                                <div class="flex flex-row items-center min-w-fit">
                                    <div class="">{{ Math.round(item.size/1000/1000 * 1000)/1000 + ' MB' }}</div>

                                        <!-- tag button -->
                                        <!-- <button class="" type="button">
                                            <svg xmlns="http://www.w3.org/2000/svg" color="lightgray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1 hover:stroke-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                            </svg>
                                        </button> -->

                                    <!-- remove button -->
                                    <button class="" @click="InputData.splice(index, 1); preview.splice(index, 1)" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" color="darkred" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-red-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- source tags -->
                <!-- ------------------------------------------------------ -->
                <div class="border-b-2 border-black font-bold">Tags</div>
                <div class="py-1">
                    <div v-for="(item, index) in InputData" class="flex flex-row w-full py-[3px] h-[24px] items-center">
                        <div class="bg-black text-white px-1 font-bold flex items-center">{{ item.key }}</div>
                        <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent grow leading-none p-1" type="text" placeholder="@Category:Context:Content(Comment)" v-model="tagCollectionInputFormat[index]">
                        <div>
                            <button @click.prevent="tagPopupOpenData(index)" class="flex items-center" type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- source preview-->
                <div class="border-black border-b-2 font-bold">Source Preview (if available)</div>
                <div class="flex flex-wrap mt-1 gap-x-2">
                    <div v-for="(item, index) in InputData" class="">
                        <div v-if="item.type.split('/')[0] == 'image'" class="py-1">
                            <div class="relative border-2 border-black h-36">
                                <img :src="preview[index]" class="w-[214px] max-h-full">
                                <div class="absolute bottom-0 px-1 bg-black text-white font-bold">{{ item.key }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- open popup -->
<div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0">
    <TagPopup :fromParentTagString="tagCollectionInputFormat[tagCollectionInputIndex]" :data-common="props.dataCommon" @tag-popup-open="tagPopupOpen = 0" :data-form="props.dataForm" @dataToParent="dataToParent"/>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagPopup from "../TagManager/TagPopup.vue";

let dataChild = ref({'statement': ''});

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent']);
let emit = defineEmits(['dataChild', 'dataParent']);
let tagPopupOpen = ref();

let uniqueKey = ref(1);
let InputData = ref([]);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

function dataChildMenuEntry(n) {
    emit('dataChild', {'formDataEdit': n['formDataEdit']});
}

// file preview
let preview = ref([]);

function FileChange(event, index) {

    [...event.target.files].forEach((item, index) => InputDataArray(item, index))

    function InputDataArray(item, index) {
        InputData.value.push({'file': item, 'filename': item.name, 'size': item.size, 'type': item.type, 'key': uniqueKey.value++});
        preview.value.push(URL.createObjectURL(item));
    }
}

// emit form
watch(() => InputData, (curr, prev) => {

emit('dataChild', {'formData': {'filelist': InputData.value, 'previewlist': preview.value}});

}, {deep: true}, 500);

// fill in already extisting data
onMounted(() => {
    if (props.dataForm.filelist) {
        InputData.value = props.dataForm.filelist;
        preview.value = props.dataForm.previewlist;
    }
  })

//   tag popup
// ---------------------------------------------------------

// let emit = defineEmits(['dataForm']);




// onMounted(() => {
//     console.log(props.dataForm.basicTitle);

//     if (typeof props.dataParent.title != 'undefined') {
//         // console.log(props.dataForm.statement);
//         title = props.dataParent.title;
//     } else title = 'No title found';
// })

// send tag string to tag popup
let tagCollectionInputFormat = ref([]);
let tagCollectionInputIndex = ref('');

function dataToParent(data) {

    console.log(data);

    if (data.tagCollection) {

        tagCollectionInputFormat.value[tagCollectionInputIndex] = data.tagCollection;
        tagPopupOpen.value = 0;
    }
}

function tagPopupOpenData(index) {

    tagCollectionInputIndex.value = index;

    tagPopupOpen.value = 1;

    // console.log(tagCollectionInputIndex.value);
}

</script>
