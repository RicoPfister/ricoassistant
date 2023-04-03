
<template>

<div >

    <!-- source container -->
    <div class="flex flex-col">

        <div class="relative top-[12px] left-[1px] w-[calc(100%-2px)]">
            <SectionTitle :Id="{'Id': 2, 'title': 'Source'}"/>
        </div>

        <!-- upload content box -->
        <div class="border-l border-b border-r border-gray-400 bg-blue-50 text-sm w-full pt-4 gap-2 mt-[12px] p-3">
            <div class="flex flex-row justify-between pt-1">
                <div class="flex flex-row">
                    <input class="hidden" id="fileinput" @change="FileChange($event, index)" type="file" multiple>
                    <label :class="[form2?.errors?.['sourceData.filelist'] || form2?.errors?.['sourceData.files'] ? 'border-red-500 focus:border-red-500 border-4 bg-red-200' : '']" class="cursor-pointer px-2 hover:bg-gray-300 font-bold border border-gray-300 bg-gray-200" for="fileinput">Upload files</label>
                    <div class="">&nbsp;(max. <b>10 MB</b> in total):</div>
                </div>

                <!-- clear list -->
                <button v-if="InputData != ''" @click.prevent="deleteFile('all')" class="flex flex-row items-center group hover:text-red-500" type="button">
                    <div class="">Reset List</div>
                    <svg xmlns="http://www.w3.org/2000/svg" color="none" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 group-hover:stroke-red-500">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div v-if="form2?.errors?.['sourceData.filelist']" class="text-red-500">{{ form2?.errors?.['sourceData.filelist'] }}</div>
            <div v-else-if="form2?.errors?.['sourceData.files']" class="text-red-500">{{ form2?.errors?.['sourceData.files'] }}</div>

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
                            <div v-if="typeof item != 'undefined'" :class="{'border-4 border-red-500 bg-red-200': form2?.errors?.['sourceData.filelist.'+ index +'.type']}" class="flex justify-between w-full">

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
                                    <!-- <button class="" @click="deleteFile(index)" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" color="darkred" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-red-400">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button> -->
                                </div>
                            </div>
                            <div v-if="form2?.errors?.['sourceData.filelist.'+ index +'.type']" class="text-red-500">{{ form2?.errors?.['sourceData.filelist.'+ index +'.type'] }}</div>
                        </div>
                    </div>
                </div>

                <!-- source tags -->
                <!-- ------------------------------------------------------ -->
                <div v-if="1" class="border-b-2 border-black font-bold">Tags</div>
                <div v-if="1" class="pt-2 space-y-[2px] w-full">
                    <div v-for="(item, index) in tag_db_data">
                        <div v-if="typeof item != 'undefined'" class="border border-black w-full">
                            <div class="w-full">
                                <div class="truncate flex flex-row w-ful"><span class="bg-black text-white px-1 font-bold flex items-center">{{ item.key }}</span><TagForm :toChild="{'parentId': 3, 'parentIndex': index, 'formTags': tag_db_data[index]['tag'], 'validationError': form2?.['errors']?.['sourceData.tag.' + [index]]}" :fromController2="props.fromController2" @fromChild="fromChild"/></div>
                            </div>
                        </div>
                        <div v-if="form2?.errors?.['sourceData.tag.'+ [index]]" class="text-red-500">{{ form2?.errors?.['sourceData.tag.'+ [index]] }}</div>
                    </div>
                </div>

                <!-- source preview-->
                <div v-if="1" class="border-black border-b-2 font-bold mt-1">Source Preview (if available)</div>
                <div class="flex flex-wrap mt-1 gap-x-2">
                    <div v-for="(item, index) in InputData" class="">
                        <div v-if="item.type != '' & item.type.slice(0, 5) == 'image' | item.type.slice(0, 5) == 'video' | item.type.slice(0, 5) == 'audio'  | item.type == 'application/pdf' | item.type == 'text/plain'" class="py-1">
                            <div class="relative border-2 border-black h-36">
                                <img v-if="item.type.slice(0, 5) == 'image'" :src="preview[index]" class="w-[214px] max-h-full">
                                <!-- <div v-else-if="item.type == undefined"></div> -->
                                <video v-else-if="item.type.slice(0, 5) == 'video' | item.type.slice(0, 5) == 'audio'" :src="preview[index]" class="w-[214px] max-h-full" controls muted></video>
                                <iframe v-else-if="item.type == 'application/pdf' | item.type == 'text/plain'" :src="preview[index]" class="w-[214px] max-h-full" controls muted></iframe>
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
<!-- <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0 z-50">
    <TagPopup :fromParentTagString="tagCollectionInputFormat[tagCollectionInputIndex]" :data-common="props.dataCommon" @tag-popup-open="tagPopupOpen = 0" :data-form="props.dataForm" @fromChild="fromChild"/>
