<template>

<Header :toChild="{'page_id': 'Dashboard', 'tagQuickFilterBarOpen': 1, 'fromController': props.fromController}">

 <!-- navpath-string-tag -->
 <div class="text-sm 2xl:text-lg pb-2 mt-5" >

<!-- navpath-string -->
<div class="flex flex-wrap">
  <div class="flex flex-row mb-2">
    <div class="flex items-center">

        <Link href="/" as="button" class="">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4 lg:w-6 lg:h-6">
<path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
</svg>
</Link>

        &nbsp;>&nbsp;</div>
    <div class=""><span class="underline">Dashboard</span></div>
  </div>
</div>
</div>

        <div class="flex h-full justify-center items-start xl:mt-2 xl:pb-10">
            <div class="w-full h-auto p-7 bg-blue-100 rounded-3xl shadow-xl">
                <h1 class="font-bold text-lg flex flex-row ">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
  <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5m-9-6h.008v.008H12v-.008zM12 15h.008v.008H12V15zm0 2.25h.008v.008H12v-.008zM9.75 15h.008v.008H9.75V15zm0 2.25h.008v.008H9.75v-.008zM7.5 15h.008v.008H7.5V15zm0 2.25h.008v.008H7.5v-.008zm6.75-4.5h.008v.008h-.008v-.008zm0 2.25h.008v.008h-.008V15zm0 2.25h.008v.008h-.008v-.008zm2.25-4.5h.008v.008H16.5v-.008zm0 2.25h.008v.008H16.5V15z" />
</svg>

                Dashboard</h1><br>
                <p>This will one day become your command center.<p><br></p>From here you have full control over all your activities and entries.</p>
                <br><p>*****</p><br>
                <!-- <p>Das wird einmal deine Kommandozentrale werden.<p><br></p>Von hier aus hast du die volle Kontrolle über all deine Aktivitäten und Einträge.</p>
                <br><p>*****</p><br> -->
                <Link :href="route('filter', {'user': 'all_user_entries'})"><u>Show your entries {{ '(' + props?.statistic?.user_entries + ')'}}</u></Link>
                <!-- <Link :href="route('filter', {'category': 'fact'})" class="underline flex flex-row"><b>Fact</b><span class="hidden 2xl:block">{{data?.fact?.[0] ? '(' + data?.fact?.[0] + ')' : ''}} </span></Link> -->
                <br><br><p>*****</p><br>
                <h2 class="font-bold">User Tag Category and Context Counter</h2>
                <br>
                <div class="flex flex-col h-36 overflow-auto">
                    <p v-for="(item, key, index) in props?.statistic?.tags">{{ item.count + ' | ' + item.category + ':' + item.context }}</p>
                </div>
            </div>
        </div>

    </Header>

</template>

<script setup>

    import Header from "../Layouts/MainNav.vue";
    import { Head, Link } from '@inertiajs/inertia-vue3';
    import { Inertia, Method } from "@inertiajs/inertia";

    const props = defineProps(['statistic', 'fromController']);

    Inertia.post('statistic');

</script>
