
<template>

<!-- activity container -->
<!-- ------------------------------------------------ -->
<div aria-label="Activity" class="relative flex flex-col border-l border-b border-r border-gray-400 bg-white text-sm
w-full pt-4 gap-2 mt-[12px] pb-3">

    <!-- container border title -->
    <div class="absolute -top-[12px] flex items-center -left-[1px] w-[calc(100%+2px)]">
        <div class="flex items-center grow">
            <span class="border-t border-gray-400 w-1"></span>
            <h2 class="text-black font-bold text-base rounded-3xl px-1">Activity*<span class="font-normal"></span></h2>
            <span class="border-t border-gray-400 flex-1"></span>
        </div>
        <div class="flex items-center justify-end w-fit px-1">
            <MenuEntry @data-child="dataChildMenuEntry"/>
        </div>
        <span class="border-t border-gray-400 w-1"></span>
    </div>

    <!-- time schedule box-->
    <!-- ------------------------------------------------ -->
    <div class="flex flex-col items-center gap-1 w-full mt-1">

        <!-- time schedule list builder -->
        <div class="flex flex-row lg:h-8 w-[722px]" v-for="n in activityTotalRow" @input="activityRowAdd(n)"
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
            <div class="relative w-full min-w-0 text-sm lg:text-lg h-8 border border-black">
                <input @input="referenceChecker(n, 'inputCheck')" class="cursor-text w-full min-w-0 grow leading-none border-none placeholder:text-gray-400 focus:placeholder-white focus:border-current focus:ring-0 pr-1 lg:pr-2 pl-7 lg:pl-10 h-full" :id="'activityReferenceRowNumber'+[n-1]" type="text" placeholder="Reference (e.g. Title)" v-model="form.activityReference[n-1].title">

                <!-- input reference menu button -->
                <div class="absolute top-0 left-0 w-fit h-full flex items-center bg-gray-200 border-r border-gray-400 p-1">

                    <button type="button" @click="referenceChecker(n, 'lastUsed')" class="w-auto h-full">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-auto h-full">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 010 3.75H5.625a1.875 1.875 0 010-3.75z" />
                        </svg>
                    </button>

                </div>

                <!-- reference picker popup -->
                <div v-if="referencePickerOpen[n-1]" class="z-50 absolute top-0 left-0 mt-8 h-fit w-full bg-white border-r border-b border-l border-gray-400 p-1 flex flex-col">

                    <div class="flex flex-row items-center z-50">

                        <div class="text-sm xl:text-base z-50 w-full max-h-52 overflow-y-auto">

                            <div class="text-sm"><b>Found in Database:</b></div>

                            <div v-for="item in props.fromController.referencesResult" class="flex flex-row items-center w-full">

                                <button>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hover:stroke-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </button>

                                <!-- button reference picker -->
                                <button type="button" @click.prevent="form.activityReference[n-1] = {id: item.id}; form.activityReference[n-1].title = item.title; activityDiagramColorTag[n-1] = item.color, referencePickerOpen[n-1] = !referencePickerOpen[n-1]" class="ml-1 text-gray-500 hover:text-black truncate"><div class="truncate">{{ item.title }}</div></button>
                            </div>

                        </div>
                    </div>
                </div>
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

                <!-- button swap -->
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
        </div>
    </div>

    <!-- day overview box -->
    <!-- ------------------------------------------------ -->
    <div aria-label="Drop Down Activity Day Overview" class="">

        <div class="flex z-20 w-full justify-center whitespace-nowrap overflow-x-auto">

            <!-- diagram box -->
            <div class="flex flex-col">

                <div class="relative w-[722px] border border-gray-300 h-5 flex flex-row text-gray-500 z-20 bg-white">
                    <div v-for="(width, index) in activityDayOverviewDiagram1a" :key="'A'+index" class="flex flex-row">
                        <div class="h-full bg-stone-300 flex" :style="{ width: width['minute']+'px', background: activityDiagramColorTag[width['row']] }"></div>
                    </div>

                    <!--0-12 disgram -->
                    <div class="absolute top-0 left-0 h-full pl-1 flex items-center">
                        0
                    </div>

                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-full">

                    </div>

                    <div class="absolute top-0 right-0 h-full pr-1 flex items-center">
                        12
                    </div>

                </div>

                <div class="relative w-[722px] border border-gray-300 h-5 flex flex-row text-gray-500 z-20 mt-1 bg-white">
                    <div v-for="(width, index) in activityDayOverviewDiagram1b" :key="'B'+index" class="flex flex-row">
                        <div class="h-full bg-stone-300" :style="{ width: width['minute']+'px', background: activityDiagramColorTag[width['row']] }"></div>
                    </div>

                    <!-- 12-24 day diagram -->
                    <div class="absolute top-0 left-0 h-full pl-1 flex items-center">
                        12
                    </div>

                    <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 h-full">

                    </div>

                    <div class="absolute top-0 right-0 h-full pr-1 flex items-center">
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

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch, onBeforeUnmount, reactive, onUnmounted } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import MenuEntry from "../Create/MenuEntry.vue";

