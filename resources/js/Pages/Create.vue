
<template>
<Header>

<!-- form container -->
<form aria-label="New Entry Container"  class="absolute mb-10 min-w-0">

    <!-- content container -->
    <div class="lg:w-[755px] mt-10">

        <TabBar />

        <div class="w-full min-w-0 border-2 border-black flex flex-col">

            <div class="p-4 gap-y-4 flex flex-col bg-gray-100">

                <!-- component generator -->
                <div v-for="(item, index) in componentCollection">
                    <Component :is="componentSource[componentCollection[index]]" @data-child="dataChild" :data-parent="dataParent"/>
                </div>

            </div>
        </div>

        <Footer @data-child="dataChild"/>

    </div>

</form>

</Header>
</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, shallowRef, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import Header from "../Layouts/MainNav.vue";
import Choose from "../Components/Create/Choose.vue";
import Statement from "../Components/Create/Statement.vue";
import Basic from "../Components/Create/Basic.vue";
import Administration from "../Components/Create/Administration.vue";
import TabBar from "../Components/TabManager/TabBar.vue";
import Footer from "../Components/Create/Footer.vue";

let props = defineProps(['dataChild', 'basicResult']);
let emit = defineEmits(['dataParent']);

let form = ref({});
let dataParent = ref({});

const componentSource = [Choose, Basic, Statement];
let componentCollection = ref([0]);

// analyse received child data
function dataChild(data) {

    // console.log(form.value);

    if (data['formComponent'] == 0) {
        componentCollection.value = [1, 2];
    };

    if (data['formData']) {
        form.value = {...form.value, ...data.formData}
    }

    // sendform
    if (data.submit == 1) {
        Inertia.post('store', form.value);
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

</script>

