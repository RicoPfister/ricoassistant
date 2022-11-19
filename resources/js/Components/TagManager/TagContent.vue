<template>

<div v-if="0" class="h-[calc(100%-35px)] flex items-center justify-center flex-col gap-y-5">
    <h1 class="font-bold">Welcome to the Tag Manager!</h1>
    <p>Here you can choose tags grouped in categories.</p>
    <p>Then you can value the tags and add an discription.</p>
    <p>Let's start by adding the first tag!</p>
</div>

<div class="h-auto flex flex-row bg-gray-100">
        <div class="px-3 flex items-center border-r border-b border-gray-400 w-[200px]">Tags for Entry:</div>
        <div class="px-3 flex items-center border-r border-b border-gray-400 grow"></div>
    </div>

<div v-for="(item, index) in 1" class="flex flex-col">
    <div class="h-auto flex flex-row">
        <div class="px-3 flex items-center border-r border-b border-gray-400 w-[200px]"></div>
        <div class="px-3 flex items-center border-r border-b border-gray-400 w-[150px]"></div>
        <div class="flex flex-row justify-between pl-3 pr-1 items-center border-r border-b border-gray-400 grow">
            <div class=""></div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" color="red" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

    </div>
</div>

</template>
