<template>

<div>
    <div class="flex flex-col">

        <button class="flex flex-row justify-between items-center" type="button">

            <label class="" aria-label="Statement Input" for="statement">Statement: </label>

            <!-- entry menu -->
            <div class="flex flex-row">

                <!-- move up -->
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 hover:stroke-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                    </svg>
                </div>

                <!-- move down -->
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 hover:stroke-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>

                <!-- remove -->
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="darkred" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 hover:stroke-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>

                <!-- add -->
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="blue" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 hover:stroke-2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </div>
            </div>

        </button>

        <textarea v-model="dataChild['statement']" rows="10" id="statement" type="text"></textarea>

    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

let dataChild = ref({'statement': ''});

const props = defineProps(['dataParent']);
let emit = defineEmits(['dataChild']);

// emit form
watch(() => dataChild, (curr, prev) => {

    emit('dataChild', {'formData': dataChild.value});

}, {deep: true}, 500);

</script>

