<template>

<div class="h-screen flex items-center justify-center">
    <p class="text-center">Total Backup: <span class="font-bold" :ref="backup['count']"></span>. Last Backup:<br /><span class="font-bold" :ref="backup['date']"></span></p>

    <!-- <p ref="backup_date" class="">2</p> -->
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['backup']);

let backup = {'date': ref(''), 'count': ref('')};

Inertia.post('backup_check');
// Inertia.post('titlecheck', {basicRefDate: form.basicRefDate, basicTitle: form.basicTitle, parentId:1},
//             {replace: false,  preserveState: true, preserveScroll: true});

watch(() => props.backup, (curr, prev) => {
    // console.log(form);
    // emit('fromChild', {'form': {'basicData': form, 'misc': {'parentId': 1}}});
    // console.log('ok');
    backup.count.value.innerText = props.backup.count;
    backup.date.value.innerText = props.backup.date;

});

</script>
