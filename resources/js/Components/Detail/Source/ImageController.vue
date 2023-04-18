<template>

<div class="border-black border-b-2 font-bold mt-2">Image Preview (if available)</div>
<div class="flex flex-wrap mt-1 gap-1">
    <div v-for="(item, index) in props.image" class="">

        <div @mouseover="overlayIsOpen[index] = 1" @mouseleave="overlayIsOpen[index] = 0" class="relative border-2 h-fit">

            <img class="w-max-full h-fit" ref="fullscreen" :src="'/storage/inventory/' + item.item.path" />

            <!-- overlay menu -->
            <div v-if="overlayIsOpen[index]">
                <!-- index indicator -->
                <div class="absolute bottom-0 left-0 bg-black text-white m-2 p-1 leading-none">
                    {{ item.index+1 }}
                </div>

                <!-- full screen button -->
                <div class="absolute bottom-0 right-0 m-2 bg-black text-white p-1 leading-none">
                    <button @click.prevent="openFullscreen(index)" class="w-5 h-5 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                            <path fill-rule="evenodd" d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

const props = defineProps(['image']);

let fullscreen = ref();
let overlayIsOpen = ref([0]);

//   fullscreen function
function openFullscreen(data) {
    fullscreen.value[data].requestFullscreen();
}

</script>
