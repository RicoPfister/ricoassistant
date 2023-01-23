<template>

<!-- get reference parents -->
<div class="font-bold mt-1">Reference Parents:</div>
<div v-if="typeof props.reference.reference_parents !== 'undefined'" class="flex flex-row">

    // reference group
    <div v-for="(item, index) in props.reference.reference_parents"></div>

        // reference content
        <div v-for="(item2, index2) in item">
            <i>{{ item2['title'] }}</i>{{ (index2 !== props.reference.reference_parents.length-1  ? '>' : '') }}
            <!-- {{ item }} -->
        </div>
</div>
<div v-else class="">Main Entry</div>

<!-- get reference children -->
<div v-if="typeof props.reference.reference_children !== 'undefined'" class="flex flex-col">
    <div class="font-bold mt-1">Reference Children:</div>
    <div v-for="(item, index) in props.reference.reference_children" class="flex flex-row">
        {{ item[0]['ref_db_name'] + '&nbsp;' +  item[0]['title'] + '&nbsp;' + item[0]['ref_date'] }}
        <div v-if="typeof item[0]?.['ref_id']?.[0]?.['activityTime'] !== 'undefined'">{{  '&nbsp;' + item[0]['ref_id'][0]['activityTime'] +'min'}}</div>
        <div v-if="typeof item[0]?.['ref_id']?.[0]?.['path'] !== 'undefined'">{{ '&nbsp;' + 'File: ' + item[0]['ref_id'].length }}</div>
    </div>
</div>

</template>

<script setup>

const props = defineProps(['reference']);

</script>
