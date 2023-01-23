<template>

    <div class="border-black border-b-2 font-bold mt-2">Music Player</div>
    <div class="flex flex-wrap mt-2 gap-1">
        <div v-for="(item, index) in props.music" class="flex flex-row items-center">

            <!-- index indicator -->
            <div class="bg-black text-white m-2 p-1 leading-none flex h-fit">
                {{ item.index+1 }}
            </div>

            <audio controls>
                <source :src="'/storage/inventory/' + item.item.path" type="audio/mpeg">
                Your browser does not support the audio element.
            </audio>
        </div>
    </div>

    </template>

    <script setup>

    import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

    const props = defineProps(['music']);

    </script>
