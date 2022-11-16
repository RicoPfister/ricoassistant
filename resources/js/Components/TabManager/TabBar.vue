<template>

<div class="flex flex-row">

    <!-- first tab -->
    <div class="h-9 border-l border-t border-r border-gray-300 rounded-t-xl flex items-center w-fit bg-gray-300 hover:font-bold z-[99]">

        <div class="flex items-center h-full pl-2">
            <button type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
            </button>
        </div>

        <button class="text-lg flex items-center pl-1 pr-2 font-bold">
            <div>New/Edit Entry</div>
        </button>

    </div>

    <!-- following tabs -->
    <div class="h-9 border-l border-t border-r border-gray-300 rounded-t-xl flex items-center w-fit bg-gray-100 -ml-2 z-[98]">

        <div class="flex items-center h-full pl-4">
            <button type="button">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                </svg>
            </button>
        </div>

        <button class="text-lg flex items-center pl-1 pr-2">
            <div>Entry Management</div>
        </button>

    </div>
</div>

</template>
