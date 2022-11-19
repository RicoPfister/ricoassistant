<template>

    <div>
        <div class="flex flex-col">

            <button class="flex flex-row justify-between items-center" type="button">

                <label class="" aria-label="Statement Input" for="statement">Tag: </label>

                <MenuEntry />

            </button>

            <div class="flex flex-row items-center h-[42px] border border-black">

                <!-- add button -->
                <button @click.prevent="tagPopupOpen = 1" class="w-[42px] flex justify-center h-full items-center bg-gray-100 border-r border-gray-300" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-fit p-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>

                <!-- add popupp -->
                <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0">
                    <TagPopup @tag-popup-open="tagPopupOpen = 0" />
                </div>

                <!-- tag input -->
                <div class="grow">
                    <input class="outline-0 focus:ring-0 focus:border-black border-none focus:placeholder-transparent w-full" type="text" placeholder="">
                </div>

            </div>

        </div>
    </div>

    </template>

    <script setup>

    import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
    import { Inertia, Method } from "@inertiajs/inertia";

    import MenuEntry from "../Create/MenuEntry.vue";
    import TagPopup from "../TagManager/TagPopup.vue";

    let tagPopupOpen = ref(0);

    </script>

