<template>

    <div class="flex flex-col">

        <div aria-label="Header" :class="{'mb-5': typeof props?.toChild?.fromController == 'undefined', 'mb-12': tagQuickFilterBarOpen == 1 || tagQuickFilterBarData != 'undefined', 'mb-5': tagQuickFilterBarOpen == 0}" class="flex items-center xl:justify-between xl:items-end mx-2 xl:mx-10">

            <div aria-label="Logo" class="xl:w-auto">
                <Link translate="no" href="/" class="w-fit leading-none p-1 text-2xl text-lime-600 border-b-4 border-lime-600 hidden xl:block xl:mt-3"><span class="text-4xl font-bold">RA</span> | Rico Assistant</Link>
                <Link translate="no" href="/" class="w-fit leading-none mr-2 xl:mr-0 text-lime-600 border-b-4 border-lime-600 block xl:hidden text-4xl font-bold">RA</Link>
            </div>

            <div aria-label="Menu Container" class="flex flex-row xl:w-1/2 w-full min-w-0">

                <div aria-label="search box" class="xl:relative xl:w-full flex xl:justify-end w-full items-center">

                    <div class="relative flex items-center w-full h-8 xl:h-10 border border-black">

                        <div class="p-1 h-full flex items-center bg-gray-100 border-r border-gray-300">
                            <span class="flex items-center h-16">

                                <button @click="searchEditMenuOpen = !searchEditMenuOpen" class="">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                                    </svg>
                                </button>

                            </span>
                        </div>
                        <div class="flex items-center w-full h-full">

                            <input @input="searchInput" aria-label="Search Field" placeholder="Search" type="search" class="w-full h-full min-w-0 border-none focus:ring-0 focus:border-black focus:placeholder-white" v-model="searchData">


                            <div class="px-1 xl:px-2 h-full flex items-center bg-lime-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                                </svg>
                            </div>

                        </div>

                        <div v-if="searchEditMenuOpen" aria-label="Search Edit Menu" class="absolute top-0 left-0 mt-10 xl:mt-12 border border-black h-96 w-full p-2 z-50 bg-gray-100">

                        Search filter coming soon.

                        </div>


                    </div>



                        <div aria-label="Menu Icon and Menu Popup Area" class="flex items-center leading-none  h-full item">
                            <Link v-if="$page.props.user" aria-label="Dashboard button" class="hidden xl:flex items-end xl:ml-1" :href="route('dashboard')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0020.25 18V6A2.25 2.25 0 0018 3.75H6A2.25 2.25 0 003.75 6v12A2.25 2.25 0 006 20.25z" />
                                </svg>
                                <!-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-12 h-12 ml-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" />
                                </svg> -->
                            </Link>
                            <Link v-if="$page.props.user" aria-label="New Entry button" class="hidden xl:block" href="/create">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                            </Link>
                            <div v-if="$page.props.user" aria-label="AI button" class="opacity-20 hidden xl:block" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="green" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                                </svg>
                            </div>
                            <div>

                            </div>

                            <!-- <MenuBox @menu-popup-open-active= "menuPopupOpenActive = !menuPopupOpenActive" v-if="menuPopupOpenActive"/> -->
                        </div>

                    <button aria-label="Menu button" class="" @click.prevent="addPopupOpenActive = 0; menuPopupOpenActive = !menuPopupOpenActive">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="blue" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10 ml-1 2xl:ml-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                    </button>

                    <div v-if="1" aria-label="quickbar" class="absolute flex left-0 top-[53px] xl:top-12 xl:gap-3 gap-1 w-full justify-center xl:justify-start text-sm xl:text-lg">
                        <div v-if="tagQuickFilterBarData?.story" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>

                            <!-- <Link :href="route('filter', {'category': 'story'})" class="underline flex flex-row"><b>Story</b><span class="hidden 2xl:block">{{props?.toChild?.fromController?.story?.[0] ? '(' + props?.toChild?.fromController?.story?.[0] + ')' : ''}} </span></Link> -->
                            <Link :href="route('filter', {'category': 'story'})" class="underline flex flex-row"><b>Story</b><span class="hidden 2xl:block"></span></Link>

                        </div>
                        <div v-if="tagQuickFilterBarData?.fact" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>

                            <Link :href="route('filter', {'category': 'fact'})" class="underline flex flex-row"><b>Fact</b><span class="hidden 2xl:block"></span></Link>
                        </div>
                        <div v-if="tagQuickFilterBarData?.education" class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 3.104v5.714a2.25 2.25 0 01-.659 1.591L5 14.5M9.75 3.104c-.251.023-.501.05-.75.082m.75-.082a24.301 24.301 0 014.5 0m0 0v5.714c0 .597.237 1.17.659 1.591L19.8 15.3M14.25 3.104c.251.023.501.05.75.082M19.8 15.3l-1.57.393A9.065 9.065 0 0112 15a9.065 9.065 0 00-6.23-.693L5 14.5m14.8.8l1.402 1.402c1.232 1.232.65 3.318-1.067 3.611A48.309 48.309 0 0112 21c-2.773 0-5.491-.235-8.135-.687-1.718-.293-2.3-2.379-1.067-3.61L5 14.5" />
                            </svg>
                            <Link :href="route('filter', {'category': 'education'})" class="underline flex flex-row"><b>Education</b><span class="hidden 2xl:block"></span></Link>
                        </div>
                        <div v-if="tagQuickFilterBarData?.exchange" class="items-center hidden 2xl:flex">
                            <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z" />
                            </svg>
                            <Link :href="route('filter', {'category': 'exchange'})" class="underline flex flex-row"><b>Exchange</b><span class="hidden 2xl:block"></span></Link>
                        </div>
                        <div v-if="tagQuickFilterBarData?.admin" class="items-center hidden 2xl:flex">
                            <svg xmlns="http://www.w3.org/2000/svg" color="Coral" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 00-1.883 2.542l.857 6a2.25 2.25 0 002.227 1.932H19.05a2.25 2.25 0 002.227-1.932l.857-6a2.25 2.25 0 00-1.883-2.542m-16.5 0V6A2.25 2.25 0 016 3.75h3.879a1.5 1.5 0 011.06.44l2.122 2.12a1.5 1.5 0 001.06.44H18A2.25 2.25 0 0120.25 9v.776" />
                            </svg>
                            <Link :href="route('filter', {'category': 'admin'})" class="underline flex flex-row"><b>Admin</b><span class="hidden 2xl:block"></span></Link>
                        </div>
                        <!-- <div class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                            </svg>
                            <Link :href="route('filter')" class="underline flex flex-row"><span class="hidden 2xl:block">999k&nbsp;</span><b>Accounting</b></Link>
                        </div> -->
                    </div>
                </div>
            </div>

        </div>

        <hr class="">

        <div class="grow xl:px-10 px-2 pb-5">
            <slot />
        </div>

    </div>

