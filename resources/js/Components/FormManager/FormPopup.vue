<template>

<!-- container -->
<div class="bg-white h-full w-full flex flex-col">

    <!-- ??? -->
    <div class="relative border-r border-gray-400 h-full w-full">

        <!-- header -->
        <div class="flex flex-row border-b border-gray-400 justify-between">

            <div class="px-2 flex flex-row items-center justify-left border-r border-gray-400 grow">

                <div class="text-xl font-bold flex ml-1">New Entry Manager</div>

                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="blue" class="w-5 h-5 ml-1">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a.75.75 0 000 1.5h.253a.25.25 0 01.244.304l-.459 2.066A1.75 1.75 0 0010.747 15H11a.75.75 0 000-1.5h-.253a.25.25 0 01-.244-.304l.459-2.066A1.75 1.75 0 009.253 9H9z" clip-rule="evenodd" />
                    </svg>
                </div>

            </div>

            <div class="flex flex-row ">
                <button :disabled="Object.keys(componentSelected).length == 0" @click="emitData" class="px-2 disabled:opacity-25 enabled:bg-green-200 h-[34px] flex items-center enabled:hover:bg-green-300" type="button">
                    <div class="flex flex-row items-center">
                        <div>
                            <!-- continue icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>Continue</div>
                    </div>
                </button>
            </div>
        </div>

        <div class="flex justify-center mt-5 mb-10">
            <div class="flex flex-col gap-y-3">
                <div class="font-bold ml-4">Choose at least one subject and continue:</div>
                <div class="flex flex-row items-center" v-for="(item, index) in svgData" >

                    <!-- checked icon -->
                    <div class="w-4">
                        <svg v-if="componentSelected[index]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="3" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                        </svg>
                    </div>

                    <!-- form button -->
                    <button @click.prevent="componentSelectedEdit(index)" :class="item[4], componentSelected[index] ? item[3] : ''" class="bg-gray-100 border p-1 ml-1 px-2 rounded-xl w-fit flex flew-row items-center" type="button">
                        <!-- subject icon -->
                        <svg :class="item[2]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" :d="item[5]" />
                        </svg>
                        <div><b>{{ item[0] }}</b> {{ item[1] }}</div>
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['dataParent', 'dataForm']);
let emit = defineEmits(['dataChild']);

function componentSelectedEdit(index) {
    // alert();
    // alert(componentSelected.value[index][1]);
    if (componentSelected.value[index] == 1) delete componentSelected.value[index];
    else componentSelected.value[index] = 1;
}

function emitData() {
    // alert(componentSelected.value);
    emit('dataChild', {'componentSelected': componentSelected.value});
};

let svgData = ref([
    ['Statement', '(facts, opinon, diary)', 'stroke-green-600', 'bg-green-200', 'hover:bg-green-200', 'M12 21a9.004 9.004 0 008.716-6.747M12 21a9.004 9.004 0 01-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 017.843 4.582M12 3a8.997 8.997 0 00-7.843 4.582m15.686 0A11.953 11.953 0 0112 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0121 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0112 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 013 12c0-1.605.42-3.113 1.157-4.418'],
    ['Activity', '(record day activities)', 'stroke-red-600', 'bg-red-200','hover:bg-red-200', 'M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z'],
    ['Guidance', '(financial or psychological advice)', 'stroke-purple-600', 'bg-purple-200', 'hover:bg-purple-200', 'M7.217 10.907a2.25 2.25 0 100 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186l9.566-5.314m-9.566 7.5l9.566 5.314m0 0a2.25 2.25 0 103.935 2.186 2.25 2.25 0 00-3.935-2.186zm0-12.814a2.25 2.25 0 103.933-2.185 2.25 2.25 0 00-3.933 2.185z'],
    ['Administration', '(trading, locations, participants)', 'stroke-yellow-600', 'bg-yellow-200', 'hover:bg-yellow-200', 'M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.416 48.416 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.988 5.988 0 01-2.031.352 5.988 5.988 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L18.75 4.971zm-16.5.52c.99-.203 1.99-.377 3-.52m0 0l2.62 10.726c.122.499-.106 1.028-.589 1.202a5.989 5.989 0 01-2.031.352 5.989 5.989 0 01-2.031-.352c-.483-.174-.711-.703-.59-1.202L5.25 4.971z'],
    ['Source', ' (upload PDFs, images, sounds, videos)', 'stroke-blue-600', 'bg-blue-200', 'hover:bg-blue-200', 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
    // ['Edit entry', '#e5e7eb', 'M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z'],
]);

let componentSelected = ref({});

// watch(() => props.dataParent, _.debounce( (curr, prev) => {

//     lert('okday');

// }, 500));

onMounted(() => {
    // console.log(props.dataParent.sectionSelected[0])
    if (props.dataParent.sectionSelected) {
        // console.log(props.dataParent.sectionSelected)

        componentSelected.value = props.dataParent.sectionSelected;
    }
})

</script>

