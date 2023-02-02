
<template>

<!-- activity container -->
<!-- ------------------------------------------------ -->
<div aria-label="Activity" class="flex flex-col border-l border-b border-r border-gray-400 bg-yellow-50 text-sm w-full pt-4 gap-2 mt-[12px] pb-3">

    <div class="relative -top-[16px]">
        <SectionTitle :Id="2"/>
    </div>


    <!-- time schedule box-->
    <!-- ------------------------------------------------ -->
    <div class="flex flex-col items-center gap-1 w-full mt-1">

        <!-- time schedule list builder -->
        <div class="flex flex-row lg:h-8 w-[722px]" v-for="(n, index) in activityTotalRow" @input="activityRowAdd(n)"
        @keyup.exact="activityKeyPressed($event, n)" @keyup.shift.arrow-up="activityKeyShUpPressed(1, n)"
        @keyup.shift.arrow-down="activityKeyShDownPressed(1, n)">

            <!-- input time -->
            <input class="w-[41px] lg:w-[61px] text-sm lg:text-base text-center placeholder:text-black-400 focus:placeholder-white leading-none"
            :id="'activityToRowNumber'+[n-1]" maxlength="4" @keypress="onlyNumbers($event)" pattern="^[0-9]{4}$" type="text" placeholder="To"
            v-model="form.activityTo[n-1]">

            <!-- button box -->
            <div class="flex flex-row mx-1">

                <!-- button 12h/clear-->
                <div class="flex-col hidden lg:block">

                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button"
                    @click="form.activityTo[n-1] = 1200">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591
                            1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                    </button>

                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button"
                    @click="form.activityTo[n-1] = ''">
                        <div class="text-xs flex items-center justify-center h-full">C</div>
                    </button>
                </div>

                <!-- button hours -->
                <div class="flex flex-col h-full">
                    <button class="text-sm w-4 h-1/2 flex items-center justify-center bg-blue-100 hover:bg-blue-200" type="button"
                    @click="activitybuttonBar('h', n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                        class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </button>
                    <button class="w-4 h-1/2 flex items-center justify-center bg-blue-100 hover:bg-blue-200" type="button"
                    @click="activitybuttonBar('hMinus', n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                        </svg>
                    </button>
                </div>

                <!-- button minutes -->
                <div class="flex flex-col h-full">
                    <button class="text-sm w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activitybuttonBar('m', n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                        </svg>
                    </button>

                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activitybuttonBar('mMinus', n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- reference box -->
            <div class="w-full min-w-0 text-sm lg:text-lg h-8 border border-black flex flex-row">

                <div class="w-full h-[30px] flex flex-row">
                    <div class="grow">
                        <ReferenceActivity :fromController="typeof props.fromController !== 'undefined' ? props.fromController : ''" :toChild="{'parentId': 4, 'parentIndex': index, 'parents_reference': form.activityReference[index]}" :transfer="props.toChild.parentId == 5 ? props.toChild : ''" @fromChild="fromChild" />
                    </div>
                    <div class="w-fit">
                        <TagForm :toChild="{'parentId': 4, 'parentIndex': index, 'basicTitle': props.toChild?.basicData?.title, 'tagInputShow': 0, 'formTags': form?.activityTag?.[index]}" :fromController="props.fromController" @fromChild="fromChild"/>
                    </div>
                </div>

                <!-- tag buttons -->
                <!-- <div class="h-full flex items-center bg-gray-200 w-fit">
                    <div class="border-l border-gray-400 p-1 w-auto h-full" @mouseover="tagTooltipShow(index)" @mouseleave="tagTooltipShow(index, 1)">
                        <button type="button" @click.prevent="tagPopupOpenActive(index)" class="w-auto h-full">
                            <svg xmlns="http://www.w3.org/2000/svg" color="gray" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" :class="{'stroke-yellow-600': form.activityTag[index]}" class="w-auto h-full hover:stroke-black">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                            </svg>
                        </button>
                    </div>
                </div> -->

            </div>

            <!-- edit button box -->
            <div class="flex flex-row ml-1">
                <!-- button clear reference/ clear rating-->
                <div class="flex-col hidden lg:block">
                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="form.activityReference[n-1] = ''">
                        <div class="text-xs flex items-center justify-center h-full">C</div>
                    </button>
                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="form.activityReference[n-1] = ''">
                        <div class="text-xs flex items-center justify-center h-full">C</div>
                    </button>
                </div>

                <!-- button duplicate row / remove row -->
                <div class="flex flex-col">
                    <button class="w-4 h-1/2 flex items-center justify-center bg-blue-100 hover:bg-blue-200" type="button" @click="activityRowDuplicate(n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                            </svg>
                    </button>
                    <button class="w-4 h-1/2 flex items-center justify-center bg-red-100 hover:bg-red-200" type="button" @click="activityRowDelete(n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- button swap [hidden] -->
                <div class="flex-col hidden">
                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityKeyShUpPressed(0, n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                        </svg>
                    </button>
                    <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityKeyShDownPressed(0, n)">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </div>
            </div>
            <!-- tag tool tip -->
            <!-- <div v-if="tagTooltipOpen[index]" class="absolute w-[650px] p-2 h-fit bg-yellow-200 border border-black z-50">{{ form.activityTag[index] ? form.activityTag[index] : 'no tags set' }}</div> -->
        </div>

    </div>

    <!-- day overview box -->
    <!-- ------------------------------------------------ -->
    <div aria-label="Drop Down Activity Day Overview" class="">

        <div class="flex z-10 w-full justify-center whitespace-nowrap overflow-x-auto">

            <!-- diagram box -->
            <div class="flex flex-col">

                <div class="relative w-[722px] border border-gray-300 h-5 flex flex-row text-gray-500 bg-white">
                    <div v-for="(width, index) in activityDayOverviewDiagram1a" :key="'A'+index" class="flex flex-row">
                        <div class="h-full bg-stone-300 flex" :style="{ width: width['minute']+'px', background: activityDiagramColorTag[width['row']] }"></div>
                    </div>

                    <!--0-12 disgram -->
                    <div class="absolute top-0 left-0 h-full flex items-center bg-black text-white opacity-50 w-4 justify-center">
                        0
                    </div>

                    <!-- separator lines -->
                    <div class="absolute top-0 left-0 h-full items-center flex flex-row w-full">
                        <div v-for="item in 6" class="border-r w-[120px] h-full border-gry-500"></div>
                    </div>

                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-full flex items-center"></div>

                    <div class="absolute top-0 right-0 h-full flex items-center bg-black text-white opacity-50 w-4 justify-center">
                        12
                    </div>

                </div>

                <div class="relative w-[722px] border border-gray-300 h-5 flex flex-row text-gray-500 mt-1 bg-white">
                    <div v-for="(width, index) in activityDayOverviewDiagram1b" :key="'B'+index" class="flex flex-row">
                        <div class="h-full bg-stone-300" :style="{ width: width['minute']+'px', background: activityDiagramColorTag[width['row']] }"></div>
                    </div>

                    <!-- 12-24 day diagram -->
                    <div class="absolute top-0 left-0 h-full flex items-center bg-black text-white opacity-50 w-4 justify-center">
                        12
                    </div>

                    <!-- separator lines -->
                    <div class="absolute top-0 left-0 h-full items-center flex flex-row w-full">
                        <div v-for="item in 6" class="border-r w-[120px] h-full border-gry-500"></div>
                    </div>

                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-full">

                    </div>

                    <div class="absolute top-0 right-0 h-full flex items-center bg-black text-white opacity-50 w-4 justify-center">
                        24
                    </div>
                </div>
            </div>

            <!-- day activity statistic -->
            <div class="hidden">
                <div class="flex flex-row gap-5">
                    <div class="mt-3 flex flex-col">
                        <div class="border-b border-black"><b>Category</b></div>
                        <div>Sustainability</div>
                        <div>Development</div>
                        <div>Influence</div>
                    </div>
                    <div class="mt-3 flex flex-col">
                        <div class="border-b border-black"><b>Hours/%</b></div>
                        <div>3 (23%)</div>
                        <div>7 (23%)</div>
                        <div>1 (23%)</div>
                    </div>
                    <div class="mt-3 flex flex-col">
                        <div class="border-b border-black"><b>Grade (Intensity/Success/Happiness)</b></div>
                        <div>1-2-3</div>
                        <div>1-2-3</div>
                        <div>1-2-3</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- open popup -->
<!-- <div v-if="tagPopupOpen" class="absolute h-full w-full top-0 left-0 z-50">
    <TagPopup :toChild="tagInputShow == 0" :fromParentTagString="form.activityTag[tagCollectionInputIndex]" :data-common="props.dataCommon" @tag-popup-open="tagPopupOpen = 0" :data-form="props.dataForm" @dataToParent="dataToParent" @from-controller="fromController" @from-child="fromChild"/>
</div> -->

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted, toRef } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import * as Date from "../../Scripts/date.js"
import SectionTitle from "../FormManager/SectionTitle.vue"
import ReferenceActivity from "./Reference.vue";
import TagPopup from "../TagManager/TagPopup.vue";
import TagForm from "../TagManager/TagForm.vue";

// import Tooltip_Rating from "../Components/Tooltips/Rating.vue";

// const props = defineProps(['user', 'referencesResult', 'misc', 'basicResult']);
const props = defineProps(['dataParent', 'dataChild', 'dataForm', 'dataCommon', 'componentId', 'dataToParent', 'fromController', 'transfer', 'toParent', 'toChild', 'fromChild', 'transferCreate']);
let emit = defineEmits(['dataChild', 'dataParent', 'dataToParent', 'toParent', 'referenceChecker', 'index', 'transfer', 'fromController', 'toChild', 'fromChild', 'transferCreate']);

const form = useForm({
    activityTo: [],
    activityReference: [],
    activityTag: {},
    referenceChecker: {'rowIndex': '', 'check': '', 'id': 1},
    fromController: {},
    referencePickerOpen: [0],
    parentId: 1
});

let activiteTolimitReached = ref(0);
let activityTotalRow = ref(1);
let activityDayOverviewDiagram = ref([]);
let activityDayOverviewDiagram1a = ref([]);
let activityDayOverviewDiagram1b = ref([]);
let activityDiagramColorTag = ref(['']);

let tagPopupOpen = ref(0);
let tagTooltipOpen = ref([]);
let tagTooltipOpenCheck = [];

let tagCollectionInputIndex = ref('');
let tagTooltipShowTimer = '';

let fromController = ref(0);

let convertTimeToTO = '';

// button functions
//----------------------------------------

// hour/minutes button
function activitybuttonBar(e, n) {

    if (isNaN(form.activityTo[n-1]) || (form.activityTo[n-1]) == '') form.activityTo[n-1] = 0
        else form.activityTo[n-1] = parseInt(form.activityTo[n-1]);

    let minutes = parseInt(form.activityTo[n-1].toString().slice(-2));

    if (minutes < 60) {

        let toTimeOldValue = form.activityTo[n-1];
        let hours = parseInt(form.activityTo[n-1].toString().slice(0, -2));
        let toTimeAdditionalMinutes = minutes % 15;

        if (e == 'h') { form.activityTo[n-1] += 200 }

        if (e == 'hMinus') {
            if (form.activityTo[n-1] > 0) {

                console.log(parseInt((form.activityTo[n-1].toString().slice(-2)))-30);

                if (parseInt((form.activityTo[n-1].toString().slice(-2)))-30 >= 0) {
                    form.activityTo[n-1] -= 30;
                } else {

                form.activityTo[n-1] -= 70;
                };
            }
            activiteTolimitReached.value = 0;
        };

        if (e == 'm') {

            if (isNaN(hours)) hours = 0;

                if (minutes < 45) form.activityTo[n-1] += 15
                else { hours += 1; minutes = 0; form.activityTo[n-1] = hours * 100 + toTimeAdditionalMinutes };
        }

        else if (e == 'mMinus') {

            if (form.activityTo[n-1] > 0) {
                if (form.activityTo[n-1].toString().slice(-2) > 0) {

                form.activityTo[n-1] -= 1;
                } else {

                form.activityTo[n-1] -= 41;
                };
            }

            activiteTolimitReached.value = 0;
        };

        // min and max time adjustments

        // check if stored time was 2400 and go to 0 plus minutes
        if ( toTimeOldValue == 2400 && e != 'mMinus' && e != 'hMinus' ) {

            form.activityTo[n-1] = 2400;
        }

        // top reached - check if time has passed max of 2400
        else if (form.activityTo[n-1] >= 2400) {

            form.activityTo[n-1] = 2400; activiteTolimitReached.value = 1;

        }

        // bottom reached - check if time has passed min value of 0
        if (form.activityTo[n-1] < 0) {
            form.activityTo[n-1] = 0;
        }

        // inherit value from previous time
        if (typeof form.activityTo[n-2] !== 'undefined') {
            if (form.activityTo[n-1] <= form.activityTo[n-2] || (toTimeOldValue > 2400 && (e == 'hMinus' || e == 'mMinus'))) {

                form.activityTo[n-1] = form.activityTo[n-2];

                if (e == 'h' && toTimeOldValue <= 2400) form.activityTo[n-1] += 200;
                else if (e == 'm' && toTimeOldValue <= 2400) form.activityTo[n-1] += 15;
            }

            if (form.activityTo[n-1] >= 2400) {

            form.activityTo[n-1] = 2400; activiteTolimitReached.value = 1;
}
        };
    }

    // add/remove row

    if (form.activityTo[n-1] > 0 && form.activityTo[n-1] < 2400 && !document.getElementById("activityToRowNumber"+(n)) ) {
        activityTotalRow.value++;
        form.activityTo[n] = '';
        form.activityReference[n] = '';
    }

    else if (form.activityTo[n-1] == 2400 && activiteTolimitReached.value == 1 && document.getElementById("activityToRowNumber"+(n)) && form.activityTo[n] == '' && (typeof form.activityReference[n].title == 'undefined' || form.activityReference[n].title == '')) {
        activityTotalRow.value--;
        form.activityTo.splice(-1);
        form.activityReference.splice(-1)
        activiteTolimitReached.value = 0;
    }
}

// only number keys allowed
function onlyNumbers(e) {
    if(!e.key.match(/[0-9]/)) e.preventDefault();
}

function activityRowAdd(n) {

    // add row
    if (!document.getElementById("activityToRowNumber"+(n)) && form.activityTo[n-1] < 2400 && form.activityTo[n-1] !='0000' && form?.activityTo?.[n-1]?.match(/..[0-5][0-9]/) && document?.getElementById("activityToRowNumber"+(n-1))?.value?.length == 4) activityTotalRow.value++;

    form.referencePickerOpen[n-1] = 0;
}

// key events - common
function activityKeyPressed(e, n) {

        if(e.key == 'ArrowUp'){
        if (document.activeElement == document.getElementById("activityToRowNumber"+(n-1))) {
            if(n > 1) document.getElementById("activityToRowNumber"+(n-2)).focus();
            else document.getElementById("activityToRowNumber"+(activityTotalRow.value-1)).focus();
        }
        else {
            if(n > 1) document.getElementById("activityReferenceRowNumber"+(n-2)).focus();
            else document.getElementById("activityReferenceRowNumber"+(activityTotalRow.value-1)).focus();
        }
    }

    if(e.key == 'ArrowDown'){
        if (document.activeElement == document.getElementById("activityToRowNumber"+(n-1))) {
            if(n <= activityTotalRow.value-1) document.getElementById("activityToRowNumber"+(n)).focus();
            else document.getElementById("activityToRowNumber"+(0)).focus();
        }
        else {
            if(n <= activityTotalRow.value-1) document.getElementById("activityReferenceRowNumber"+(n)).focus();
            else document.getElementById("activityReferenceRowNumber"+(0)).focus();
        }
    }

    if(e.key == 'ArrowRight'){
        document.getElementById("activityReferenceRowNumber"+(n-1)).focus();
    }

    if(e.key == 'ArrowLeft'){
        document.getElementById("activityToRowNumber"+(n-1)).focus();
    }

    if(e.key == 'Enter'){
        activityRowDuplicate(n)
    }

    if(e.key == 'Delete'){

        activityRowDelete(n);
    }
}

// key events - shift + arrow up
function activityKeyShUpPressed(check, n) {
    if(n-1 > 0) {
        form.activityTo.splice(n-2, 2, form.activityTo[n-1], form.activityTo[n-2]);
        form.activityReference.splice(n-2, 2, form.activityReference[n-1], form.activityReference[n-2]);

        if(check == 1) {
            if(document.activeElement == document.getElementById("activityToRowNumber"+(n-1))) {
                document.getElementById("activityToRowNumber"+(n-2)).focus();
            } else document.getElementById("activityReferenceRowNumber"+(n-2)).focus();
        }
    }
}

// key events - shift + arrow down
function activityKeyShDownPressed(check, n) {
    if(n-1 < activityTotalRow.value-2) {
        form.activityTo.splice(n-1, 2, form.activityTo[n], form.activityTo[n-1]);
        form.activityReference.splice(n-1, 2, form.activityReference[n], form.activityReference[n-1]);

        if(check == 1) {
            if(document.activeElement == document.getElementById("activityToRowNumber"+(n-1))) {
                document.getElementById("activityToRowNumber"+(n)).focus();
            } document.getElementById("activityReferenceRowNumber"+(n)).focus();
        }
    }
}

// time functions
// delete row
function activityRowDelete(n) {

    if(activityTotalRow.value > 1) {
        form.activityTo.splice(n-1, 1);
        form.activityReference.splice(n-1, 1);
        activityTotalRow.value--;
    } else {
        form.activityTo.splice(0, 1, '');
        form.activityReference.splice(0, 1, '');
    }
}

// duplicate row
function activityRowDuplicate(n) {
    form.activityTo.splice(n, 0, form.activityTo[n-1] );
    form.activityReference.splice(n, 0, form.activityReference[n-1] );
    activityTotalRow.value++
}

// // send form changes to Create.vue
// watch(() => form, (curr, prev) => {

// // console.log(form);
// // emit('fromChild', {form)};
// // emit('fromChild', {'section':'activityData', 'subSection':'activityReference', 'form': form.activityReference});


// }, {deep: true}, 500);

//! watch for diagram width adjustments and add title/medium in basics.vue
watch(() => form.activityTo, (curr, prev) => {

    //?? set basic title and medium
    // emit('fromChild', {'basicTitle': 'Activity ' + Date.dateNow(), 'basicMedium': 'self_awareness'});

    let minutes = 0;
    let minuteTotal = 0;
    let forLoop = 0;

    activityDayOverviewDiagram.value = [];
    activityDayOverviewDiagram1a.value = [];
    activityDayOverviewDiagram1b.value = [];

    if (typeof form.activityTo[form.activityTo.length-1] == 'number') {
        forLoop = form.activityTo.length;
    } else {
        forLoop = form.activityTo.length-1;
    }

    for (let i = 0; i < forLoop; i++) {

        minutes = (((form.activityTo[i] - (form.activityTo[i] % 100)) / 100 * 60) + form.activityTo[i] % 100) - minuteTotal;
        activityDayOverviewDiagram.value[i] = minutes;
        minuteTotal += minutes;
    }

    let k = 0;
    minuteTotal = 0;
    let minuteOld = 0;
    let row = 0;
    let l = 0;

    for (let j = 0; j < activityDayOverviewDiagram.value.length; j++) {

        minuteTotal += activityDayOverviewDiagram.value[j];

        if (minuteTotal <= 720) {
            activityDayOverviewDiagram1a.value[j] = {'row': row, 'minute': activityDayOverviewDiagram.value[j]};
            minuteOld = minuteTotal;
            row++;
        };

        if (minuteTotal > 720 && l == 1) {
            activityDayOverviewDiagram1b.value[k] = {'row': row, 'minute': activityDayOverviewDiagram.value[j]};
            minuteOld = minuteTotal;
            k++;
            row++;
        };

        if (minuteTotal > 720 && l == 0) {
            activityDayOverviewDiagram1a.value[j] = {'row': row, 'minute': 720 - minuteOld};
            activityDayOverviewDiagram1b.value[k] =  {'row': row, 'minute': minuteTotal - 720};
            minuteOld = minuteTotal;
            k++;
            row++;
            l = 1;
        };
    }

    emit('fromChild', {'section':'activityData', 'subSection':'activityTo', 'form': form.activityTo});
}, {deep: true}, 500);

function tagPopupOpenActive(data) {
    tagCollectionInputIndex.value = data;
    tagPopupOpen.value = !tagPopupOpen.value;
}

function dataToParent(data) {

if (data.tagCollection) {
    form['activityTag'][tagCollectionInputIndex.value] = data.tagCollection;
    tagPopupOpen.value = 0;
}
}

// show tag tool tip
function tagTooltipShow(index, data) {

    if(data == 1) {
        tagTooltipOpenCheck[index] = 1;
        tagTooltipOpen.value[index] = 0;
    }

    else {
        tagTooltipOpenCheck[index] = 0;

        tagTooltipShowTimer = setTimeout(() => {
            if (!tagTooltipOpenCheck[index]) {
                tagTooltipOpen.value[index] = 1;
            }
        }, 1000);
    }
}

// reference
//-------------------------------------------------

// send changes to parent
//-----------------------------------------

// send to parent: statement input data
// function InputData() {
//     console.log('ok');
//     emit('fromChild', {'section':'activityData', 'subSection': 'statement', 'form': form.statement});
// }

// send to parent: reference selection
function fromChild(data) {
    // console.log(data);

    // set activity diagram color
    if (data?.color) activityDiagramColorTag.value[data.parentIndex] = data.color;
    else activityDiagramColorTag.value[data.parentIndex] = '';
    // console.log(activityDiagramColorTag.value);

    if (data.component == 'reference' && data.parentId == 4) {
        emit('fromChild', {'section':'activityData', 'subSection':'reference_parents', 'index': data.parentIndex, 'form': data.reference});
    }

    // if () {
    //     emit('fromChild', {'section':'activityData', 'subSection':'activityTo', 'form': form.activityTo});
    // }

    if (data.component == 'tag' && data.parentId == 4) {
        emit('fromChild', {'section':'activityData', 'subSection':'tag', 'index': data.parentIndex, 'form': data.tagList});
    }
}

//  send to parent: edit menu selection
function dataChildMenuEntry(n) {
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

// watch(() => props.fromController, (curr, prev) => {
//     if (props?.fromController) {
//         console.log('ok');
//         fromController.value = props.fromController};
// }, {deep: true}, 500);

onMounted(() => {

    // console.log(props.toChild.activityData['tag']);

    if (props?.toChild?.activityData) {
        props.toChild.activityData['activityTo'].forEach((item, index) => edittimeToTo(item, index));

        props.toChild.activityData['reference_parents'].forEach((item, index) => editParentReference(item, index));

        if (props?.toChild?.activityData?.['tag']) editTag(props.toChild.activityData['tag']);


    }

});

let convertTimeToTOTotal = 0;
let TimeMinutes = 0;

function edittimeToTo(item, index) {
    let parseactivityTo = parseInt(item.activityTime);
    // console.log(parseactivityTo);
    // console.log(props.toChild.activityData['activityTo']);
    // console.log(item);
    // console.log(item.activityTo);
    // console.log(convertTimeToTOTotal);
    // console.log(item.activityTo.slice(-2));

    // TimeMinutes = parseInt(item.activityTo.slice(-2));
    TimeMinutes = (parseInt(item.activityTime)+convertTimeToTOTotal) % 60;
    // console.log(TimeMinutes);
    // console.log(item.activityTo);
    convertTimeToTO = ((parseactivityTo+convertTimeToTOTotal)-TimeMinutes)/60*100+TimeMinutes;
    // console.log(convertTimeToTO);
    form.activityTo.push(convertTimeToTO);
    convertTimeToTOTotal += parseInt(item.activityTime);
    // console.log(convertTimeToTOTotal);

    if (index != props.toChild.activityData['activityTo'].length-1) activityTotalRow.value++;

    // activityReference: [{title: '', medium: '', color: '', basic_id: ''}],
}

function editParentReference(item, index) {
    // console.log(index);
    // console.log(item[0]['title']);
    form.activityReference[index] = item[0]['title'];
}

function editTag(item) {
    // console.log(item);
    // console.log(item[0]['title']);
    // form.activityReference[index] = item[0]['title'];
    form.activityTag = item;
}

</script>