</div> -->

<div v-if="!props?.toChild?.componentCollection?.find(element => element == 4) && !props?.toChild?.statementData" class="border-l border-r border-b border-black h-[31px]">
    <Reference :fromController="typeof props.fromController !== 'undefined' ? props.fromController : ''" :toChild="{'parentId': 3, 'parentIndex': 0, 'parents_reference': reference_db_data?.[0]?.[0]?.title, 'formTags': tag_db_data.value?.[index]}" :transferCreate="props.transferCreate" :transfer="props.toChild.parentId == 5 ? props.toChild : ''" @fromChild="fromChild"/>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';

import MenuEntry from "../Create/MenuEntry.vue";
import TagPopup from "../TagManager/TagPopup.vue";
import TagForm from "../TagManager/TagForm.vue"
import * as TagFromStringToGroup from "../../Scripts/tagFromStringToGroup.js"
import Reference from "./Reference.vue";
import SectionTitle from "../FormManager/SectionTitle.vue"

let dataChild = ref({'statement': ''});

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'fromChild', 'fromController', 'transfer', 'toParent', 'toChild', 'transferCreate', 'dataToParent', 'fromController2', 'fromController_validation']);
let emit = defineEmits(['dataChild', 'dataParent', 'fromChild', 'toParent', 'dataToParent', 'fromController_validation']);
let tagPopupOpen = ref();

let uniqueKey = ref(1);
let InputData = ref([]);
let previewPath = '';
let tag_db_data = ref([]);
let reference_db_data = ref({});
// let previewCheck = ref(0);

let tagListForDB = [];

// file preview
let preview = ref([]);

function FileChange(event, index) {

    console.log('ok');

    [...event.target.files].forEach((item, index) => InputDataArray(item, index))

    function InputDataArray(item, index) {
        console.log('ok');
        InputData.value.push({'file': item, 'filename': item.name, 'size': item.size, 'type': item.type, 'key': uniqueKey.value});
        preview.value.push(URL.createObjectURL(item));
        tag_db_data.value.push({['tag']: '', 'key': uniqueKey.value});
        uniqueKey.value++;
    }

    // duplicate
    // let dbTagData_collection = [];
    //     tag_db_data.value.forEach((item, index) => {

    //         console.log(index);
    //         console.log(item);

    //         dbTagData_collection[index] = item;

    //     });


    emit('fromChild', {'section':'sourceData', 'subSection':'filelist', 'form': InputData.value});
    emit('fromChild', {'section':'sourceData', 'subSection':'previewlist','form': preview.value});
    // emit('fromChild', {'section': 'sourceData', 'subSection': 'tagSource', 'form': tag_db_data});
}

// fill in already extisting data
onMounted(() => {
    if (props.dataForm.filelist) {
        InputData.value = props.dataForm.filelist;
        preview.value = props.dataForm.previewlist;
    }

    if (props?.toChild?.sourceData) {

        // console.log(props.toChild.sourceData.files);

        props.toChild.sourceData.files.forEach((item, index) => soureDataFilesGroup(item, index));

        function soureDataFilesGroup(item, index) {
            // console.log(item);
            InputData.value.push({'filename': item.path, 'size': item.size, 'type': item.extension, 'key': uniqueKey.value});
            tag_db_data.value[index] = {};
            tag_db_data.value[index]['key'] = uniqueKey.value;
            uniqueKey.value++;
            previewPath = '/storage/inventory/' + item.path;
            preview.value.push(previewPath);
        }

        // tag_db_data.value

        if (props?.toChild?.sourceData?.tag) {

            // console.log('ok');
            // console.log(props.toChild.sourceData.tag);

            // tag_db_data.value = props?.toChild?.sourceData?.tag;

            for (let ii = 0; ii < props?.toChild?.sourceData?.tag.length; ii++) {
                if (props?.toChild?.sourceData?.tag[ii].length > 0) {
                    tag_db_data.value[ii]['tag'] = props?.toChild?.sourceData?.tag[ii];
                }
            }

            // props?.toChild?.sourceData?.tag.forEach((element, index) => {
            //     tag_db_data.value[index]['tag'] = element;
            // });
        }

        if (props?.toChild?.sourceData?.reference_parents) {
            reference_db_data.value = props?.toChild?.sourceData?.reference_parents;
        }
    }
  })

// send changes to parent

