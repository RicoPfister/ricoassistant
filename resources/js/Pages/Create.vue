
<template>
<Header>

<!-- form container -->
<form aria-label="New Entry Container" class="absolute mb-10">

    <!-- content container -->
    <div class="lg:w-[780px] mt-10">

        <TabBar />

        <div class="relative w-full min-w-0 border-2 border-gray-500 flex flex-col flex-nowrap shadow-xl max-h-[calc(100vh-250px)]">

            <div ref="scrollArea" class="gap-y-2 flex flex-col grow overflow-y-scroll shadow-inner bg-stone-100 px-3 pb-3 pt-2">

                <!-- component generator -->

                <div v-for="(item, index) in componentCollection" :key="componentCollectionUpdate+index" class="">
                    <component @data-child="dataChild" :is="componentSource[item]" :data-parent="dataParent" @to-parent="toParent" :toChild="form"
                    :fromController="props.fromController" :data-form="form" :component-id="index-1" @dataToParent="dataToParent" :transferCreate="transferCreate" @fromChild="fromChild"/>
                </div>

                <div v-if="componentCollection[0] != FormManager" class="mt-2">
                    <Footer :editCheck="editCheck" @data-child="dataChild"/>
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

let props = defineProps(['dataChild', 'basicResult', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'fromChild', 'transferCreate', 'edit', 'tag', 'testing']);
let emit = defineEmits(['dataParent', 'dataForm', 'dataCommon', 'dataChild', 'dataToParent','transferCreate']);

// variable collection
// -------------------------

let form = ref({});
let editCheck = ref('');

let dataParent = ref({});

const componentSource = [FormManager, Basic, Tag, Reference, Statement, Activity, Guidance, Source];
let componentCollection = [0];
let componentCollectionUpdate = ref(0);
let scrollArea = ref();

let activityTimeTotal = 0;
let activityTimeHourString = 0;
let activityTimeHourMinute = 0;
let activityTime = 0;

// function collection
// -------------------------

function activityTimeConvert(item, index) {

    // console.log(item, index);


        activityTimeHourString = item.toString().slice(0, -2);
        activityTimeHourMinute = item.toString().slice(-2);

        activityTime = parseInt(activityTimeHourString )*60+parseInt(activityTimeHourMinute);

        console.log(activityTime);

        activityTime -= activityTimeTotal;

        console.log(activityTime);

        if (typeof form?.value?.activityData?.activityTime == 'undefined') form.value.activityData.activityTime = [];

        console.log(activityTime);

        form.value.activityData.activityTime[index] = activityTime;

        activityTimeTotal += activityTime;

    };

// process received child data
function dataChild(data) {
    // console.log('ok');

    // scroll to top
    if (data.scrollToTop) {
        scrollArea.value.scrollTo({top: 0, behavior: 'smooth'})
    };

    // add form data to form collection
//obsolete. clear and remove.
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

        form.value['componentCollection'] = componentCollection;
    };

    //? store form
    //------------------------------------------------
    if (data.submit == 1) {

        // convert activity timeTo to minutes
        if (form.value.activityData?.activityTo) {
            form.value.activityData.activityTime = [];

            console.log(form.value.activityData.activityTo);



            form.value.activityData.activityTo.forEach((item, index) => activityTimeConvert(item, index));


        };

        console.log(form.value);
        console.log('ok');
        Inertia.post('store', form.value);
        console.log('ok');
    };

    if (data.update == 1) {

        // let formIndex = Object.keys(form.value);

        // formIndex.forEach(element => formIndexFunction(element))

        // function formIndexFunction(item) {
        //     console.log(item);
        //     if (!Object.hasOwn(formBeforeUpdate, item)) formToUpdate[item] = form.value[item];

        //     let formIndexIndex = Object.keys(form.value[item]);
        //     console.log(formIndexIndex);
        // }

        // let formBeforeUpdate = {};
        // let formToUpdate = {};
        // let formToDelete = {};

        // form.value
        // formBeforeUpdate
        // formToUpdate
        // formToDelete

        // console.log(form.value.activityData.activityTo);
        form.value.activityData.activityTo.forEach((item, index) => activityTimeConvert(item, index));



        Inertia.post('update', form.value);
        // console.log(form.value);
    }

    if (data.deleteEntry == 1) {
        Inertia.post('update', {'delete': 'deleteEntry_@HuZ-345-pLk'});
    }

    // build form based on selected component
    if (data.componentSelected) {

        // reset collection
        componentCollection.splice(0, 1, 1);
        dataParent.value['sectionSelected'] = [];

        for (const [key, value] of Object.entries(data.componentSelected)) {
            componentCollection.push(parseInt(key)+4);
            dataParent.value['sectionSelected'][key] = 1;
        }

        // add reference section
        // componentCollection.push(3);

        //? v-for trigger
        componentCollectionUpdate.value = !componentCollectionUpdate.value;
        form.value['componentCollection'] = componentCollection;
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

    form.value['componentCollection'] = componentCollection;
}

