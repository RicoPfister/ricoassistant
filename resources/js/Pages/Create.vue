
<template>
<Header>

<!-- form container -->
<form aria-label="New Entry Container" class="absolute mb-10">

    <!-- content container -->
    <div class="lg:w-[755px] mt-10">

        <TabBar />

        <div class="relative w-full min-w-0 border-2 border-gray-500 flex flex-col flex-nowrap shadow-xl max-h-[calc(100vh-250px)]">

            <div ref="scrollArea" class="gap-y-2 flex flex-col grow overflow-y-scroll shadow-inner bg-stone-100 px-5 py-3">

                <!-- component generator -->

                <div v-for="(item, index) in componentCollection" :key="componentCollectionUpdate+index">
                    <component :is="componentSource[item]" :data-common="props.dataCommon" @data-child="dataChild" :data-parent="dataParent" :data-form="form" :component-id="index-1"/>
                </div>

                <div v-if="componentCollection[0] != FormManager" class="mt-2">
                    <Footer @data-child="dataChild"/>
                </div>

            </div>

        </div>
    </div>

</form>

</Header>
</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, markRaw, shallowRef, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import Header from "../Layouts/MainNav.vue";
import Statement from "../Components/Create/Statement.vue";
import Activity from "../Components/Create/Activity.vue";
import Basic from "../Components/Create/Basic.vue";
import Administration from "../Components/Create/Administration.vue";
import Guidance from "../Components/Create/Guidance.vue";
import Source from "../Components/Create/Source.vue";
import TabBar from "../Components/TabManager/TabBar.vue";
import Footer from "../Components/Create/Footer.vue";
import Tag from "../Components/TagManager/TagForm.vue";
import Reference from "../Components/Create/Reference.vue";
import FormManager from "../Components/FormManager/FormPopup.vue";

let props = defineProps(['dataChild', 'basicResult', 'dataCommon']);
let emit = defineEmits(['dataParent', 'dataForm']);

let form = ref({});
let dataParent = ref({});

const componentSource = [FormManager, Basic, Tag, Reference, Statement, Activity, Guidance, Administration, Source];
let componentCollection = [0];
let componentCollectionUpdate = ref(0);
let scrollArea = ref();

// process received child data
function dataChild(data) {

    // console.log(data);

    // scroll to top
    if (data.scrollToTop) {
        scrollArea.value.scrollTo({top: 0, behavior: 'smooth'})
    };

    // add form data to form collection
    if (data.formData) {
        form.value = {...form.value, ...data.formData}
    };

    // rebuild form based on deleted sections
    if (data.deleteSections) {

        componentCollection.splice(0, componentCollection.length);
        componentCollection.push(0);

        dataParent.value.sectionSelected.splice(0, dataParent.value.sectionSelected.length);

        form.value = ({});
        componentCollectionUpdate.value = !componentCollectionUpdate.value;
    };

    // store form
    if (data.submit == 1) {
        Inertia.post('store', form.value);
    };

    // build form based on selected component
    if (data.componentSelected) {

        // reset collection
        componentCollection.splice(0, 1, 1);
        dataParent.value['sectionSelected'] = [];

        for (const [key, value] of Object.entries(data.componentSelected)) {
            componentCollection.push(parseInt(key)+4);
            dataParent.value['sectionSelected'][key] = 1;

            // console.log(key);

            // add tag collection
            // if(parseInt(key)+4 != 8) componentCollection.push(2);
        }

        // add reference section
        componentCollection.push(3);

        //? v-for trigger
        componentCollectionUpdate.value = !componentCollectionUpdate.value;
    };

    // build collection: form manager
    if (data.formDataEdit) {

        if (data.formDataEdit == 1) {
            componentCollection.splice(0, componentCollection.length, 0);
        };

        componentCollectionUpdate.value = !componentCollectionUpdate.value;
    }

    if (data.delete) {
        // alert(data.delete);
        componentCollection.splice(data.delete, 1);
        componentCollectionUpdate.value = !componentCollectionUpdate.value;
    }
}

// basic title response
watch(() => props.basicResult, _.debounce( (curr, prev) => {

    dataParent.value.basicTitleData = props.basicResult;

    if (props.basicResult[0].warning == 2) {
        dataParent.value.basicTitelPickerOpen = 1;
    } else {
        dataParent.value.basicTitelPickerOpen = 0;
    }

}, 500));

watch(() => form, (curr, prev) => {
    // alert('form');
    emit('dataForm', {'dataForm': form});
}, {deep: true}, 500);


// const headcount = computed(() => {

// })

onMounted(() => {

})

</script>

