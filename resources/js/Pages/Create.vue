
<template>
<Header :toChild="{'page_id': 'Create', 'tagQuickFilterBarOpen': 1, 'fromController': props.fromController}">

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
                    :fromController="props.fromController"
                    :fromController2="usePage().props.value.flash.fromController"
                    :data-form="form"
                    :component-id="index-1"
                    @dataToParent="dataToParent"
                    :transferCreate="transferCreate"
                    @fromChild="fromChild"
                    :fromController_validation="props.fromController_validation"
                    />

                </div>

                <div v-if="componentCollection[0] != 0" class="mt-2">
                    <Footer :editCheck="editCheck" :blocking="form?.basicData?.blocking" @data-child="dataChild"/>
                </div>
            </div>
        </div>
    </div>
</form>

</Header>
</template>

<script setup>

import { useForm, usePage, Link, useRemember } from '@inertiajs/inertia-vue3';
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

let props = defineProps(['dataChild', 'basicResult', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'fromChild', 'transferCreate', 'edit', 'tag', 'testing', 'fromController2', 'fromController_validation']);
let emit = defineEmits(['dataParent', 'dataForm', 'dataCommon', 'dataChild', 'dataToParent','transferCreate', 'fromController2', 'fromController_validation', 'blocking']);

// variable collection
// -------------------------

let form = ref({});

// save validation errors

console.log('ok');

const form2 = useForm('key1', {'test': null});

watch(() => usePage().props.value.errors, (curr, prev) => {

        console.log('ok');

        if (Object.keys(usePage()?.props.value?.errors).length > 0) {

        console.log(usePage()?.props.value?.errors);

        form2['errors'] = usePage().props.value.errors;
    }
});

// console.log(form.value);

let editCheck = ref('');

let dataParent = ref({});

// const componentSource = [FormManager, Basic, Tag, Reference, Statement, Activity, Guidance, Source];
const componentSource = [FormManager, Basic, Tag, Reference, Statement, Activity, Source];
let componentCollection = [0];
let componentCollectionUpdate = ref(0);
let scrollArea = ref();

let activityTimeTotal = 0;
let activityTimeHourString = 0;
let activityTimeHourMinute = 0;
let activityTime = 0;
// let validationCheck = 0;

let testabc = ref('');
// let validationErrors = ref();

// function collection
// -------------------------

function activityTimeConvert(item, index) {

    // console.log(item, index);

    if (item >= 100) {
        activityTimeHourString = parseInt(item.toString().slice(0, -2));
        activityTimeHourMinute = parseInt(item.toString().slice(-2));
    } else {
        activityTimeHourMinute = item;
    }

        // console.log(item, index, activityTimeHourString, activityTimeHourMinute);

        activityTime = parseInt(activityTimeHourString ) * 60 + parseInt(activityTimeHourMinute);

        // console.log(activityTime);

        activityTime -= activityTimeTotal;

        // console.log(activityTime, activityTimeTotal);

        if (typeof form?.value?.activityData?.activityTime == 'undefined') form.value.activityData.activityTime = [];

        // console.log(activityTime);

        form.value.activityData.activityTime[index] = activityTime;

        activityTimeTotal += activityTime;
        if (index >= form.value.activityData.activityTo.length-1) activityTimeTotal = 0;

    };