// send to parent: tag data from child
function fromChild(data) {

    // console.log(data);
    // console.log(data.component);
    // console.log(data?.reference?.reference.referenceTitle);

    if (data.component == "tag" && data.parentId == 3) {
        // console.log(data);
        tag_db_data.value[data.parentIndex]['tag'] = data.tagString;

        // console.log(data.tagList);

        // cleaning taglist

        // tag_db_data.value.forEach((element, index) => {
        tagListForDB[data.parentIndex] = data.tagList;
        // else if (data.tagList == '' && typeof tagListForDB[data.parentIndex] != 'undefined') tagListForDB.splice(data.parentIndex, 1);
        // });

        emit('fromChild', {'section':'sourceData', 'subSection':'tag', 'form': tagListForDB, 'index': data.parentIndex, 'index_temp_undefined': 1});
    }

    if (data.component == 'reference' && data.parentId == 3) {
        // console.log(data);
        emit('fromChild', {'section':'sourceData', 'subSection':'reference_parents', 'index': 0, 'form': data.reference});
    }
}

// send to parent: file upload
// watch(() => InputData, (curr, prev) => {
//     emit('fromChild', {'section':'sourceData', 'subSection':'filelist', 'form': InputData.value});
//     emit('fromChild', {'section':'sourceData', 'subSection':'previewlist','form': preview.value});
// }, {deep: true}, 500);

// send to parent:
// watch(() => dataChild, (curr, prev) => {
// emit('dataChild', {'formData': dataChild.value});
// }, {deep: true}, 500);

// send to parent: box menu
// function dataChildMenuEntry(n) {
// emit('dataChild', {'formDataEdit': n['formDataEdit']});
// }

// emit formData
// let form = ref({});
// function toParentTagDataGroup(index) {
//     tagCollectionInputIndex.value = index;

//     form.value[index] = TagFromStringToGroup.tagFromStringToGroup(tagCollectionInputFormat.value[tagCollectionInputIndex.value]);

//     // console.log(form.value);

//     // send formData
//     emit('toParent', {'sourceTag': form.value});
// }

// function tag_db_data_function(data) {

// }

function deleteFile(data) {

    if (data == 'all') {

        // console.log(props.fromChild);
        // console.log('ok');

        preview.value.splice(0, InputData.value.length);
        tag_db_data.value.splice(0, InputData.value.length);
        InputData.value.splice(0, InputData.value.length);
        uniqueKey.value = 1

        emit('fromChild', {'section':'sourceData', 'subSection':'delete', 'form': 'entries'})

        // emit('fromChild', {'section':'sourceData', 'subSection':'previewlist','form': preview.value});

        tag_db_data.value.forEach((element, index) => {
            // console.log(element);
            // console.log(index);
            uniqueKey.value = 1;
            emit('fromChild', {'section':'sourceData', 'subSection':'tag', 'index': index, 'form': ''});
        });

        // array.forEach(element => {

        // });
    }

    else {
        InputData.value.splice(data, 1);
        tag_db_data.value.splice(data, 1);
        // delete InputData.value[data];
        // delete tag_db_data.value[data];

        preview.value.splice(data, 1);
        // delete preview.value[data];
        // uniqueKey = 1;

        // set db tag collection index

        // props.toChild.sourceData.files.forEach((item, index) => soureDataFilesGroup(item, index));
        tagListForDB.splice(data, 1);



        // console.log(tag_db_data.value);
        // emit('fromChild', {'section': 'sourceData', 'subSection': 'tagSource', 'form': tag_db_data});
        // emit('fromChild', tag_db_data.value);
        // console.log(tag_db_data.value);
        // emit('fromChild', {'section':'sourceData', 'subSection':'filelist', 'index': data, 'form': ''});
        // emit('fromChild', {'section':'sourceData', 'subSection':'previewlist', 'index': data, 'form': ''});
        emit('fromChild', {'section':'sourceData', 'subSection':'filelist', 'form': InputData.value, 'change': data});
    }
}


// validation error processing

// console.log('ok');

const form2 = useForm('key1', {'test': null});

watch(() => usePage().props.value.errors, (curr, prev) => {

// console.log(Object.keys(usePage()?.props.value?.errors).length);
// console.log(Object.keys(form2['errors']).length);

if (Object.keys(usePage()?.props.value?.errors).length) {

    console.log('ok');
    form2['errors'] = usePage().props.value.errors;
    // form2['errors']['sourceData.tag'] = [];

    for (const [key, value] of Object.entries(form2['errors'])) {
        // console.log(`${key}: ${value}`);
        if (key.match(/sourceData\.tag./g)) {
            console.log(key.slice(15,16))
            form2['errors']['sourceData.tag.' + [key.slice(15,16)]] = value;
            // validationError.value[key.slice(17,18)] = 1;
        }

        // else  form2['errors']['sourceData.tag.' + [key.slice(15,16)]] = null;
    }
}

// else if (Object.keys(usePage()?.props.value?.errors).length == 0 && Object.keys(form2['errors']).length == 1) {

//     console.log('ok');
//     form2['errors'] = '';
//     }
});

</script>
