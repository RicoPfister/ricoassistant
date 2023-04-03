<template>

<div class="space-y-2">
    <div v-for="(item, index) in props.fromController">

        <div class="flex flex-col">
            <b>{{ item[1] }}</b>
            {{ item[2] }}
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from './IndexSubHeading1.vue'

const props = defineProps(['fromController']);

</script>
