
<template>

<div>
    <div class="flex flex-col">
        <div class="flex flex-row justify-between items-center" type="button">
            <MenuEntry @data-child="dataChildMenuEntry"/>
        </div>
        <textarea class="border border-black outline-0 focus:border-black focus:ring-0" v-model="dataChild['statement']" rows="10" id="statement" type="text"></textarea>
    </div>
</div>
<TagForm :from-parent="'titleNo'" />

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagForm from "../TagManager/TagForm.vue";

let dataChild = ref({});

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'componentId', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'transfer', 'toChild']);
let emit = defineEmits(['dataChild', 'dataCommon', 'dataToParent', 'toParent']);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

function dataChildMenuEntry(n) {
    // alert(n['formDataEdit']);
    // alert(props.componentId);
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

// watch(() => props.dataForm, _.debounce( (curr, prev) => {

// console.log(props.dataForm.statement);

// }, 500));

// console.log(typeof props.dataForm.statement);

onMounted(() => {
    if (typeof props.dataForm.statement != 'undefined') {
        dataChild.value['statement'] = props.dataForm.statement;
    }
})



</script>

