<template>

<!-- container -->
<div class="bg-white h-full w-full flex flex-col">

    <!-- ??? -->
    <div class="relative border-r border-gray-400 h-full">

        <!-- header -->
        <div class="flex flex-row border-b border-gray-400 justify-between">

            <!-- add tag dropdown -->
            <button :class="{'bg-gray-400': categoryPopupOpen && popupId == 1}" :disabled="!tagPresetCollection?.[0]" @click="tagPresetPopupFunction" class="group w-fit px-2 bg-gray-200 h-[34px] border-r border-gray-400" type="button">
                <div class="flex flex-row items-center justify-between group-disabled:opacity-30">

                    <div class="flex flex-row">
                        <!-- info button -->
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </div>

                        <div class="ml-1">Preset</div>
                    </div>

                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </button>

            <!-- add tag dropdown -->
            <button :class="{'bg-gray-400': categoryPopupOpen && popupId == 2}" @click="categoryPopupActive" class="w-fit px-2 bg-gray-200 h-[34px] border-r border-gray-400" type="button">
                <div class="flex flex-row items-center justify-between">

                    <div class="flex flex-row">
                        <!-- info button -->
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </div>

                        <div v-if="(props?.fromController?.tagCollection?.length > 0)" class="ml-1">Single</div>
                        <div v-else class="ml-1">Create</div>
                    </div>

                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </button>

            <div class="px-2 flex flex-row items-center justify-center grow">

                <div class="text-xl font-bold flex ml-1">Tag Manager</div>

                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="blue" class="w-5 h-5 ml-1">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </div>

            </div>

            <div class="flex flex-row ">
                <button @click="cancelTagPopup" class="px-2 bg-gray-200 h-[34px] flex items-center border-l border-r border-gray-400" type="button">
                    <div class="flex flex-row items-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>Cancel</div>
                    </div>
                </button>

                <button @click="saveTagPopup" class="px-2 bg-gray-200 h-[34px] flex items-center" type="button">
                    <div class="flex flex-row items-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>Save</div>
                    </div>
                </button>
            </div>
        </div>

        <!-- content box -->
        <div class="overflow-y-scroll h-[calc(100%-35px)] z-50">
            <contentBox :toChild="{'tagSelection': {'tagSelection': tagSelection, 'keyid': keyid}, 'tagSelectionListString': tagSelectionListString, 'basicTitle': props.toChild.basicTitle, 'parentId': props.toChild.parentId, 'parentIndex': props.toChild.parentIndex}" @fromChild="fromChild"/>
        </div>

        <div class="absolute top-[35px] left-0 z-10">
            <PresetPopup v-if="popupId == 1 && categoryPopupOpen" :fromController="fromController" :toChild="{'tagPresetCollection': tagPresetCollection}" @fromChild="fromChild"/>
            <CategoryPopup v-if="popupId == 2 && categoryPopupOpen" :fromController="fromController" :toChild="{'tagPresetCollection': tagPresetCollection}" @fromChild="fromChild"/>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import contentBox from "./TagContent.vue";
import CategoryPopup from "./TagPopupCategory.vue"
import PresetPopup from "./TagPopupPreset.vue"

let props = defineProps(['fromParentTagString', 'dataForm', 'dataCommon', 'fromChild', 'toChild', 'fromController']);
let emit = defineEmits(['fromParentTagString', 'tagPopupOpen', 'fromChild', 'toChild']);

let categoryPopupOpen = ref(0);
let tagSelection = ref([]);
let tagPresetCollection = ref([]);
let tagSelectionListGroup = ref([]);
let tagSelectionListString = ref([]);
let tagPresetStringCollection = ref({});
let tagCollection = ref([]);
let popupId = ref(0);
let keyid = ref(1);
let fromController = ref('');

