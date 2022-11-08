<template>

    {{ details.title }}

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

const props = defineProps(['detail']);

let details = ref('');

// basic title response
watch(() => props.detail, _.debounce( (curr, prev) => {

    details.value = props.detail;

}, 500)
);

</script>
