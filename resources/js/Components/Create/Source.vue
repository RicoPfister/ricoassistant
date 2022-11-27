
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
            <div class="flex flex-row">
                <input class="hidden" id="fileinput" @change="FileChange($event, index)" type="file" multiple>
                <label class="bg-gray-300 rounded-xl cursor-pointer px-2 hover:bg-blue-300 font-bold border border-gray-300" for="fileinput">Upload files</label>
                <div class="">&nbsp;(max. <b>10 MB</b> in total):</div>
            </div>

            <!-- hidden file list/preview -->
            <div v-if="InputData[0]" class="flex flex-col my-2">

                <!-- upload list -->
                <div class="mb-2">
                    <div class="flex justify-between border-b border-black mb-2">
                        <div class=" font-bold">Upload list:</div>

                        <!-- clear list -->
                        <button @click="InputData.splice(0, InputData.length); preview.splice(0, InputData.length)" class="flex flex-row items-center group hover:bg-red-300" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" color="darkred" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:stroke-2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <div class="">Clear list</div>
                        </button>
                    </div>

                    <div  v-for="(item, index) in InputData" :class="{'border-b border-gray-300': index != InputData.length-1}" class="flex flex-col w-full">
                        <div class="flex justify-between w-full">

                            <!-- upload list text -->
                            <div class="truncate grow"><span class="bg-black text-white px-1 font-bold">{{ item.key }}</span> {{ item.filename }}</div>

                            <!-- size/tag/remove -->
                            <div class="flex flex-row items-center min-w-fit">
                                <div class="">{{ Math.round(item.size/1000/1000 * 1000)/1000 + ' MB' }}</div>

                                    <!-- tag button -->
                                    <button class="" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" color="lightgray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1 hover:stroke-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                        </svg>
                                    </button>

                                <!-- remove button -->
                                <button class="" @click="InputData.splice(index, 1); preview.splice(index, 1)" type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" color="darkred" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- upload preview -->
                <div class="border-b border-black font-bold">Upload Preview (if available):</div>
                <div class="flex flex-wrap mt-1">
                    <div v-for="(item, index) in InputData" class="">
                        <div v-if="item.type.split('/')[0] == 'image'" class="p-1">
                            <div class="relative border-2 border-black h-36">
                                <img :src="preview[index]" class="w-[211px] max-h-full">
                                <div class="absolute bottom-0 px-1 bg-black text-white font-bold">{{ item.key }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";

let dataChild = ref({'statement': ''});

const props = defineProps(['dataParent', 'dataChild', 'dataForm']);
let emit = defineEmits(['dataChild']);

let uniqueKey = 1;
let InputData = ref([]);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

// function InputDataAction(index) {
//     if (InputData.value.length == index+1) {
//         InputData.value.push('');
//     };
// }

function dataChildMenuEntry(n) {
    // alert(n['formDataEdit']);
    emit('dataChild', {'formDataEdit': n['formDataEdit']});
}

// file preview
let preview = ref([]);
// let fileData = ref();

function FileChange(event, index) {

    // console.log(event.target.files[0].type);

    [...event.target.files].forEach((item, index) => InputDataArray(item, index))

    // event.target.files.forEach(InputDataArray);

    function InputDataArray(item, index) {
        InputData.value.push({'file': item, 'filename': item.name, 'size': item.size, 'type': item.type, 'key': uniqueKey++});
        preview.value.push(URL.createObjectURL(item));
    }

    // InputData.value[index]['filelist'] = event.target.files;
    // InputData.value[index]['filename'] = event.target.files[0].name;

}

// emit form
watch(() => InputData, (curr, prev) => {

emit('dataChild', {'formData': {'filelist': InputData.value, 'previewlist': preview.value}});

}, {deep: true}, 500);

// fill in already extisting data
onMounted(() => {
    if (props.dataForm.filelist) {
        // console.log(props.dataForm.statement);
        InputData.value = props.dataForm.filelist;
        preview.value = props.dataForm.previewlist;
    }
  })

</script>

