
<template>

<div>
    <div class="flex flex-col">

        <div class="flex flex-row justify-between items-center" type="button">

            <label class="" aria-label="Statement Input" for="statement">Statement*: </label>

            <MenuEntry @data-child="dataChildMenuEntry"/>

        </div>

        <textarea class="border border-black outline-0 focus:border-black focus:ring-0" v-model="dataChild['statement']" rows="10" id="statement" type="text"></textarea>

    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";

let dataChild = ref({});

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'componentId']);
let emit = defineEmits(['dataChild']);

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

onMounted(() => {
    if (props.dataForm.statement) {
        // console.log(props.dataForm.statement);
        dataChild.value['statement'] = props.dataForm.statement;
    }
  })

</script>