<MenuPopup @menu-popup-open-active = "menuPopupOpenActive = !menuPopupOpenActive" v-if="menuPopupOpenActive"/>
<AddPopup @add-popup-open-active = "addPopupOpenActive = !addPopupOpenActive" v-if="addPopupOpenActive"/>
<MessagePopUp v-if="0" @MessagePopUpOpen="MessagePopUpOpenActive = !MessagePopUpOpenActive" />

</template>

<script setup>

import { Head, Link, useForm, useRemember } from '@inertiajs/inertia-vue3'
import { ref, onMounted, computed, watch  } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuPopup from '../Components/Menu.vue';
import AddPopup from '../Components/AddPopUp.vue';
import MessagePopUp from '../Components/MessagePopUp.vue'
import AddBox from '../Components/AddPopUp.vue';
import Home from '../Pages/Home.vue';

let props = defineProps(['toChild', 'fromController2']);

let menuPopupOpenActive = ref(0);
let addPopupOpenActive = ref(0);
let MessagePopUpOpenActive = ref(1);
let searchEditMenuOpen = ref(0);
let data = ref();
let tagQuickFilterBarOpen = ref(0);
let searchData = ref('');
let tagQuickFilterBarData = ref('');

// console.log('ok');

onMounted(() => {

    // console.log('ok');

    if (!props?.toChild?.fromController && props?.toChild?.page_id) Inertia.get('/mainNav', {'page_id': props?.toChild?.page_id}, {replace: false,  preserveState: true, preserveScroll: true});

    if ( props?.toChild?.tagQuickFilterBarOpen) {
        tagQuickFilterBarOpen.value = props.toChild.tagQuickFilterBarOpen;
    }
    // if (props?.toChild?.fromController?.length > 0) {
    //     data.value = props.home;
    // }

    // if ( props?.toChild?.tagQuickFilterBarOpen) {
    //     tagQuickFilterBarOpen.value = props.toChild.tagQuickFilterBarOpen;
    // }

    tagQuickFilterBarData.value = props?.toChild?.fromController;

});

watch(() => props.toChild, (curr, prev) => {

    // console.log('ok');

    // if (typeof props.home != undefined) {
    //     console.log('ok');
    //     form3['quick_tag_bar'] = props.home;
    // }

    if ( props?.toChild?.tagQuickFilterBarOpen) {
        tagQuickFilterBarOpen.value = props.toChild.tagQuickFilterBarOpen;
    }

    if (typeof props.toChild.fromController != 'undefined') tagQuickFilterBarData.value = props?.toChild?.fromController;

}, {deep: true}, 500);






// watch(() => props?.toChild?.check, (curr, prev) => {

//     console.log(props?.toChild?.check);

//     if (typeof props?.toChild?.check != 'undefined') Inertia.get('/mainNav', {'page_id': props?.toChild?.page_id}, {replace: false,  preserveState: true, preserveScroll: true});

// }, {deep: true}, 500);






watch(() => props.toChild.fromController, (curr, prev) => {



if (props?.toChild?.fromController?.length > 0 || typeof props?.toChild?.fromController != 'undefined') {
    // console.log(props?.toChild?.fromController);
    data.value = props.home;

}

if (typeof props?.toChild?.fromController == 'undefined') {

    // console.log(props.toChild.fromController);

    // if (!props?.toChild?.fromController && props?.toChild?.page_id) Inertia.get('/mainNav', {'page_id': props?.toChild?.page_id}, {replace: false,  preserveState: true, preserveScroll: true});

}

}, {deep: true}, 500);


function searchInput() {

    // check if reference form ***input*** has been and send request to controller
    if (searchData.value.length > 2) {
        setTimeout(() => {
            Inertia.get('filter', {searchData: searchData.value}, {replace: false,
            preserveState: true, preserveScroll: true});
        }, 500);
    }
}

</script>