// import Tooltip_Rating from "../Components/Tooltips/Rating.vue";

const data = new FormData();

const dateNow = new Date();
const year  = dateNow.getFullYear();
const month = (dateNow.getMonth() + 1).toString().padStart(2, "0");
const day = dateNow.getDate().toString().padStart(2, "0");

// const props = defineProps(['user', 'referencesResult', 'misc', 'basicResult']);
const props = defineProps(['fromParent', 'fromController']);
const emit = defineEmits(['toParent', 'dataChild']);

const form = useForm({
    activityTo: [],
    activityReference: [{title: '', id: ''}],
    reference: '',
    tag: '',
});

let referencePickerOpen = ref([]);
let activiteTolimitReached = ref(0);
let activityTotalRow = ref(1);
let activityDayOverviewDiagram = ref([]);
let activityDayOverviewDiagram1a = ref([]);
let activityDayOverviewDiagram1b = ref([]);
let activityDiagramColorTag = ref([]);

// button functions
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
                if (form.activityTo[n-1].toString().slice(-2) > 0) {
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
        form.activityReference[n] = [{title: '', id: ''}];
    }

    else if (form.activityTo[n-1] == 2400 && activiteTolimitReached.value == 1 && document.getElementById("activityToRowNumber"+(n)) && form.activityTo[n] == '' && (typeof form.activityReference[n].title == 'undefined' || form.activityReference[n].title == '')) {
        activityTotalRow.value--;
        activiteTolimitReached.value = 0;
    }
}

// only number keys allowed
function onlyNumbers(e) {
    if(!e.key.match(/[0-9]/)) e.preventDefault();
}

function activityRowAdd(n) {

    // add row
    if (!document.getElementById("activityToRowNumber"+(n)) && form.activityTo[n-1] < 2400 && form.activityTo[n-1] !='0000' && form.activityTo[n-1].match(/..[0-5][0-9]/) && document.getElementById("activityToRowNumber"+(n-1)).value.length == 4) activityTotalRow.value++;

    referencePickerOpen.value[n-1] = 0;
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

//! watch for diagram width adjustments and add title/medium in basics.vue
watch(() => form.activityTo, (curr, prev) => {

    // set basic title and medium

    emit('toParent', {'basicTitle': 'Activity ' + year+'-'+month+'-'+day, 'basicMedium': 'self_awareness'});
    // console.log('ok');

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

}, {deep: true}, 500);

// listening fromController
// watch(() => props.fromController, (curr, prev) => {

//     if (props.fromController.referencesResult) {
//         console.log(props.fromController.referencesResult);
//     }

// }, {deep: true}, 500);

// activity controller
// ------------------------------------------------

// activity row response
watch(() => props.fromController, _.debounce( (curr, prev) => {

if (props.fromController.misc) {
    referencePickerOpen.value[props.fromController.misc.row-1] = 1;
}

}, 500)
);




// activity reference checker
function referenceChecker(n, le) {

    // cl(form.activityReference[n-1].id);

    if (le == 'lastUsed' && ( referencePickerOpen.value[n-1] == 0 || typeof referencePickerOpen.value[n-1] == 'undefined' )) {

        Inertia.post('refcheck', { activityReference: le, row: n }, {replace: true,  preserveState: true, preserveScroll: true});
    }

    else if (referencePickerOpen.value[n-1] == 1) referencePickerOpen.value[n-1] = 0;

    else if (form.activityReference[n-1].title.length > 2) {

        setTimeout(() => {
            Inertia.post('refcheck', { activityReference: form.activityReference[n-1].title, row: n}, {replace: false,  preserveState: true, preserveScroll: true});
        }, 500);
    }
}

function dataChildMenuEntry(n) {
    // alert(n['formDataEdit']);
    // alert(props.componentId);
    if (n['formDataEdit'] == 1) emit('dataChild', {'formDataEdit': 1});
    if (n['formDataEdit'] == 2) emit('dataChild', {'delete': props.componentId+1});
}

</script>

