<template>

<div v-if="typeof props?.index == 'undefined'">

<!-- get reference parents list -->
<div class="font-bold mt-1">Reference Parents:</div>
<div v-if="typeof props?.reference?.reference_parents !== 'undefined'" class="flex flex-col">

    <!-- reference group -->
    <div v-for="(item, index) in props.reference.reference_parents">

        <!-- {{ item }} -->

        <div class="flex flex-row">
            <!-- index indicator -->
            <div class="truncate"><span v-if="props.reference.reference_parents.length > 1" class="bg-black text-white px-1 mr-1 font-bold">{{ parseInt(index)+1 }}</span></div>

            <div class="flex flex-row">
                <!-- group reference path -->
                <div class="" v-for="(item2, index2) in item">
                    <span :class="{'font-bold': index2 == 0}">{{ item2.title }}</span>{{ (index2 !== item?.length-1  ? '>' : '') }}
                    <!-- {{ item }} -->
                </div>
            </div>
        </div>
    </div>
</div>
<div v-else class="">Main Entry</div>

</div>

<div v-else>

    <div class="flex flex-row">
        <!-- group reference path -->
        <div class="" v-for="(item, index) in props.reference.reference[props.index]">
            {{  props.reference.reference[0]['title'] }}
            <span :class="{'font-bold': index == 0}">{{ item.title }}</span>{{ (index !== props.reference.reference[props.index].length-1  ? '>' : '') }}
            <!-- {{ item }} -->
        </div>
    </div>

</div>

</template>

<script setup>

const props = defineProps(['reference', 'index']);

</script>
