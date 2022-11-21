
<template>

<div class=" flex flex-row items-center justify-between text-sm rounded-xl h-[28px] border border-gray-400">

    <!-- back button -->
    <button class="border-r px-2 border-gray-300 rounded-l-xl bg-gray-200 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Back</div>
        </div>
    </button>

    <!-- top button -->
    <button class="border-r px-2 border-gray-300 bg-gray-200 h-full flex items-center">
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
    <button class="border-r px-2 border-gray-300 bg-gray-200 h-full flex items-center">
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
    <button @click="submit" class="px-2 flex items-center bg-gray-200 h-full rounded-r-xl" type="button" >
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 15l3-3m0 0l-3-3m3 3h-7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Next</div>
        </div>
    </button>

</div>

</template>

<script setup>

let emit = defineEmits(['dataChild']);

function submit() {
    emit('dataChild', {'submit': 1});
}

</script>

