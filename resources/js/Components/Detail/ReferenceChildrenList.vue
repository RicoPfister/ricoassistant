<template>

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
