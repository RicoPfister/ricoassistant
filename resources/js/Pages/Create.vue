<template>

    <Header>

 <!-- navpath-string-tag -->
 <div class="text-sm lg:text-lg" >

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
    <div class="underline"><span class="">New Entry</span></div>
  </div>
</div>
</div>

    <form aria-label="New Entry Container" class="mb-10 w-full min-w-0">

        <div class="lg:w-[755px] lg:mx-auto">
            <div class="flex justify-between flex-wrap">
                <h1 class="text-xl font-bold">New Entry</h1>
                <div class="flex gap-1 grow justify-end">
                    <!-- <Button type="button">Preset</Button> -->
                    <!-- <div>&nbsp;|&nbsp;</div> -->
                    <div class="text-black-600 opacity-30">Preset</div>
                </div>
            </div>

            <div aria-label="Drop Down Basics" class="w-full min-w-0">
                <button type="button" @click.prevent="basicOpen = !basicOpen" class="mt-1 bg-gradient-to-r from-gray-300 via-gray-200 to-gray-200 flex justify-between items-center p-2 w-full">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                        <span class="font-bold mr-2 ">Basics</span>
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="basicOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="basicOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="basicOpen" class="bg-gray-100 p-3 w-full min-w-0">
                    <div class="flex gap-3 flex-wrap w-full min-w-0">
                        <div class="flex flex-col">
                            <label aria-label="Referenced Date Input" for="acc_date">Referenced Date*:</label>
                            <input class="w-[141px]" id="acc_date" placeholder="Search" type="date" v-model="form.ref_date">
                        </div>

                        <div class="flex flex-col grow">
                            <label aria-label="Author Input" for="author">Author*:</label>
                            <input class="min-w-0" type="text" id="author" v-model="form.author">
                        </div>

                        <div class="flex flex-col min-w-0 ">
                            <label aria-label="Category Input" class="w-fit" for="subject">Category*:</label>
                            <select id="subject" v-model="form.category">
                                <option value="Accounting/Fact/Media" disabled>Choose a Category</option>
                                <option value="medicine">Medicine</option>
                                <option value="healthiness">Healthiness</option>
                                <option value="psychology">Psychology</option>
                                <option value="social">Social</option>
                                <option value="politics">Politics</option>
                                <option value="computer">Computer</option>
                                <option value="entertainment">Entertainment</option>
                                <option value="business">Business</option>
                                <option value="religion">Religion</option>
                                <option value="administration">Administration</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-row mt-3 gap-3">

                        <div class="flex flex-col min-w-0">
                            <label aria-label="Category Input" class="w-fit" for="subject">Subject*:</label>
                            <select id="subject" v-model="form.subject">
                                <option value="Accounting/Fact/Media" disabled>Choose a Subject</option>
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
                                    <option value="passive">External Manipulation</option>
                                </optgroup>
                            </select>
                        </div>

                        <div class="grow">
                            <div class="flex flex-col grow">
                                <label class="" aria-label="Category Input" for="title">Title*:</label>
                                <input class="focus:placeholder-white" id="title" type="text" placeholder="" v-model="form.title">
                            </div>
                        </div>

                    </div>

                    <div class="flex justify-between">
                        <div class="mt-3 text-red-600" v-if="$page.props.errors.ref_date">*Please fill out all marked fields</div>
                        <div class="mt-3 text-red-600" v-else-if="$page.props.errors.focus">*Please fill out all marked fields</div>
                        <div class="mt-3 text-red-600" v-else-if="$page.props.errors.author">*Please fill out all marked fields</div>
                        <div class="mt-3 text-red-600" v-else-if="$page.props.errors.title">*Please fill out all marked fields</div>
                        <div class="mt-3" v-else>*Required fields</div>
                        <div class="flex flex-row mt-3 items-center">
                            <label class="mr-1" for="public">Public:</label>
                            <input type="checkbox" id="public" true-value="1" false-value="" v-model="form.status">
                        </div>

                    </div>

                </div>
            </div>

            <div aria-label="Drop Down Statement" class="">
                <button type="button" @click.prevent="statementOpen = !statementOpen" class="mt-4 bg-gradient-to-r from-green-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                        Statement
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="statementOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="statementOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="statementOpen" class="flex flex-col p-3 border bg-gray-100">
                    <label class="" aria-label="Statement Input" for="statement">Statement: </label>
                    <textarea rows="10" id="statement" type="text" v-model="form.statement"></textarea>
                </div>
            </div>

            <div aria-label="Drop Down Statement" class="">
                <button type="button" @click.prevent="activityOpen = !activityOpen" class="mt-4 bg-gradient-to-r from-red-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Activity
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="activityOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="activityOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="activityOpen" class="flex flex-col px-3 pb-1 border bg-gray-100 text-sm">

                    <div class="flex gap-1 h-8 mt-2" v-for="n in activityTotalRow" @input="activityRowAdd(n)" @keyup.exact="activityKeyPressed($event, n)" @keyup.shift.arrow-up="activityKeyShUpPressed(1, n)" @keyup.shift.arrow-down="activityKeyShDownPressed(1, n)">

                        <input class="w-[58px] text-sm xl:text-lg text-center p-1" :id="'activityToRowNumber'+[n-1]" maxlength="4" @keypress="onlyNumbers($event)" pattern="{0-90-90-90-9}" type="text" placeholder="To" v-model="form.activityTo[n-1]">

                        <div class="flex gap-1 flex-row">

                            <!-- button clear/12h-->
                            <div class="flex flex-col">

                                <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="form.activityTo[n-1] = ''">
                                    <div class="text-xs flex items-center justify-center h-full">C</div>
                                </button>

                                <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="form.activityTo[n-1] = 1200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                                    </svg>
                                </button>

                            </div>

                            <!-- button hours -->
                            <div class="flex flex-col h-full">
                                <button class="text-sm w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityButtonBar('h', n)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                </button>
                                <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityButtonBar('hMinus', n)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                    </svg>
                                </button>
                            </div>

                            <!-- button minutes -->
                            <div class="flex flex-col h-full">
                                <button class="text-sm w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityButtonBar('m', n)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                                </button>

                                <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityButtonBar('mMinus', n)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-3 h-3">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 12H6" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <input class="grow min-w-0 text-sm xl:text-lg p-2" :id="'activityReferenceRowNumber'+[n-1]" type="text" placeholder="Reference" v-model="form.activityReference[n-1]">

                        <!-- button clear reference/ delelte row -->
                        <div class="flex flex-col">

                            <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="form.activityReference[n-1] = ''">
                                <div class="text-xs flex items-center justify-center h-full">C</div>

                            </button>
                            <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityRowDelete(n)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <!-- button add row top/bottom -->
                        <div class="flex flex-col">

                            <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityRowAddAbove(n)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                            </button>
                            <button class="w-4 h-1/2 flex items-center justify-center bg-gray-200 hover:bg-gray-300" type="button" @click="activityRowAddBelow(n)">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
                                    </svg>
                            </button>
                        </div>

                        <!-- button swap -->
                        <div class="flex flex-col">

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

            <div aria-label="Drop Down References" class="">
                <button type="button" @click.prevent="referencesOpen = !referencesOpen" class="mt-4 bg-gradient-to-r from-indigo-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                        </svg>
                        References
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="referencesOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="referencesOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="referencesOpen" class="flex flex-col p-3 border bg-gray-100">
                    <label class="" aria-label="Statement Input" for="statement">References: </label>
                    <input rows="10" id="statement" type="text" v-model="form.reference">
                    <div class="mt-1">Separate References with ;</div>
                </div>
            </div>

            <div aria-label="Drop Down Statement" class="">
                <button type="button" @click.prevent="tagsOpen = !tagsOpen" class="mt-4 bg-gradient-to-r from-slate-400 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                        </svg>
                        Tags
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="tagsOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="tagsOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="tagsOpen" class="flex flex-col border w-full">
                    <div class="p-3 bg-gray-100 w-full flex flex-col">
                        <label class="" aria-label="Statement Input" for="tags">Tags: </label>
                        <input class="grow" id="tags" type="text" v-model="form.tag">
                        <div class="mt-1">Separate Tags with #</div>
                    </div>


                </div>

            </div>

            <div aria-label="Drop Down Accounting" class="">
                <button type="button" @click.prevent="accountingOpen = !accountingOpen" class="mt-4 bg-gradient-to-r from-yellow-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18.75a60.07 60.07 0 0115.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 013 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 00-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 01-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 003 15h-.75M15 10.5a3 3 0 11-6 0 3 3 0 016 0zm3 0h.008v.008H18V10.5zm-12 0h.008v.008H6V10.5z" />
                        </svg>
                        Accounting
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="accountingOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="accountingOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="accountingOpen" class="flex flex-col p-3 border bg-gray-100 w-full min-w-0">
                    <div class="flex flex-row gap-3">
                        <div class="flex flex-col grow">
                            <label class="" aria-label="Producer Input" for="producer">Producer: </label>
                            <input class="" id="producer" type="text" v-model="form.accounting_producer">
                        </div>
                        <div class="flex flex-col grow">
                            <label class="" aria-label="Trader Input" for="trader">Trader: </label>
                            <input class="" id="trader" type="text" v-model="form.accounting_trader">
                        </div>
                    </div>

                    <!-- <div class="flex flex-col grow mt-3">
                            <label class="" aria-label="Source/Location Input" for="location">Source/Location: </label>
                            <input class="" id="location" type="text" v-model="form.location">
                        </div> -->

                    <div class="flex flex-row mt-3 gap-3 w-full min-w-0">
                        <div class="flex flex-col grow min-w-0">
                            <label caria-label="Trader Input" for="trader">Price: </label>
                            <input class="grow min-w-0" min="0" step="any" id="trader" type="number" v-model="form.accounting_price">
                        </div>
                        <div class="flex flex-col">
                            <label aria-label="Trader Input" for="trader">Curr: </label>
                            <input class="w-16" size="5" id="trader" type="text" v-model="form.accounting_currency">
                        </div>
                        <div class="flex flex-col grow">
                            <label aria-label="Trader Input" for="trader">CHF Price: </label>
                            <input class="" min="0" step="any" id="trader" type="text" v-model="form.accounting_price_default_currency">
                        </div>
                    </div>

                </div>
            </div>

            <div aria-label="Drop Down Documents" class="">
                <button type="button" @click.prevent="documentsOpen = !documentsOpen" class="mt-4 bg-gradient-to-r from-purple-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        Documents
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="documentsOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="documentsOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="documentsOpen" class="flex flex-col p-3 border bg-gray-100">
                    <div class="flex flex-col">
                        <label class="" aria-label="Photos Upload" for="statement">AVI:</label>
                        <input id="statement" type="file">
                    </div>
                    <div class="flex flex-col mt-3">
                        <label class="" aria-label="Photos Upload" for="statement">JPG/JPEG/PNG/GIF:</label>
                        <input id="statement" type="file" @input="form.documentJPG = $event.target.files; Browse.PreviewFiles" multiple>
                    </div>
                    <div class="flex flex-col mt-3">
                        <label class="" aria-label="Photos Upload" for="statement">MP3:</label>
                        <input id="statement" type="file">
                    </div>
                    <div class="flex flex-col mt-3">
                        <label class="" aria-label="Photos Upload" for="statement">PDF:</label>
                        <input id="statement" type="file">
                    </div>
                    <div class="flex flex-col mt-3">
                        <label class="" aria-label="Photos Upload" for="statement">Txt:</label>
                        <input id="statement" type="file">
                    </div>
                    <div class="flex flex-col mt-3">
                        <label class="" aria-label="Photos Upload" for="statement">ZIP:</label>
                        <input id="statement" type="file">
                    </div>
                    <div class="flex flex-col mt-3">
                        <label class="" aria-label="Photos Upload" for="statement">Website Link:</label>
                        <input id="statement" type="text" v-model="form.document_link">
                        <div class="mt-1">Separate Links with ;</div>
                    </div>
                </div>

            </div>

            <div aria-label="Drop Down Rating" class="">
                <div class="relative mt-4 bg-gradient-to-r from-orange-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex items-center">
                        <button type="button" @click.prevent="ratingOpen = !ratingOpen" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                        </svg>
                        Rating
                    </button>

                        <div @click.prevent="tooltipRatingOpen = !tooltipRatingOpen">

                            <!-- tooltip info icon -->
                        <svg  xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 ml-1">
  <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
