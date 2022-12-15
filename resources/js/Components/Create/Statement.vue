
<template>

<div>
    <div class="flex flex-col">
        <div class="flex flex-row justify-between items-center" type="button">
            <MenuEntry @data-child="dataChildMenuEntry"/>
        </div>
        <textarea @change="InputData" class="border border-black outline-0 focus:border-black focus:ring-0" rows="10" id="statement" type="text" v-model="form.statement"></textarea>
    </div>
</div>

<TagForm :from-parent="'titleNo'" />

<div class="border-l border-r border-b border-black h-[31px]">
    <ReferenceStatement :fromController="typeof props.fromController !== 'undefined' ? props.fromController : ''" :toChild="{'parentId': 2, 'parentIndex': 0}" :transferCreate="props.transferCreate" :transfer="props.toChild.parentId == 5 ? props.toChild : ''" @fromChild="fromChild" />
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagForm from "../TagManager/TagForm.vue";
import ReferenceStatement from "./Reference.vue";

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'componentId', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'transfer', 'toChild', 'fromChild', 'transferCreate']);
let emit = defineEmits(['dataChild', 'dataCommon', 'dataToParent', 'toParent', 'fromChildRow', 'toChild', 'fromChild', 'transferCreate']);

// let statement = ref();
let form = useForm({
    statement:'',
});

// send changes to parent
//-----------------------------------------

// send to parent: statement input data
function InputData() {
    // console.log('ok');
    emit('fromChild', {'section':'statementData', 'subSection': 'statement', 'form': form.statement});
}

// send to parent: reference selection
function fromChild(data) {
    emit('fromChild', {'section':'statementData', 'subSection':'reference', 'index': 0, 'form': data.reference.reference});
}

//  send to parent: edit menu selection
function dataChildMenuEntry(n) {
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

</script>

