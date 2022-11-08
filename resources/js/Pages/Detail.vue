<template>

    {{ detailShow.title }}

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

const props = defineProps(['detail', 'tabid']);

let details = ref([[]]);
let detailShow = ref(['']);

watch(() => props.detail, _.debounce( (curr, prev) => {

    details.value[props.tabid-1] = props.detail;
    detailShow.value = details.value[props.tabid-1];

}, 500)
);

watch(() => props.tabid, _.debounce( (curr, prev) => {

if (details.value[props.tabid-1]) {
    detailShow.value = details.value[props.tabid-1];
}

}, 500)
);

</script>
