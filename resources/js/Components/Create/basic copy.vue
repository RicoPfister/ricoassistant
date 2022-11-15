<template>

<div class="flex gap-3 flex-wrap w-full min-w-0">

<div class="flex flex-col">
    <label aria-label="Referenced Date Input" for="acc_date">Referenced Date*:</label>
    <input class="w-[141px]" id="acc_date" placeholder="Search" type="date" v-model="form.basic['ref_date']">
</div>

<div class="grow">
    <div class="relative flex flex-col grow">
        <label class="" aria-label="Category Input" for="title">Title*:</label>

        <!-- title input -->
        <input class="focus:placeholder-white" @input="basicTitleChecker()" id="title" type="text" placeholder="" v-model="form.basic['title']">

        <!-- warnings -->
        <button v-if="basicTitleWarning" @click="basicTitelPickerOpen = !basicTitelPickerOpen" type="button" class="absolute top-[33px] right-0 pr-1 flex flex-row items-center">
            <div class="text-xs text-gray-500">{{ props.basicResult.length }}</div>
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'fill-red-400': props.basicResult[0].warning == 2, 'text-black': props.basicResult[0].warning == 2}" fill="none" color="rgb(107 114 128)" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
            </svg>
        </button>

        <!-- titel instant search popup -->
        <div v-if="basicTitelPickerOpen" class="z-50 absolute top-0 left-0 mt-[66px] h-fit w-full text-sm xl:text-lg bg-white border-r border-b border-l border-gray-400 p-1 flex flex-col">

            <div class="flex flex-row items-center z-50">

                <div class="text-sm xl:text-base z-50 w-full max-h-52 overflow-y-auto">

                    <div class="text-sm"><b>Found in Database:</b></div>

                        <div v-for="(item, index) in props.basicResult"
                            :key="index" :class="{'bg-gray-100': index % 2 == 0}"
                            class="flex flex-row items-center w-full">

                            <button>
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 hover:stroke-2">
                                        <path stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                            </button>

                            <!-- button title picker -->
                            <div class="flex justify-between w-full">
                                <button type="button" @click.prevent="TabPositionLeft" class="ml-1 text-gray-500 hover:text-black truncate grow text-left" :class="{'text-red-500': props.basicResult[index].warning == 2, 'hover:text-red-800': props.basicResult[index].warning == 2}" ><div class="truncate">{{ item.title }}</div></button>
                                <button type="button" @click.prevent="AreaLeftPositionChange" class="ml-1 text-gray-500 hover:text-black truncate" :class="{'text-red-500': props.basicResult[index].warning == 2, 'hover:text-red-800': props.basicResult[index].warning == 2}" ><div class="truncate">{{ item.ref_date }}</div></button>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</div>
</div>

<div class="gap-3 flex flex-wrap mt-3">

<div class="flex flex-col min-w-0 grow">
    <label aria-label="Author Input" for="author">Author*:</label>
    <input class="min-w-0" type="text" id="author" v-model="form.basic['author']">
</div>

<div class="flex flex-col lg:max-w-fit grow">
    <label aria-label="Category Input" class="w-fit" for="medium">Medium*:</label>
    <select id="medium" v-model="form.basic['medium']">
        <option value="null" disabled>Select one:</option>
        <option value=""></option>
        <optgroup label="Idea:">
            <option value="sound">Sound</option>
            <option value="picture">Picture</option>
            <option value="video">Video</option>
            <option value="book">Letter</option>
            <option value="interactivity">Interactivity</option>
        </optgroup>
        <optgroup label="Identity:">
            <option value="system">System</option>
            <option value="location">Location</option>
            <option value="self_awareness">Self Awareness</option>
            <option value="self_reproduction">Self Reproduction</option>
            <option value="external_activation">External Activation</option>
            <option value="External_motivation">External Motivation</option>
        </optgroup>
    </select>
</div>
</div>

<div class="flex justify-between">
<div class="flex flex-row">
    <div class="mt-3 text-red-600" v-if="$page.props.errors['basic.ref_date']">*Please fill out all marked fields</div>
    <div class="mt-3 text-red-600" v-else-if="$page.props.errors['basic.author']">*Please fill out all marked fields</div>
    <div class="mt-3 text-red-600" v-else-if="$page.props.errors['basic.title']">*Please fill out all marked fields</div>
    <div class="mt-3 text-red-600" v-else-if="$page.props.errors['basic.medium']">*Please fill out all marked fields</div>
    <div class="mt-3" v-else>*Required fields</div>
    <div class="mt-3">&nbsp;| Some fields may filled out automatically</div>
</div>
<div class="flex flex-row mt-3 items-center">
    <label class="mr-1" for="public">Public:</label>
    <input type="checkbox" id="public" true-value="2" false-value="" v-model="form.basic['status']">
</div>

</div>

</template>
