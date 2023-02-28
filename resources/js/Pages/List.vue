<template>

<!-- table -->
<table class="w-full table-fixed">

    <!-- table header row -->
    <tr class="text-left">

        <!-- medium symbol  -->
        <th class="lg:w-[32px]">
            <div class="flex justify-center w-6">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
        </th>

        <!-- title -->
        <th class="underline grow">Title 1-20</th>

        <!-- rating symbol -->
        <!-- <th class="hidden lg:table-cell underline lg:w-[36px]">
            <div class="flex justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
                </svg>
            </div>
        </th> -->

        <!-- ref date -->
        <th class="hidden lg:table-cell text-right underline lg:w-[90px]">Ref. Date</th>
    </tr>

    <!-- table content rows -->
    <tr v-for="(item, index) in data?.data" :key="index" class="">

        <!-- symbol medium -->
        <td class="text-center">
            <ListIconsMedium :medium="item.medium" />
        </td >

        <!-- title -->
        <td class="truncate"><button @click.prevent="addtab(); detailOpen(item.id)" type="button">{{ item.title }}</button></td>

        <!-- rating -->
        <!-- <td class="hidden lg:table-cell text-center">999</td> -->

        <!-- ref date -->
        <td class="hidden lg:table-cell text-right">{{ item.ref_date }}</td>
    </tr>
</table>

<div class="flex justify-center py-1 w-full">
    <Pagination v-if="data?.total > 20" :data="data" />
</div>

</template>

<script setup>

import { Head,defineEmits, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuBox from '../Components/Menu.vue';
import ListIconsMedium from "../Components/ListIconsMedium.vue";
import Pagination from "../Components/List/Pagination.vue";

const props = defineProps(['list', 'detail']);

let emit = defineEmits(['addtab']);

function detailOpen(n) {
    Inertia.get('detail', {basic_id: n}, {replace: false,  preserveState: true, preserveScroll: true});
}

let data = ref([]);

onMounted(() => {
    data.value = props.list;
});

function addtab() {
    emit('addtab');
}

</script>

