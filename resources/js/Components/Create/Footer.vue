
<template>

<div class=" flex flex-row items-center justify-between text-sm rounded-xl h-[28px] border border-gray-400">

    <!-- back button -->
    <button @click.prevent="deleteSections" class="border-r px-2 border-gray-300 rounded-l-xl bg-gray-200 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="darkred" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                </svg>
            </div>
            <div>Reset</div>
        </div>
    </button>

    <!-- top button -->
    <button @click.prevent="scrollToTop" class="border-r px-2 border-gray-300 bg-gray-200 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Top</div>
        </div>
    </button>

    <!-- add field -->
    <button @click.prevent="addSection" class="border-r px-2 border-gray-300 bg-gray-200 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Add Field</div>
        </div>
    </button>

    <!-- text field -->
    <div class="border-r border-gray-300 bg-white px-2 h-full grow flex items-center justify-start">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
            </svg>
        </div>
        <div class="outline-0 focus:ring-0 border-none focus:placeholder-transparent ml-1">Total data to add: 12</div>
    </div>

    <!-- next button -->
    <button v-if="!editCheck" @click="submit" class="px-2 flex items-center bg-gray-200 h-full rounded-r-xl" type="button" >
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Next</div>
        </div>
    </button>

    <button v-else @click="update" class="px-2 flex items-center bg-gray-200 h-full rounded-r-xl" type="button" >
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Update</div>
        </div>
    </button>

</div>

</template>

<script setup>

let props = defineProps(['editCheck']);
let emit = defineEmits(['dataChild', 'dataForm']);

function submit() {
    console.log('ok');
    emit('dataChild', {'submit': 1});
}

function update() {
    emit('dataChild', {'update': 1});
}

function scrollToTop() {
    emit('dataChild', {'scrollToTop': 1});
}

function deleteSections() {
    emit('dataChild', {'deleteSections': 1});
}

function addSection() {
    emit('dataChild', {'formDataEdit': 1});
}


</script>

