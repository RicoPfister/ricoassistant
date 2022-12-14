
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
<div class="border-l border-r border-b border-black">
    <Reference :fromController="typeof props.fromController !== 'undefined' ? props.fromController.misc.parentId == 2 ? props.fromController : '' : ''" :toChild="{'parentId': 2, 'parentIndex': 1}" :transfer="props.toChild.parentId == 5 ? props.toChild : ''" @fromChild="fromChild" />
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagForm from "../TagManager/TagForm.vue";
import Reference from "./Reference.vue";

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'componentId', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'transfer', 'toChild', 'fromChild']);
let emit = defineEmits(['dataChild', 'dataCommon', 'dataToParent', 'toParent', 'fromChildRow', 'toChild', 'fromChild']);

// let statement = ref();
let form = useForm({
    statement:'',
});

// send changes to parent
//-----------------------------------------

// send to parent: form data
function InputData() {
    console.log('ok');
    emit('fromChild', {'section':'statementData', 'subSection': 'statement', 'form': form.statement});
}

// send to parent: reference
function fromChild(data) {
    emit('fromChild', {'section':'statementData', 'subSection':'reference', 'form': data.reference.reference});
}

//  send to parent: edit menu selection
function dataChildMenuEntry(n) {
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

</script>