// process received child data
function dataChild(data) {
    // console.log(data);

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

        // console.log(data);

        // convert activity timeTo to minutes
        if (form.value.activityData?.activityTo) {
            form.value.activityData.activityTime = [];

            // console.log(form.value.activityData.activityTo);

            form.value.activityData.activityTo.forEach((item, index) => activityTimeConvert(item, index));
        };

        // console.log(form.value);
        // console.log('ok');
        // Inertia.post('/store', form.value);

        // Validation.validation('basic', data);

        // console.log(Validation.validation('basic', data, form.value));
        // let validation_response = Validation.validation('basic', data, form.value);

        // console.log(validation_response);

        // send form to server
        Inertia.visit('store', {
        method: 'post',
        data: form.value,
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
    };

    if (data.update == 1) {

        // console.log(form.value.activityData.activityTo);
        if (form?.value?.activityData) {
            form.value.activityData.activityTo.forEach((item, index) => activityTimeConvert(item, index));
        }

        Inertia.post('update', form.value);
        // console.log(form.value);
    }

    if (data.deleteEntry == 1) {
        form.value.delete = 1;
        Inertia.post('delete', {'id': form.value.basicData.id});
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

function toParent(data) {
    // console.log('ok');
    // console.log(data);
    if (data.activityTo) {
        form.value['activityTo'] = data.activityTo;
    };
}

let transferCreate = ref({});

// process form data received from components
function fromChild(data) {

    console.log(data);
    // console.log(data.form?.statement);

    // if data not undefined and public false-true
    if (((data.form != 'undefined' || data.index_temp_undefined == undefined) && data.form != '' &&  data.form?.statement != '') || data.subSection == 'public'
    || data.subSection == 'medium' || data.subSection == 'title' || data.subSection == 'ref_date' || data.subSection == 'blocking') {

        console.log(data);

        if (!form.value[data.section]) form.value[data.section] = {};

        if (data?.index != undefined && data?.index_temp_undefined == undefined) {

            console.log('ok');

            if (!form.value[data.section][data.subSection]) form.value[data.section][data.subSection] = {};

            form.value[data.section][data.subSection][data.index]  = {};
            form.value[data.section][data.subSection][data.index] = data.form;
            // console.log(data);
            // console.log(form.value[data.section][data.subSection][data.index]);
        }

        // else if (data.form == '') {
        //     delete form.value[data.section]?.[data.subSection];
        // }

        else {
            console.log(data);

            // if (data.subSection == 'ref_date') {
            //     form.value[data.section][data.subSection] = data.form.slice(0,4)+data.form.slice(5,7)+data.form.slice(8,10);
            // }

            form.value[data.section][data.subSection] = data.form;
            }
    }

    else if (data.form?.statement == '' || (data.subSection == 'filelist' && data.form == '')) {

        console.log(data);

        if (data.subSection == 'filelist' && data.form == '') {

            console.log(data);
            form.value['sourceData']['filelist'] = [];
            form.value['sourceData']['files'] = [];
            form.value['sourceData']['previewlist'] = [];
        }

        else delete form.value[data.section][data.subSection];
    }

    else if (form?.value?.[data.section]?.[data.subSection]){

        console.log(data);

        // delete array key
        if(data.subSection == 'tag') {
            console.log(data);
            form.value[data.section][data.subSection].splice(data.index, 1);
        }

        // console.log(form.value[data.section][data.subSection]);

        // do not delete key, set value to 0
        else {
            delete form.value[data.section]?.[data.subSection][data.index];
        }


        // delete key and value

        // console.log('ok');
        // delete form.value[data.section][data.subSection][data.index];
        // console.log(data.index);


        // if (data.subSection == 'public') {

        // }
    }

    // auto basic title set
    transferCreate.value['title'] = form.value?.basicData?.title;

    // recheck validation
    if (data.index == undefined) {

        console.log('ok');

        if (data.subSection == 'activityTo') {

            if (data.delete) {
                // console.log(parseInt(data.delete)-1);
                let $delete_index = parseInt(data.delete)-1;
                // console.log(form2.errors['activityData.activityTo.'+ data.delete-1]);
                console.log(form2.errors);

                delete form2.errors['activityData.activityTo.' + $delete_index];
                console.log(form2.errors);
                delete form2.errors['activityData.reference_parents.' + $delete_index];
            }

            else {

                console.log('ok');

                data.form.forEach((item, index) => {
                    if (item > 0) {
                        delete form2.errors[data.section + '.' + data.subSection]
                        delete form2.errors[data.section + '.' + data.subSection + '.' + index]
                    };
                });
            }
        }

        else if (data.subSection == 'filelist') {

            console.log('ok');
            // data.form.forEach((item, index) => {
            //     console.log(index);
            //     if (item.type != undefined) delete form2.errors[data.section + '.' + data.subSection + '.' + index + '.type'];
            // });
            delete form2.errors[data.section + '.' + data.subSection]
            delete form2.errors[data.section + '.' + data.subSection + '.' + data.change + '.type']
        }

        else {

            console.log('ok');

            delete form2.errors[data.section + '.' + data.subSection];
        }
    }

    else {
            console.log('ok');

            delete form2.errors[data.section + '.' + data.subSection];
            delete form2.errors[data.section + '.' + data.subSection + '.' + data.index];
    }
}

onMounted(() => {
//    console.log(props.edit);

   if (props?.edit) {

        console.log('ok');
        form.value['componentCollection'] = [];

        componentCollection.splice(0, componentCollection.length);
        componentCollection.push(1);
        form.value['componentCollection'].push(1);

        if (props?.edit?.statementData) {
            componentCollection.push(4);
        };

        if (props?.edit?.activityData) {
            componentCollection.push(5)
        };

        if (props?.edit?.sourceData) {
            componentCollection.push(6);
         }

        form.value = props.edit;
        form.value['componentCollection'] = componentCollection;

        editCheck.value = 1;
        componentCollectionUpdate.value = !componentCollectionUpdate.value;
    }
});

// const form123 = useRemember({
//     validationErrors: null,
// })

// watch(() => usePage().props.value.errors, (curr, prev) => {


// if (Object.keys(usePage()?.props.value?.errors).length) {

//         form2['errors'] = usePage().props.value.errors;
// }

// });

// watch(() => form?.value?.activityData?.activityTo, (curr, prev) => {

//     console.log('ok');
//     delete form2.errors[data.section + '.' + data.subSection + '.' + data.index];
// }, {deep: true});


</script>
