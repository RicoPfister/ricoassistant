
<template>

<div class="border-b border-l border-r border-gray-400 h-[35px] flex flex-row items-center justify-between text-lg rounded-b-xl shadow-xl">

    <button class="border-r px-3 border-gray-400 rounded-bl-xl bg-gray-300 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 9l-3 3m0 0l3 3m-3-3h7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Back</div>
        </div>
    </button>

    <button class="border-r px-3 border-gray-400 bg-gray-300 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 11.25l-3-3m0 0l-3 3m3-3v7.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Top</div>
        </div>
    </button>

    <button class="border-r px-3 border-gray-400 bg-gray-300 h-full flex items-center">
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>Add Field</div>
        </div>
    </button>

    <div class="border-r px-3 border-gray-400 h-full grow flex items-center justify-start">

        <div>
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 15.75l-2.489-2.489m0 0a3.375 3.375 0 10-4.773-4.773 3.375 3.375 0 004.774 4.774zM21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <input class="outline-0 focus:ring-0 focus:placeholder-transparent" placeholder="Total data to add: 12">
    </div>

    <button @click="submit" class="px-3 flex items-center bg-gray-300 h-full rounded-br-xl" type="button" >
        <div class="flex flex-row items-center">
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
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

