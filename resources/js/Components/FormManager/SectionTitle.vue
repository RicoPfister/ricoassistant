<template>

    <!-- container border title -->
    <div class="absolute -top-[12px] flex items-center -left-[1px] w-[calc(100%+2px)]">
        <div class="flex items-center grow">
            <span class="border-t border-gray-400 w-1"></span>
            <div class="flex flex-row items-center px-1">
                <svg :class="FormSectionIcons.FormSections[props.Id][2]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" :d="FormSectionIcons.FormSections[props.Id][5]" />
                </svg>
                <h2 class="text-black font-bold text-base">Activity*<span class="font-normal"></span></h2>
            </div>
            <span class="border-t border-gray-400 flex-1"></span>
        </div>
        <div class="flex items-center justify-end w-fit px-1">
            <MenuEntry @data-child="dataChildMenuEntry"/>
        </div>
        <span class="border-t border-gray-400 w-1"></span>
    </div>

</template>

<script setup>

import * as FormSectionIcons from "../../Scripts/SVGIcons.js";
import MenuEntry from "../Create/MenuEntry.vue";

const props = defineProps(['Id']);

function dataChildMenuEntry(n) {
    // alert(n['formDataEdit']);
    // alert(props.componentId);
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

</script>