//? emit tag data to TagContent.vue
function fromChild(data) {

    console.log(data);

    if (data.presetPopupOpen == 1) categoryPopupOpen.value = !categoryPopupOpen.value;

        // console.log(data);

    if (data?.tagPresetGroupDeleteIndex >= 0) {
        Inertia.post('preset_delete', {'tagPresetGroupDeleteIndex': tagPresetCollection.value[data.tagPresetGroupDeleteIndex][0], 'tagPresetGroupDeleteSubindex': data.tagPresetGroupDeleteSubindex});
    }

    if (data?.tagPresetDelete >= 0) {
        Inertia.post('preset_delete', {'tagPresetDelete': tagPresetCollection.value[data.tagPresetDelete][0]});
    }

    if (data?.tagPresetRenameNew) {
        console.log(data);
        console.log(tagPresetCollection.value[data.index][0]);

        Inertia.post('preset_update', {'tagPresetRenameNew': data.tagPresetRenameNew, 'tagPresetRenameOld': tagPresetCollection.value[data.index][0]});

        // tagPresetCollection.value[data.index][0] = data.tagPresetRenameNew;

    }

    // add selected tag preset in tag list
    if (typeof data?.tagSelectionPreset !== 'undefined') {
        console.log('ok');
        // console.log(data.tagSelectionPreset);
        tagSelection.value = tagPresetCollection.value[data.tagSelectionPreset][1];
        keyid.value++;
        console.log('ok');
        Inertia.post('preset_store', tagSelection.value);
    }

    // console.log(data.presetData?.presetCreate);

    if (data.presetData?.presetCreate) {

        // console.log(data.presetData);
        // console.log(tagPresetCollection.value.includes(data.presetData.presetCreate));

        if (data.presetData?.presetCreate) {
            // check if preset group is not alreay crated and create it if so
            let tagPresetCheckDuplicate = [];
            tagPresetCollection.value.forEach(item => {
                tagPresetCheckDuplicate.push(item[0]);
                console.log(item);
            });

            // console.log(tagPresetCheckDuplicate.includes(data.presetData.presetCreate));
            if (!tagPresetCheckDuplicate.includes(data.presetData.presetCreate)) {
                tagPresetCollection.value.push([data.presetData.presetCreate])
                // Inertia.post('/preset_store', {'preset_name': data.presetData.presetCreate}, {replace: false,  preserveState: true, preserveScroll: true});
                // Inertia.post('titlecheck', {basicRefDate: form.basicRefDate, basicTitle: form.basicTitle, parentId:1},
                // {replace: false,  preserveState: true, preserveScroll: true});


            };
        }

        // tagPresetollection.value.push(['Preset']);

        // tagPresetGroupCollection.value[0] = [[tagPresetCollection.value[data.presetData.index][0],
        // tagPresetCollection.value[data.presetData.index][1][data.presetData.subIndex]]];

        // create additional preset name

        // else if (!tagPresetCollection.value[tagPresetCollection.value.length-1][1].find(element => element == data.presetData.presetCreate)) {
        //     tagPresetCollection.value[tagPresetCollection.value.length-1][1].push(data.presetData.presetCreate);
        //     tagPresetGroupCollection.value.push([[tagCollection.value[data.presetData.index][0],
        //     tagCollection.value[data.index][1][data.presetData.subIndex]]]);
        // };

        // emit('fromChild', {'tagPreset': tagPresetGroupCollection.value});
    }



    // console.log(data);

    if (data.presetData?.presetItemSelected) {
        // console.log('ok');
        // console.log(data);
        // console.log(tagCollection.value[data.index][0]);
        // tagPresetGroupCollection.value.push([[tagCollection.value[data.index][1][0], tagCollection.value[data.index][1][data.subIndex]]]);
        if (!tagPresetCollection.value[data.presetData.presetIndex][1]) tagPresetCollection.value[data.presetData.presetIndex][1] = [];
        tagPresetCollection.value[data.presetData.presetIndex][1].push([tagCollection.value[data.presetData.index][0],
        tagCollection.value[data.presetData.index][1][data.presetData.subIndex]]);









        Inertia.visit('/preset_store', {
  method: 'post',
  data: {'preset_group': {'preset_name': tagPresetCollection.value[data.presetData.presetIndex][0], 'tag_category': tagCollection.value[data.presetData.index][0], 'tag_context': tagCollection.value[data.presetData.index][1][data.presetData.subIndex]}},
  replace: false,
  preserveState: true,
  preserveScroll: true,
  only: [],
  headers: {},
  errorBag: null,
  forceFormData: false,
  onCancelToken: cancelToken => {},
  onCancel: () => {},
  onBefore: visit => {},
  onStart: visit => {},
  onProgress: progress => {},
  onSuccess: page => {},
  onError: errors => {},
  onFinish: visit => {},
})










        // emit('fromChild', {'tagPreset': tagPresetGroupCollection.value});
        // console.log(tagPresetGroupCollection.value);
    }

    // save preset name in tagPresetGroupCollection



    // console.log(data.tagPreset);
    // console.log(data.tagSelectionContext);

    // if () {

    // }

    if (data.tagPreset) {

        console.log(data.tagPreset);
        emit('fromChild', {'tagPreset': data.tagPreset})
    };

    // if (data.tagSelectionCategory == 'Preset') {
    //     console.log('ok');
    //     tagSelection.value = [data.tagSelectionCategory, data.tagSelectionContext];
    // }

    // else if (data.tagSelectionContext == 'new') tagSelection.value = [data.tagSelectionCategory, ''];

    if (typeof data.tagSelectionCategory !== 'undefined') {
        tagSelection.value = [[data.tagSelectionCategory, data.tagSelectionContext]]
        keyid.value++;
    };
    // console.log(tagSelection.value);
    // console.log(data.tagSelectionList);
    if (data.tagSelectionListGroup) tagSelectionListGroup.value = data.tagSelectionListGroup;

    // if (typeof data.tagSelectionList != 'undefined') {

    //     tagSelectionList.value = data.tagSelectionList;
    //     console.log(tagSelectionList.value);
    // }

    // console.log(data.tagPreset);
}

