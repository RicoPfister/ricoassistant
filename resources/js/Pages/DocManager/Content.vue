<template>

<div class="space-y-2">

    <div v-for="(item, index) in props.fromController.slice(1)">

        <!-- separate main chapter (x) -->
        <div :class="{'mb-[0px]': !props.fromController[0][index][2]}" :ref="el => { chapterRef[index+1] = el }" class="flex flex-col mb-[10px]">
            <b class="text-2xl mb-[10px]">{{ index+1 + ' ' + props.fromController[0][index][1]}}</b>
            {{ props.fromController[0][index][2] }}
        </div>

        <div class="space-y-2">

                <div v-for="(item2, index2) in item">
                <!-- {{ item2 }} -->

                <!-- separate level 1 chapter (x.x) -->
                <div :ref="el => { chapterRef[index+1+'.'+(index2+1)] = el }" class="">
                    <div :class="{'mb-[0px]': !item2[0][2]}" class="mb-[10px] flex flex-col">
                        <b class="text-xl mb-[10px]">{{ item2[0][0] + ' ' + item2[0][1]}}</b>
                        {{ item2[0][2] }}
                    </div>

                    <div v-for="(item3, index3) in item2[1]">

                        <!-- separte 2 level chapter (x.x.x) -->
                        <div :class="{'mb-[0px]': !item3[2]}" :ref="el => { chapterRef[index+1+'.'+(index2+1)+'.'+(index3+1)] = el }" class="mb-[10px] flex flex-col">
                            <b class="mb-[10px]">{{ item3[0] + ' ' + item3[1]}}</b>
                            {{ item3[2] }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import IndexSubHeading1 from './IndexSubHeading1.vue'

const props = defineProps(['fromController']);
const emit = defineEmits(['fromChild'])

let chapterRef = ref({});
let chapterRef1 = ref();
let chapterPosition = ref();

function fromChild() {
    emit('fromChild', {'chapterRef':  chapterRef})
}

onMounted(() => {
    // console.log(chapterRef.value);
    // chapterPosition.value = chapterRef.value[0].getBoundingClientRect();
    // console.log(chapterPosition.value.top);

    fromChild();
});

function chapterRefCollector(el, index, index2, index3) {
    // console.log(el, index);
    // if (index2 == undefined) {
    //     console.log('ok');
    //     chapterRef[index] = [el];
    // }

    // else if (index3 == undefined) {
    //     console.log('ok');

    //     if (chapterRef?.[index]?.[index2] == undefined) chapterRef[index][index2] = [];
    //     chapterRef[index][index2+1] = [el];

    // }

    // else {
    //     console.log(el, index, index2, index3);

    //     if (chapterRef?.[index]?.[index2]?.[index3] == undefined) chapterRef[index][index2][index3] = [];
    //     chapterRef[index][index2+1][index3+1] = el;

    // };
    // chapterRef.value[index] = el;
    // else if (index2 == undefined) chapterRef.value[index][index1] = el;
    // else chapterRef.value[index][index1][index2] = el;

}

</script>
