<template>

<!-- {{ props.data }} -->

<div class="flex flex-row items-center text-sm leading-0 bg-white border w-fit">
    <div v-for="(item, index) in props.data.links" class="flex flex-row text-center justify-center">
        <Link
            v-if="index == 0 && props.data.current_page != 1"
            :href="props.data.links[1].url"
            class="hover:text-lime-500 border-l border-r px-1"
            :class="{'text-lime-500': item.active}"
            >First (1)
        </Link>
        <div
            v-if="item.url == null && index == 0"
            class="text-gray-200 border-l border-r px-1"
            >First (1)
        ></div>
        <Link
            v-if="((index == 0 && props.data.current_page != 1) || (index == props.data.links.length-1 && props.data.current_page != props.data.last_page)) || index-9 <= props.data.current_page && item.url != null && (index >= props.data.current_page || index+10 > props.data.last_page)"
            v-html="item.label"
            :href="item.url"
            class="hover:bg-lime-500 flex text-center justify-center border-r px-1"
            :class="{'bg-lime-500': item.active}"
        />
        <div
            v-if="(item.url == null && index == 0) || (index == props.data.links.length-1 && props.data.current_page == props.data.last_page)"
            v-html="item.label"
            class="text-gray-200 border-r px-1"
        />
        <Link
        v-if="index == props.data.links.length-1 && props.data.current_page != props.data.last_page"
        :href="props.data.links[props.data.links.length-2].url"
        class="hover:bg-lime-500 border-r px-1"
        :class="{'bg-lime-500': item.active}"
        >Last ({{ props.data.last_page }})
        </Link>
        <div
            v-if="index == props.data.links.length-1 && props.data.current_page == props.data.last_page"
            class="text-gray-200 border-r px-1"
            >Last ({{ props.data.last_page }})
        </div>
    </div>
</div>

</template>

<script setup>

import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(['data']);

</script>