// save submit back to source
// function emitData() {
//     emit('dataChild', {'tagSelectionList': tagSelectionList.value});
// };

let tagCollectionInputFormat = ref();
// let tagCollectionGroupFormat = ref();

onMounted(() => {
    // console.log(props.toChild);
    if (typeof props.toChild.tagSelectionListString !== 'undefined') {
        // console.log(props.fromParentTagString);
        // tagCollectionInputFormat.value = props.toChild;
        // console.log('ok');
        tagSelectionListString.value = props.toChild.tagSelectionListString;
        // console.log(tagSelectionList.value);
    }
    tagCollection.value = props.fromController.tagCollection;

    if (props?.fromController) {
        // console.log('ok');
        fromController.value = props.fromController;
    }

    // console.log();
    if (props.fromController?.tagPresetCollection) {
        // console.log('ok');
        tagPresetCollection.value = props.fromController.tagPresetCollection;
    }
});

//transcript tag select to tag input format
function saveTagPopup() {

    tagCollectionInputFormat.value = '';
    tagSelectionListGroup.value.forEach(createTagInputGroup);

    function createTagInputGroup(item, index1) {

        item.forEach(createTagInputString);

        function createTagInputString(item2, index2) {

            if (item2 != null) {
                let item2Trimmed = item2.toString().trim();

                switch (index2) {
                    case 0:
                        tagCollectionInputFormat.value += '@'+item2Trimmed;
                        break;

                    case 3:
                        tagCollectionInputFormat.value+= '('+item2Trimmed+')';
                        break;

                    default:
                        if (item2Trimmed) tagCollectionInputFormat.value += ':'+item2Trimmed;
                }
            }
        }
        // no space at the end when reaching last entry
        if (index1 != tagSelectionListGroup.value.length-1) tagCollectionInputFormat.value  += ' ';
    }
        // console.log(tagCollectionInputFormat.value);
        emit('fromChild', {'tagSelectionListString': tagCollectionInputFormat.value, 'tagSelectionListGroup': tagSelectionListGroup.value});
    }

function cancelTagPopup() {
    // console.log('ok');
    emit('fromChild', {'tagSelectionListString': 'cancel', 'tagSelectionListGroup': 'cancel'});
}

// function newTag() {
//     tagSelection.value = ['', ''];
// }

watch(() => props.fromController, (curr, prev) => {
    // console.log('ok');
    // console.log(props.fromController);
    if (props?.fromController) {
        console.log('ok');
        //! reduce to one please
        fromController.value = props.fromController;
        tagPresetCollection.value = props.fromController.tagPresetCollection;
    };
}, {deep: true}, 500);

function tagPresetPopupFunction() {
    Inertia.post('tag', {'parentId': fromController.value.misc.parentId, 'parentIndex':fromController.value.misc.parentIndex});

    categoryPopupOpen.value = !categoryPopupOpen.value;
    popupId.value = 1;
}

function categoryPopupActive() {

    if (props.fromController.tagCollection.length > 0) {
        // console.log('ok');
        categoryPopupOpen.value = !categoryPopupOpen.value;
        popupId.value = 2;
    } else {
        tagSelection.value = [['', '']];
        keyid.value++;
    }

}

</script>

