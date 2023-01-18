<template>

    <!-- entry menu -->
    <div class="flex flex-row">

        <!-- add -->
        <button @click.prevent="emitData(1)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="blue" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 hover:stroke-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </button>

        <!-- remove -->
        <button @click.prevent="emitData(2)">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="darkred" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-4 h-4 hover:stroke-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

    </div>

</template>

<script setup>

import { ref, onMounted, computed, watch, watchEffect, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import FormPopUp from "../FormManager/FormPopup.vue";

let FormPopupOpen = ref(0);

let emit = defineEmits(['dataChild']);

function emitData(n) {
    // alert(componentSelected.value);
    emit('dataChild', {'formDataEdit': n});
};

</script>
