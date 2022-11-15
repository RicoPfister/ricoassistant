
<template>
<Header>

<!-- form container -->
<form aria-label="New Entry Container"  class="absolute mb-10 min-w-0">

    <!-- content container -->
    <div class="lg:w-[755px]">

        <h1 class="text-xl font-bold">New Entry</h1>

        <div class="bg-gray-100 p-3 w-full min-w-0 border border-gray-300 shadow-xl mt-3 flex flex-col">

        <!-- component generator -->
        <div v-for="(item, index) in 1">
            <Component :is="componentCollection[componentSet]" @data-child="dataChild" :data-parent="dataParent"/>
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
import Choose from "../Components/Create/Choose.vue";
import Statement from "../Components/Create/Statement.vue";
import Basic from "../Components/Create/Basic.vue";

let props = defineProps(['dataChild', 'basicResult']);
let emit = defineEmits(['dataParent']);

let form = ref({});
let dataParent = ref({});

const componentCollection = [Choose, Statement, Basic];
let componentSet = ref(0);

function dataChild(data) {

    if (data['formComponent'] == 0) {
        componentSet.value = 2;
    };

    if (data['formData']) {
        form.value = {...data.formData, ...form.value}
        // console.log(form.value);
    }
}

// basic title response
watch(() => props.basicResult, _.debounce( (curr, prev) => {

    dataParent.value.basicTitleData = props.basicResult;

    if (props.basicResult[0].warning == 2) {
        // cl('ok');
        dataParent.value.basicTitelPickerOpen = 1;
    } else {
        dataParent.value.basicTitelPickerOpen = 0;
    }

}, 500));

// testing
// **************************************************

function cl(log) {
    // alert(log)
    if (typeof log == 'undefined') console.log('Testlog');
    else console.log('Testlog: ' + log);
}

function keyPress(event) {
    if (event.ctrlKey && event.altKey && event.key === 'a') {
        console.log('Testlog: ' + log);
        };
}

</script>

