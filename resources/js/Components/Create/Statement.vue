
<template>

<div class="flex flex-col">
    <div class="flex flex-row justify-between items-center" type="button">
        <MenuEntry @data-child="dataChildMenuEntry"/>
    </div>
    <textarea
        @input="InputData"
        :class="{'border-red-500 focus:border-red-500 border-4 bg-red-200': form2?.errors?.['statementData.statement']}"
        class="border border-black outline-0 focus:border-black focus:ring-0"
        rows="10"
        id="statement"
        type="text"
        v-model="form.statement">
    </textarea>
    <div v-if="form2?.errors?.['statementData.statement']" class="text-red-500">{{ form2?.errors?.['statementData.statement'] }}</div>
</div>

<div
    :class="{'border-black': !form2?.errors?.['statementData.tag'], 'border-none': form2?.errors?.['statementData.tag'], 'mt-2': form2?.errors?.['statementData.statement'], 'border-t': form2?.errors?.['statementData.statement']}"
    class="border-r border-b border-l"
>
    <TagForm
        :class="{'border-t': form2?.errors?.['statementData.statement'], 'border-t-4 border-r-4 border-b-4 border-l-4 border-red-500 bg-red-200': form2?.errors?.['statementData.tag']}"
        :toChild="{'parentId': 2, 'parentIndex': 0, 'basicTitle': props.toChild?.basicData?.title, 'formTags': props?.toChild?.statementData?.tag?.[0], 'validationError': form2?.['errors']?.['statementData.tag']}"
        :fromController2="props.fromController2"
        :fromController="props.fromController"
        @fromChild="fromChild"
    />
    <!-- <div v-if="form2.errors['statementData.tag']" class="text-red-500">Required tag format: @Category:Context:Value</div> -->
        <div v-if="form2.errors['statementData.tag']" class="text-red-500">{{ form2.errors['statementData.tag'] }}</div>
</div>

<div
:class="{'border-t': 0, 'border-t mt-2': form2?.errors?.['statementData.tag']}"
    class="border-l border-r border-b border-black h-[31px]"
>
    <Reference :fromController="typeof props.fromController !== 'undefined' ? props.fromController : ''" :toChild="{'parentId': 2, 'parentIndex': 0, 'formParentReference': props?.toChild?.statementData?.reference_parents}" :transferCreate="props.transferCreate" :transfer="props.toChild.parentId == 5 ? props.toChild : ''" @fromChild="fromChild"/>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";
import TagForm from "../TagManager/TagForm.vue";
import Reference from "./Reference.vue";

const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'componentId', 'dataCommon', 'dataToParent', 'fromController', 'toParent', 'transfer', 'toChild', 'fromChild', 'transferCreate', 'fromController2', 'fromController_validation']);
let emit = defineEmits(['dataChild', 'dataCommon', 'dataToParent', 'toParent', 'fromChildRow', 'toChild', 'fromChild', 'transferCreate', 'fromController2', 'fromController_validation']);

// let validationError = ref(0);

console.log('ok');

// let statement = ref();
let form = useForm({
    statement:'',
});

// send changes to parent
//-----------------------------------------

// send to parent: statement input data
function InputData() {
    // console.log('ok');
    emit('fromChild', {'section':'statementData', 'subSection': 'statement', 'form': {'statement': form.statement, 'id': props?.toChild?.statementData?.statement?.id}});
}

// send to parent: reference selection OR tag list
function fromChild(data) {
    if (data.component == 'reference' && data.parentId == 2) {

        // console.log(data);
        // console.log(data.reference);

        emit('fromChild', {'section':'statementData', 'subSection':'reference_parents', 'index': 0, 'form': data.reference});
    }

    if (data.component == 'tag' && data.parentId == 2) {
        // console.log('ok');
        emit('fromChild', {'section':'statementData', 'subSection':'tag', 'index': data.parentIndex, 'form': data.tagList});
    }

    if (data.tagPreset) {
        // console.log(data.tagPreset);
        emit('fromChild', {'section':'statementData', 'subSection':'tagPreset', 'form': data.tagPreset});
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

onMounted(() => {
    form['statement'] = {};
    form['statement'] = props.toChild?.statementData?.statement?.statement;
    form['id'] = props.toChild?.statementData?.statement?.id;
});

// validation error processing

console.log('ok');

const form2 = useForm('key1', {'test': null});

watch(() => usePage().props.value.errors, (curr, prev) => {

// console.log(Object.keys(usePage()?.props.value?.errors).length);
// console.log(Object.keys(form2['errors']).length);

if (Object.keys(usePage()?.props.value?.errors).length) {

        console.log('ok');

        form2['errors'] = usePage().props.value.errors;

        for (const [key, value] of Object.entries(form2['errors'])) {
            // console.log(`${key}: ${value}`);
            if (key.match(/statementData\.tag./g)) {
                console.log('ok');
                form2['errors']['statementData.tag'] = value;
                // validationError.value = 1;
            }

            else form2['errors']['statementData.tag'] = null;
        }
}

// else if (Object.keys(usePage()?.props.value?.errors).length == 0 && Object.keys(form2['errors']).length == 1) {

//         console.log('ok');
//         form2['errors'] = '';
//     }
});

</script>

