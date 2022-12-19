
<template>

<div>
    <div class="flex flex-col">
        <div class="flex flex-row justify-between items-center" type="button">
            <MenuEntry @data-child="dataChildMenuEntry"/>
        </div>
        <textarea @change="InputData" class="border border-black outline-0 focus:border-black focus:ring-0" rows="10" id="statement" type="text" v-model="form.statement"></textarea>
    </div>
</div>

<div class="border-l border-r border-b border-black">
    <TagForm :toChild="{'parentId': 2, 'parentIndex': 0}" :fromController="props.fromController" @fromChild="fromChild"/>
</div>

<div class="border-l border-r border-b border-black h-[31px]">
    <Reference :fromController="typeof props.fromController !== 'undefined' ? props.fromController : ''" :toChild="{'parentId': 2, 'parentIndex': 0}" :transferCreate="props.transferCreate" :transfer="props.toChild.parentId == 5 ? props.toChild : ''" @fromChild="fromChild"/>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagForm from "../TagManager/TagForm.vue";
import Reference from "./Reference.vue";

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

// send to parent: reference selection OR tag list
function fromChild(data) {
    if (data.component == 'reference' && data.parentId == 2) {
        emit('fromChild', {'section':'statementData', 'subSection':'reference', 'index': 0, 'form': data.reference.reference});
    }

    if (data.component == 'tag' && data.parentId == 2) {
        // console.log('ok');
        emit('fromChild', {'section':'statementData', 'subSection':'tag', 'index': data.parentIndex, 'form': data.tagList});
    }
}

//  send to parent: edit menu selection
function dataChildMenuEntry(n) {
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

// send to parent: listen to tag changes
watch(() => props.fromChild, (curr, prev) => {
emit('fromChild', {'section':'statementData', 'subSection':'tag', 'index': data.parentIndex, 'form': data.tagList});
}, {deep: true}, 500);

</script>

