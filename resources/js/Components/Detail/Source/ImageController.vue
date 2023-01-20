<template>

<div class="border-black border-b-2 font-bold mt-2">Image Preview (if available)</div>
<div class="flex flex-wrap mt-1 gap-1">
    <div v-for="(item, index) in props.image" class="">

        <div class="relative border-2 h-36">
            <!-- <img :src="preview[index]" class="w-[214px] max-h-full"> -->
            <img class="w-[214px] max-h-full" ref="fullscreen" :src="'/storage/inventory/' + item.item.path" />
            <!-- <img class="w-[214px] max-h-full" :src="'/storage/inventory/' + item.item.path" /> -->
            <!-- image menu bar -->

            <!-- image menu bar -->

            <!-- index number -->
            <div class="absolute bottom-0 left-0 m-2">
                {{ item.index+1 }}
            </div>

            <!-- full screen button -->
            <div class="absolute bottom-0 right-0 m-2">
                <button @click.prevent="openFullscreen(index)" class="w-5 h-5 flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-7 -mt-[0px]">
                        <path fill-rule="evenodd" d="M15 3.75a.75.75 0 01.75-.75h4.5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0V5.56l-3.97 3.97a.75.75 0 11-1.06-1.06l3.97-3.97h-2.69a.75.75 0 01-.75-.75zm-12 0A.75.75 0 013.75 3h4.5a.75.75 0 010 1.5H5.56l3.97 3.97a.75.75 0 01-1.06 1.06L4.5 5.56v2.69a.75.75 0 01-1.5 0v-4.5zm11.47 11.78a.75.75 0 111.06-1.06l3.97 3.97v-2.69a.75.75 0 011.5 0v4.5a.75.75 0 01-.75.75h-4.5a.75.75 0 010-1.5h2.69l-3.97-3.97zm-4.94-1.06a.75.75 0 010 1.06L5.56 19.5h2.69a.75.75 0 010 1.5h-4.5a.75.75 0 01-.75-.75v-4.5a.75.75 0 011.5 0v2.69l3.97-3.97a.75.75 0 011.06 0z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

const props = defineProps(['image']);

let fullscreen = ref();

//   fullscreen function
function openFullscreen(data) {
    fullscreen.value[data].requestFullscreen();
}

</script>
