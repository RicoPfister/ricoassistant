
<template>

<div>
    <div class="flex flex-col">
        <div class="flex flex-row justify-between items-center" type="button">
            <MenuEntry @data-child="dataChildMenuEntry"/>
        </div>
        <textarea @input="form = {...form, 'parentId': 2, 'parentIndex': 1}" class="border border-black outline-0 focus:border-black focus:ring-0" rows="10" id="statement" type="text" v-model="form['statement']"></textarea>
    </div>
</div>
<TagForm :from-parent="'titleNo'" />
<div class="border-l border-r border-b border-black">
    <Reference @fromChild="fromChild" :toChild="form" :transfer="props.toChild"/>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagForm from "../TagManager/TagForm.vue";
import Reference from "./Reference.vue";

let dataChild = ref({});

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'componentId', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'transfer', 'toChild', 'fromChild']);
let emit = defineEmits(['dataChild', 'dataCommon', 'dataToParent', 'toParent', 'fromChildRow', 'toChild', 'fromChild']);

const form = useForm({
    statement:'',
    tag: {},
    reference: '',
    fromController: {'misc': {'parentId': ''}},
});

// statemetn
//-----------------------------------------

// menu edit component
function dataChildMenuEntry(n) {
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

// listen to auto statement set value
onMounted(() => {
    if (typeof props.dataForm.statement != 'undefined') {
        form.value['statement'] = props.dataForm.statement;
    }

    // if (typeof props.fromController != 'undefined') {

    // }
});

watch(() => props.fromController, (curr, prev) => {
    // console.log(props.fromController.misc.parentId);
    if (props.fromController.misc.parentId == 2) {
            form.fromController = props.fromController;
            // console.log(form.fromController.misc.parentId);
    }
}, {deep: true});

// send form changes to parent
//-----------------------------------------
watch(() => form, (curr, prev) => {
    emit('fromChild', {'form': {'statementData': form}});
}, {deep: true}, 500);

</script>

