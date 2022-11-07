<template>
<Header>

    <div class="flex flex-row gap-5 justify-center mt-10">
        <List :data="props.list"/>
    </div>

</Header>
</template>

<script setup>

    import Header from "../Layouts/MainNav.vue";
    import List from "./List.vue";

    const props = defineProps(['list']);

    let data1 = 123;
    let data2 = "";

</script>

