<template>

<div class="h-screen flex items-center justify-center flex-col">

    <div class="flex flex-row items-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
        </svg>

        <div>&nbsp;>&nbsp;</div>

        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
        </svg>

        <div>&nbsp;</div>

        <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
        </svg>
        <br />
        <br />
    </div>
    <h1 class="font-bold text-3xl">Backup successfull created</h1>
    <br />
    <p class="text-center">Last Backup:<br /><span class="font-bold" :ref="backup['date']"></span><br /><br />Total Backups: <br /><span class="font-bold" :ref="backup['count']"></span></p>

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
