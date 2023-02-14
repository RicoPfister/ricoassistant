<template>

    <Header>
        <div class="flex flex-col h-full justify-center items-center xl:mt-0 xl:pb-10">
            <div class="h-16 w-full text-center justify-center flex items-center text-xl md:text-3xl text-white bg-red-400 rounded-3xl mb-3 xl:mb-5 flex-col md:flex-row">
                <div class="whitespace-nowrap">This site is under construction - &nbsp;</div>
                <div class="whitespace-nowrap">"Proof of Concept" Testing.</div>
            </div>
            <div class="w-full flex h-full flex-wrap justify-center 2xl:gap-24 p-7 bg-gray-200 rounded-3xl shadow-xl">
                <img class="order-3 2xl:order-1" src="/storage/home/rico_assistant_home_image.svg">
                <hr class="order-2 2xl:hidden h-20 mt-6">
                <img class="order-1 2xl:order-3" src="/storage/home/rico_assistant_home_text.svg">
                <hr class="order-4 2xl:hidden mt-6">
                <img class="order-5 2xl:order-5" src="/storage/home/rico_assistant_home_reference.svg">
            </div>
        </div>
    </Header>

</template>

<script setup>

    import Header from "../Layouts/MainNav.vue";

</script>
