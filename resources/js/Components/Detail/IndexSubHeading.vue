<template>

<div class="flex flex-row mt-1">
    <!-- main heading number -->
    <div class="justify-end w-5 h-[16px] flex items-center">{{ index+1 }}</div>
    <div class="h-[16px] w-5 flex items-center">.1</div>
    <button class="h-[16px] flex items-center hover:text-lime-600" type="button">{{ 'Test' }}</button>
    
    <div class="relative grow mx-1 h-[16px] flex items-center">
        <div class="absolute -top-[2px] border-b-2 border-black border-dotted h-[16px] w-full"></div>
    </div>
    <div class="text-xs w-fit h-[16px] flex items-center">
        <div class="">[5]</div>
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
        </svg>
    </div>
</div>

</template>

<script setup>

const props = defineProps(['index']);

</script>