// basic title response
// watch(() => props.basicResult, _.debounce( (curr, prev) => {

//     dataParent.value.basicTitleData = props.basicResult;

//     // console.log(props.basicResult);

//     if (props.basicResult[0].warning == 2) {
//         dataParent.value.basicTitelPickerOpen = 1;
//     } else {
//         dataParent.value.basicTitelPickerOpen = 0;
//     }

// }, {'deep': true}, 500));

// // listen to form changes and emit them
// watch(() => form, (curr, prev) => {
//     emit('dataForm', {'dataForm': form});
// }, {deep: true}, 500);

// process component data
function dataToParent() {
    // if (data.tagSource) {
    // }
}

function toParent(data) {
    // console.log('ok');
    // console.log(data);
    if (data.activityTo) {
        form.value['activityTo'] = data.activityTo;
    };

    // if (data.activityReference) {
    //     form.value['activityReference'] = data.activityReference;
    // };

    // if (data.referenceReference) {
    //     form.value['referenceReference'] = data.referenceReference;
    // };

    // if (data.activityTag) {
    //     form.value['tagData']['activityTag'] = [];
    //     form.value['tagData']['activityTag'] = data.activityTag;
    // };

    // if (data.sourceTag) {
    //     form.value['tagData']['sourceTag'] = [];
    //     form.value['tagData']['sourceTag'] = data.sourceTag;
    // };
}

let transferCreate = ref({});

// process form data received from components
function fromChild(data) {
    if (data.form != 'undefined') {
        if (!form.value[data.section]) form.value[data.section] = {};
        if (typeof data.index !== 'undefined') {
            if (!form.value[data.section][data.subSection]) form.value[data.section][data.subSection] = {};
            form.value[data.section][data.subSection][data.index]  = {};
            form.value[data.section][data.subSection][data.index] = data.form;
            // console.log(data);
            // console.log(form.value[data.section][data.subSection][data.index]);
        } else {
            // console.log(data);
            form.value[data.section][data.subSection]= data.form;
        }
    }

    // if (data.tagPresetItemSelected) {
    //     if (!form.value[data.section]) form.value[data.section] = {};
    //     if (typeof data.index !== 'undefined') {
    //         if (!form.value[data.section][data.subSection]) form.value[data.section][data.subSection] = {};
    //         form.value[data.section][data.subSection][data.index]  = {};
    //         form.value[data.section][data.subSection][data.index] = data.form;
    //     } else {
    //         form.value[data.section][data.subSection]= data.form;
    //     }
    // }

    // if (data.presetCreate) {
    //     if (!form.value[data.section]) form.value[data.section] = {};
    //     if (typeof data.index !== 'undefined') {
    //         if (!form.value[data.section][data.subSection]) form.value[data.section][data.subSection] = {};
    //         form.value[data.section][data.subSection][data.index]  = {};
    //         form.value[data.section][data.subSection][data.index] = data.form;
    //     } else {
    //         form.value[data.section][data.subSection]= data.form;
    //     }
    // }

    transferCreate.value['title'] = form.value.basicData.title;
}

// watch(() => props.fromController, (curr, prev) => {
//     if (props?.fromController?.database) {
//         console.log('ok');
//         Inertia.post('tag');
//     };
// }, {deep: true}, 500);
// let form_transfer = ref();
onMounted(() => {
//    console.log(props.edit);

   if (props?.edit) {

        // console.log(props.edit.activityData.reference[0]);

        componentCollection.splice(0, componentCollection.length);
        componentCollection.push(1);
        if (props?.edit?.statementData) componentCollection.push(4);
        if (props?.edit?.activityData) componentCollection.push(5);
        if (props?.edit?.sourceData) componentCollection.push(7);

        // form_transfer = props.edit;
        // console.log(form_transfer);
        // form_transfer.value = props.edit;
        // form.value = '';
        // console.log(form.value);
        // formBeforeUpdate = props.edit;
        // console.log(formBeforeUpdate);
        form.value = props.edit;
        // console.log(form.value);
        // form.value.statementData.tag = props.tag[0];
        // form_transfer = props.edit;
        // console.log(form_transfer);
        editCheck.value = 1;
        componentCollectionUpdate.value = !componentCollectionUpdate.value;
    }

    // if (props?.tag) {
    //     form.value.statementData.tag = props.tag[0];
    // }
});

</script>
