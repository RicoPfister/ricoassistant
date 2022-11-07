<template>

<!-- container -->
<div class="lg:w-[755px]">

    <!-- tabbar -->
    <div class="flex flex-row border-b border-lime-500 gap-1">

        <!-- featured -->
        <div class="bg-lime-700 text-lime-200 font-bold rounded-t-xl w-fit px-3 flex items-center">Featured
            <svg xmlns="http://www.w3.org/2000/svg" color="white" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-4 h-4 pl-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div>

        <!-- new -->
        <!-- <div class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-3 flex items-center">New
            <svg xmlns="http://www.w3.org/2000/svg" color="white" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-4 h-4 pl-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div> -->

        <!-- random -->
        <!-- <div class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-3 flex items-center">Ricomizer
            <svg xmlns="http://www.w3.org/2000/svg" color="white" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-4 h-4 pl-1">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </div> -->

        <!-- add entry -->
        <div class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-2 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
            </svg>
        </div>

        <!-- search -->
        <div class="bg-lime-500 text-lime-100 font-bold rounded-t-xl w-fit px-2 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
            </svg>
        </div>
    </div>

    <!-- navpathbar -->

    <div class="lg:text-md text-md mt-3 flex items-center" >

        <div class="flex flex-wrap items-center">

            <div class="flex flex-row mb-2 items-center">

                <!-- home symbol -->
                <div class="flex items-center">
                    <Link href="/" as="button" class="">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 lg:w-5 lg:h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </Link>
                    &nbsp;>&nbsp;
                </div>

                <div class="flex items-center"><span class="underline">Search</span>&nbsp;>&nbsp;</div>
                    <div class="flex flex-row">
                        <div class="mr-2">42 results found for:</div>
                    </div>
            </div>

            <div class="flex flex-wrap mb-2 items-center gap-2">

                <!-- tag -->
                <div class="px-1 flex flex-row items-center w-fit bg-gray-200 leading-none">
                    <div class="flex items-center">Title: Maniac Mansion</div>
                    <div class="">
                        <svg xmlns="http://www.w3.org/2000/svg" color="black" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-5 h-5 pl-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </div>
                </div>

                <!-- tag -->
                <div class="px-1 flex flex-row items-center w-fit bg-gray-200 leading-none">
                    <div class="flex items-center">#Condition: Very Good</div>
                    <svg xmlns="http://www.w3.org/2000/svg" color="black" fill="none" viewBox="0 0 24 24" stroke-width="5" stroke="currentColor" class="w-5 h-5 pl-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

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
            <th class="hidden lg:table-cell underline lg:w-[36px]">
                <div class="flex justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
                    </svg>
                </div>
            </th>

            <!-- ref date -->
            <th class="hidden lg:table-cell text-right underline lg:w-[90px]">Ref. Date</th>
        </tr>

        <!-- table content rows -->
        <tr v-for="data in props.data" :key="index" class="">

            <!-- symbol medium -->
            <td class="text-center">
                <ListIconsMedium :medium="data.medium" />
            </td >

            <!-- title -->
            <td class="truncate"><Link :href="route('detail', { id: data['id']})">{{ data.title }}</Link></td>

            <!-- rating -->
            <td class="hidden lg:table-cell text-center">999</td>

            <!-- ref date -->
            <td class="hidden lg:table-cell text-right">{{ data.ref_date }}</td>
        </tr>
    </table>
</div>

</template>

<script setup>

import { Head } from '@inertiajs/inertia-vue3';
import { Link } from "@inertiajs/inertia-vue3";
import { ref, onMounted, computed  } from 'vue';

import MenuBox from '../Components/Menu.vue';
import ListIconsMedium from "../Components/ListIconsMedium.vue";

const props = defineProps(['data']);

let menuboxOpenActive = ref(0);

// Inertia.get('filter', {title: form.basic.title, ref_date: form.basic.ref_date}, {replace: false,  preserveState: true, preserveScroll: true});

let test123 = props.data + 100;

</script>

