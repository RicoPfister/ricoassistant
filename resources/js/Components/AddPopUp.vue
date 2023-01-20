<template>

<div @click="$emit('addPopupOpenActive')" class="absolute w-full h-full bg-white top-16 sm:top-16 left-0 opacity-90"></div>

    <div class="absolute top-20 right-5 bg-white">

        <div class="border-2 border-black p-3">
            <div class="font-bold">New Entry</div>
            <div class="mt-2">Choose a form preset:
                <div class="gap-2 pt-2">
                    <div class="flex items-center bg-gray-100">
                        <button class="w-36 flex justify-start"><span class="border-2 border-blue-500 p-1 h-fit leading-none hover:bg-gray-200">Statement</span></button>
                        <div class="ml-2">
                            <div>Used for: Opinion, Diary</div>
                            <div>Preset fields: <b>Text</b></div>
                        </div>
                    </div>

                    <div class="flex items-center bg-gray-100 mt-2">
                        <button class="w-36 flex justify-start"><span class="border-2 border-blue-500 p-1 h-fit leading-none hover:bg-gray-200">Time Tracking</span></button>
                        <div class="ml-2">
                            <div>Used for: Track your daily work.</div>
                            <div>Preset fields: <b>Time</b>; <b>Text</b></div>
                        </div>
                    </div>

                    <div class="flex items-center bg-gray-100 mt-2">
                        <button class="w-36 flex justify-start"><span class="border-2 border-blue-500 p-1 h-fit leading-none hover:bg-gray-200">Facts</span></button>
                        <div class="ml-2">
                            <div>Used for: Studies; Photos; Videos; Sounds</div>
                            <div>Preset fields: <b><b>Text</b>; <b>Trader</b>; <b>Producer</b></b></div>
                        </div>
                    </div>

                    <div class="flex items-center bg-gray-100 mt-2">
                        <button class="w-36 flex justify-start"><span class="border-2 border-blue-500 p-1 h-fit leading-none hover:bg-gray-200">Accounting</span></button>
                        <div class="ml-2">
                            <div>Used for: Bills; Correspondence; Inventory</div>
                            <div>Preset fields: <b>Producer</b>; <b>Trader</b>; <b>Price</b>; <b>Location</b></div>
                        </div>
                    </div>

                    <div class="flex items-center bg-gray-100 mt-2">
                        <button class="w-36 flex justify-start"><span class="border-2 border-blue-500 p-1 h-fit leading-none hover:bg-gray-200">Empty</span></button>
                        <div class="ml-2">
                            <div>Used for: Create a form from scratch</div>
                            <div>Preset fields: -</div>
                        </div>
                    </div>
                    <div class="mt-2">Auto Presets: Date; Category</div>
                </div>
            </div>
        </div>
    </div>




</template>

<script setup>

import { Link } from "@inertiajs/inertia-vue3";



</script>
