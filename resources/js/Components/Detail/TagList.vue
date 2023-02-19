<template>

<div class="border-b-2 border-black font-bold">Tags</div>
<div class="pt-2 w-full">
    <div v-for="(item, index) in props.tag" class="flex flex-row flex-wrap">

        <!-- index indicator -->
        <div v-if="1" class="truncate"><span class="bg-black text-white px-1 mr-1 font-bold">{{ parseInt(index)+1 }}
        </span> {{ item.path }}</div>

        <div v-for="(item2, index2) in item" class="mb-1 mr-1">
            <!-- tag groups -->
              <div class="truncate bg-lime-200 rounded-xl px-2 w-fit"> {{ '@'+item2[0] + ':' + item2[1] + ':' + item2[2] + (item2[3] ? '(' + item2[3] + ')' : '')}}
            </div>
        </div>
    </div>
</div>

</template>

<script setup>

const props = defineProps(['tag']);

</script>