</svg>
</div>


                        <Tooltip_Rating v-if="tooltipRatingOpen"/>



                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="ratingOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="ratingOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </div>

                <div v-if="ratingOpen" class="p-3 border bg-gray-100">

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" color="orange" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                            </svg>
                            <div>Comparison: {{form.rating_comparison}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow" id="rating_quality" v-model="form.rating_comparison">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <div>Happiness: {{form.rating_happiness}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow" id="rating_quality" v-model="form.rating_happiness">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <div>Sadness: {{form.rating_sadness}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow" id="rating_quality" v-model="form.rating_sadness">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>Quality: {{form.rating_quality}}</div>
                        </div>
                        <div class="flex items-center w-full min-w-0 flex-wrap">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_quality">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>Ingenuity: {{form.rating_ingenuity}}</div>
                        </div>
                        <div class="flex items-center w-full min-w-0 flex-wrap">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_ingenuity">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <div>Originality: {{form.rating_originality}}</div>
                        </div>
                        <div class="flex items-center w-full min-w-0 flex-wrap">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_originality">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75h-4.5m4.5 0v4.5m0-4.5L15 9m5.25 11.25h-4.5m4.5 0v-4.5m0 4.5L15 15" />
                            </svg>
                            <div>Complexity: {{form.rating_complexity }}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow" id="rating_quality" v-model="form.rating_complexity ">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />
                            </svg>
                            <div>Simplicity: {{form.rating_simplicity}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" class="grow" id="rating_quality" v-model="form.rating_simplicity">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full  justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" color="blue" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>
                            <div class="">Usability: {{form.rating_usability}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_usability">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full  justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="blue" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>
                            <div class="">Versatility: {{form.rating_versatility}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_versatility">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-wrap min-w-0">
                        <div class="flex items-center w-60 sm:w-68">
                            <svg xmlns="http://www.w3.org/2000/svg" color="purple" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 19.5l15-15m0 0H8.25m11.25 0v11.25" />
                            </svg>
                            <div>Developement: {{form.rating_developement}}</div>
                        </div>
                        <div class="flex items-center w-full min-w-0">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_developement">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-wrap min-w-0">
                        <div class="flex items-center w-60 sm:w-68">
                            <svg xmlns="http://www.w3.org/2000/svg" color="green" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 12.75c1.148 0 2.278.08 3.383.237 1.037.146 1.866.966 1.866 2.013 0 3.728-2.35 6.75-5.25 6.75S6.75 18.728 6.75 15c0-1.046.83-1.867 1.866-2.013A24.204 24.204 0 0112 12.75zm0 0c2.883 0 5.647.508 8.207 1.44a23.91 23.91 0 01-1.152 6.06M12 12.75c-2.883 0-5.647.508-8.208 1.44.125 2.104.52 4.136 1.153 6.06M12 12.75a2.25 2.25 0 002.248-2.354M12 12.75a2.25 2.25 0 01-2.248-2.354M12 8.25c.995 0 1.971-.08 2.922-.236.403-.066.74-.358.795-.762a3.778 3.778 0 00-.399-2.25M12 8.25c-.995 0-1.97-.08-2.922-.236-.402-.066-.74-.358-.795-.762a3.734 3.734 0 01.4-2.253M12 8.25a2.25 2.25 0 00-2.248 2.146M12 8.25a2.25 2.25 0 012.248 2.146M8.683 5a6.032 6.032 0 01-1.155-1.002c.07-.63.27-1.222.574-1.747m.581 2.749A3.75 3.75 0 0115.318 5m0 0c.427-.283.815-.62 1.155-.999a4.471 4.471 0 00-.575-1.752M4.921 6a24.048 24.048 0 00-.392 3.314c1.668.546 3.416.914 5.223 1.082M19.08 6c.205 1.08.337 2.187.392 3.314a23.882 23.882 0 01-5.223 1.082" />
                            </svg>
                            <div>Sustainability: {{form.rating_sustainability}}</div>
                        </div>
                        <div class="flex items-center w-full min-w-0">
                            <label class="mr-1 hidden lg:block" for="rating_quality"></label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="0" max="99" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_sustainability">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality"></label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex gap-1 mt-3 justify-between">
                <!-- <div>Preset</div>
                <div>&nbsp;|&nbsp;</div> -->
                <Button type="reset" class="text-red-600 hover:text-red-800" :disabled="form.processing">Reset Entry</Button>
                <Button type="button" @click.prevent="sendForm" class="text-green-600 hover:text-green-800" :disabled="form.processing">Add Entry</Button>
            </div>

        </div>
    </form>

</Header>
<!-- <input></input> -->

</template>

<script setup>

import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed, watch  } from 'vue';
import { Inertia, Method } from "@inertiajs/inertia";

import Header from "../Layouts/MainNav.vue";

import Tooltip_Rating from "../Components/Tooltips/Rating.vue";

const data = new FormData();

const dateNow = new Date();
const year  = dateNow.getFullYear();
const month = (dateNow.getMonth() + 1).toString().padStart(2, "0");
const day = dateNow.getDate().toString().padStart(2, "0");

const props = defineProps(['user']);

// const user = computed(() => usePage().props.value.auth.user)
// usePage().props.user.value;

// alert(user.name);

const form = useForm({
    ref_date: year+'-'+month+'-'+day,
    subject: '',
    category: '',
    author: props.user.name,
    title: '',
    status: '',

    statement: '',

    activityTo: [],
    activityReference: [],

    reference: '',

    tag: '',

    accounting_producer: '',
    accounting_trader: '',
    accounting_price: '',
    accounting_currency: '',
    accounting_price_default_currency: '',

    document_link : '',

    rating_comparison: '0',
    rating_happiness: '0',
    rating_sadness: '0',
    rating_quality: '0',
    rating_ingenuity: '0',
    rating_originality: '0',
    rating_complexity: '0',
    rating_simplicity: '0',
    rating_usability: '0',
    rating_versatility: '0',
    rating_developement: '0',
    rating_sustainability: '0',

    documentAVI: '',
    documentJPG: '',
    documentMP3: '',
    documentPDF: '',
    documentTXT: '',
    documentZIP: '',
});

onMounted(() => {
    document.addEventListener('keydown', function (event) {
    if (event.ctrlKey && event.altKey && event.key === 'y') {
        form.ref_date = '2022-01-01';
        form.author = 'Rico Pfister';
        form.subject = 'video';
        form.category = 'social';
        form.title = 'Velofahrt';

        form.statement = 'Ich war Velofahren.';

        form.activityTo = '17:00';
        form.activityReference = 'Sport';

        form.reference = '1';

        form.tag = '#Wetter: Sonne';

        form.accounting_producer = 'Rico Pfister';
        form.accounting_trader = 'Amazon';
        form.accounting_price = '234.50';
        form.accounting_currency = 'EUR';
        form.accounting_price_default_currency = '100.75';

        form.rating_comparison = '0',
        form.rating_happiness = '75';
        form.rating_sadness = '10',
        form.rating_quality = '9';
        form.rating_ingenuity = '8';
        form.rating_originality = '5';
        form.rating_complexity = '0';
        form.rating_simplicity = '1';
        form.rating_usability = '2';
        form.rating_versatility = '5'
        form.rating_developement = '50';
        form.rating_sustainability = '99';
    };
    });
});

let basicOpen = ref(1);
let statementOpen = ref(0);
let activityOpen = ref(0);
let referencesOpen = ref(0);
let tagsOpen = ref(0);
let tagsPickerOpen = ref(0);
let accountingOpen = ref(0);
let documentsOpen = ref(0);
let ratingOpen = ref(0);

let tooltipRatingOpen = ref(0);
let toTimeEndReached = ref(0);

// actvivity
// **************************************************
let activityTotalRow = ref(1);

function activityButtonBar(e, n) {

    if (isNaN(form.activityTo[n-1]) || (form.activityTo[n-1]) == '') form.activityTo[n-1] = 0
        else form.activityTo[n-1] = parseInt(form.activityTo[n-1]);

    let minutes = parseInt(form.activityTo[n-1].toString().slice(-2));

    if (minutes < 60) {

        // toTimeSet

        let toTimeOldValue = form.activityTo[n-1];

        let hours = parseInt(form.activityTo[n-1].toString().slice(0, -2));

        let toTimeAdditionalMinutes = minutes % 15;

        if (e == 'h') { form.activityTo[n-1] += 200 };

        if (e == 'hMinus') { if (form.activityTo[n-1] > 0) form.activityTo[n-1] -= 100 };

        if (e == 'm') {

            if (isNaN(hours)) hours = 0;


                if (minutes < 45) form.activityTo[n-1] += 15
                else { hours += 1; minutes = 0; form.activityTo[n-1] = hours * 100 + toTimeAdditionalMinutes };
        }

        else if (e == 'mMinus') {

            if (form.activityTo[n-1] > 0) {

                if (form.activityTo[n-1].toString().slice(-2) > 0) form.activityTo[n-1] -= 1;
                else form.activityTo[n-1] -= 41;
            }
        };

        // min and max time adjustments
        // ****************************************************************

        // check if stored time was 2400 and go to 0 plus minutes
        if ( toTimeOldValue == 2400 ) {

            if (e == 'h') { form.activityTo[n-1] = 200 + minutes } else { form.activityTo[n-1] = 15 + toTimeAdditionalMinutes }
        }

        // top reached - check if time has passed max of 2400
        else if (form.activityTo[n-1] > 2400) {

            if (e == 'h') { form.activityTo[n-1] = form.activityTo[n-1] - 2400 } else { form.activityTo[n-1] = form.activityTo[n-1] - 2400};

        }

        // bottom reached - check if time has passed min value of 0
        if (form.activityTo[n-1] < 0) {

            // from minus to top
            if (e == 'hMinus') { form.activityTo[n-1] = 2300 + toTimeAdditionalMinutes } else { form.activityTo[n-1] = 2300 + toTimeAdditionalMinutes }
        }

        else if ( ((form.activityTo[n-1] < 0 || (toTimeOldValue == 0 && typeof form.activityTo[n-1] !== 'undefined' ))) && ( e == 'hMinus' || e == 'mMinus' ) ) {

            if (e == 'hMinus') { form.activityTo[n-1] = 2400 - 100 - toTimeAdditionalMinutes } else { form.activityTo[n-1] = 2360 - 1 - toTimeAdditionalMinutes }
        }
    }

    if (form.activityTo[n-1] > 0 && !document.getElementById("activityToRowNumber"+(n)) ) activityTotalRow.value++;
    else if (form.activityTo[n-1] == 0 && form.activityReference[n-1] !== 'undefined' ) activityTotalRow.value--;
}

// only number keys allowed
function onlyNumbers(e) {

    if(!e.key.match(/[0-9]/)) e.preventDefault();
}

function activityRowAdd(n) {

    // add row
    if (!document.getElementById("activityToRowNumber"+(n)) && form.activityTo[n-1] < 2400 && form.activityTo[n-1] !='0000' && form.activityTo[n-1].match(/..[0-5][0-9]/) && document.getElementById("activityToRowNumber"+(n-1)).value.length == 4) activityTotalRow.value++;

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
        activityRowAddAbove(n)
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

// activity functions

function activityRowDelete(n) {
    if(activityTotalRow.value > 1) {
        form.activityTo.splice(n-1, 1);
        form.activityReference.splice(n-1, 1);
        activityTotalRow.value--
    } else {
        form.activityTo.splice(0, 1, '');
        form.activityReference.splice(0, 1, '');
    }
}

function activityRowAddAbove(n) {
    form.activityTo.splice(n-1, 1, form.activityTo[n-1], form.activityTo[n-1]);
    activityTotalRow.value++
}

function activityRowAddBelow(n) {
    form.activityTo.splice(n-1, 1, form.activityTo[n-1], form.activityTo[n-1] );
    activityTotalRow.value++
}

// watch(form.activityTo, (newValue, oldValue) => {
//  alert('change');
// })

// sendform
// **************************************************

function sendForm() {

    let requestObj = {};

    Object.keys(form).forEach(key => {
        if (form[key] != '' && form[key] != '0') requestObj[key] = form[key];
    });

    Inertia.post('store', requestObj);
}

</script>
