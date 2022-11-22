
<template>
<Header>

<!-- form container -->
<form aria-label="New Entry Container" class="absolute mb-10">

    <!-- content container -->
    <div class="lg:w-[755px] mt-10">

        <TabBar />

        <div class="relative w-full min-w-0 border-2 border-gray-500 flex flex-col flex-nowrap shadow-xl max-h-[calc(100vh-250px)]">

            <div class="gap-y-2 flex flex-col grow overflow-y-scroll shadow-inner bg-stone-100 px-5 py-3">

                <!-- component generator -->

                <div v-for="(item, index) in componentCollection" class="">
                    <component :is="componentSource[componentCollection[index]]" @data-child="dataChild" :data-parent="dataParent" :data-form="form"/>
                </div>

                <div v-if="componentCollection[0] != 0" class="mt-2">
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
import { ref, shallowRef, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
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

let props = defineProps(['dataChild', 'basicResult']);
let emit = defineEmits(['dataParent', 'dataForm']);

let form = ref({});
let dataParent = ref({});

const componentSource = [FormManager, Basic, Tag, Reference, Statement, Activity, Guidance, Administration, Source];
let componentCollection = ref([0]);

// analyse received child data
function dataChild(data) {

    // console.log(form.value);

    if (data['formComponent'] == 0) {
        componentCollection.value = [1, 2, 3, 4];
    };

    if (data['formData']) {
        form.value = {...form.value, ...data.formData}
    };

    // sendform
    if (data.submit == 1) {
        Inertia.post('store', form.value);
    };

    if (data.componentSelected) {

        console.log(data.componentSelected);

        componentCollection.value = [1];

        for (const [key, value] of Object.entries(data.componentSelected)) {
        componentCollection.value.push(parseInt(key)+4);
        }
        componentCollection.value.push(2);
        componentCollection.value.push(3);
    };

    if (data.formDataEdit) {

        if (data.formDataEdit == 1) {

            // alert(data.formDataEdit);

            emit('dataParent' , 'test123');
            componentCollection.value = [0]};

        if (data.formDataEdit == 2) componentCollection.value.splice(1,1);
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
emit('dataForm', form);

}, {deep: true}, 500);

</script>

