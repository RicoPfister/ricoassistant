<template>

<!-- container -->
<div class="bg-white h-full w-full flex flex-col">

    <!-- ??? -->
    <div class="relative border-r border-gray-400 h-full">

        <!-- header -->
        <div class="flex flex-row border-b border-gray-400 justify-between">

            <button @click="categoryPopupOpen = !categoryPopupOpen" class="w-[200px] px-2 bg-gray-200 h-[34px] border-r border-gray-400" type="button">
                <div class="flex flex-row items-center justify-between">

                    <div class="flex flex-row">
                        <!-- info button -->
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </div>

                        <div class="ml-1">Add Tag</div>
                    </div>

                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </button>

            <button @click="categoryPopupOpen = !categoryPopupOpen" class="w-fit px-2 bg-gray-200 h-[34px] border-r border-gray-400" type="button">
                <div class="flex flex-row items-center justify-between">

                    <div class="flex flex-row">
                        <!-- info button -->
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <div class="ml-1">Create Tag</div>
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
                <button @click="$emit('tagPopupOpen')" class="px-2 bg-gray-200 h-[34px] flex items-center border-l border-r border-gray-400" type="button">
                    <div class="flex flex-row items-center">
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>Cancel</div>
                    </div>
                </button>

                <button @click="emitParent" class="px-2 bg-gray-200 h-[34px] flex items-center" type="button">
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
        <div class="overflow-y-scroll h-[calc(100%-35px)]">
            <contentBox :toChild="props.toChild" :dataParent="tagContentList" :data-form="props.dataForm" @data-child="dataChild"/>
        </div>

        <div class="absolute top-[35px] left-0">
            <CategoryPopup v-if="categoryPopupOpen" :fromController="props.fromController" @dataChild="dataChild"/>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import contentBox from "./TagContent.vue";
import CategoryPopup from "./TagPopupCategory.vue"

let props = defineProps(['dataChild', 'fromParentTagString', 'dataForm', 'dataCommon', 'fromChild', 'toChild']);
let emit = defineEmits(['fromParentTagString', 'dataChild', 'tagPopupOpen', 'fromChild', 'toChild']);

let categoryPopupOpen = ref(0);
let tagContentList = ref();
let tagCollection = ref();

//? emit tag data to TagContent.vue
function dataChild(data) {
    // console.log(data);
    if (data.tagSelect) tagContentList.value = data.tagSelect;
    if (data.tagCollection) tagCollection.value = data.tagCollection;
}

// save submit back to source
// function emitData() {
//     emit('dataChild', {'tagCollection': tagCollection.value});
// };

let tagCollectionInputFormat = ref();

onMounted(() => {
    if (props.toChild) {
        // console.log(props.fromParentTagString);
        tagCollectionInputFormat.value = props.toChild;
    }
  })

//   transcript tag select to tag input format

function emitParent() {

    tagCollectionInputFormat.value = '';
    tagCollection.value.forEach(createTagInputGroup);

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
        if (index1 != tagCollection.value.length-1) tagCollectionInputFormat.value  += ' ';
    }
        console.log(tagCollectionInputFormat.value);
        emit('fromChild', {'tagCollection': tagCollectionInputFormat.value});
    }

</script>

