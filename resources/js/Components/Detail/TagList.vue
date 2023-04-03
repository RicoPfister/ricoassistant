<template>

<div v-if="itemCheck.length > 0">
    <div class="border-b-2 border-black font-bold">Tags</div>
    <div class="pt-2 w-full">
        <div v-for="(item, index) in props.tag" class="">

            <div v-if="item.length > 0" class="flex flex-row flex-wrap">
                <!-- index indicator -->
                <div class="truncate"><span class="bg-black text-white px-1 mr-1 font-bold">{{ parseInt(index)+1 }}
                </span> {{ item.path }}</div>

                <div v-for="(item2, index2) in item" class="mb-1 mr-1">
                    <!-- tag groups -->
                    <div class="truncate bg-lime-200 rounded-xl px-2 w-fit"> {{ '@'+item2[0] + ':' + item2[1] + ':' + item2[2] + (item2[3] ? '(' + item2[3] + ')' : '')}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';

const props = defineProps(['tag']);

let itemCheck = ref([]);

props.tag.forEach((item, index) => {
    if (item.length > 0) itemCheck.value[index] = 1;
});

</script>
