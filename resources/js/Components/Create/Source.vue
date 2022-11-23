
<template>

<div>
    <div class="flex flex-col">

        <div class="flex flex-row justify-between items-center" type="button">

            <label class="" aria-label="Statement Input" for="statement">Source*: </label>

            <MenuEntry @data-child="dataChildMenuEntry"/>

        </div>

        <!-- content box -->
        <div class="border border-black p-3 space-y-2">
            <div class="flex flex-row justify-between">
                <div class="">Upload files (<b>max. 10 Megabytes</b> in total):</div>
                <div class="flex flex-row items-center space-x-1">
                    <!-- <div class="">Add section:</div> -->
                    <button @click="InputData.push({'filelist': '', 'key': uniqueKey++})" type="button">

                        <!-- add icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>

            </div>

            <div class="flex flex-col space-y-2">
                <div v-for="(item, index) in InputData" :key="item.key" :class="{'bg-gray-200': InputData[index]}" class="flex flex-row items-center border border-gray-300 p-1 justify-between">
                    <input type="file" @change="InputData[index]['filelist'] = $event.target.files">
                    <div class="flex flex-row space-1">
                        <button @click.prevent="InputData.splice(index, 1)" type="button">
                            <svg xmlns="http://www.w3.org/2000/svg" color="darkred" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";

let dataChild = ref({'statement': ''});

const props = defineProps(['dataParent', 'dataChild']);
let emit = defineEmits(['dataChild']);

let uniqueKey = 0;
let InputData = ref([{'filelist': '', 'key': uniqueKey++}]);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

// function InputDataAction(index) {
//     if (InputData.value.length == index+1) {
//         InputData.value.push('');
//     };
// }

function dataChildMenuEntry(n) {
    // alert(n['formDataEdit']);
    emit('dataChild', {'formDataEdit': n['formDataEdit']});
}

</script>

