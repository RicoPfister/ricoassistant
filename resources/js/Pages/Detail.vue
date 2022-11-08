<template>

    {{ detailData.title }}

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

const props = defineProps(['detail']);

let detailData = ref(['']);

// onMounted(() => {
//     detailData.value = props.detail;
// });

watch(() => props.detail, _.debounce( (curr, prev) => {
    detailData.value = props.detail;
}, 500)
);

</script>
