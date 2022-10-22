<template>

<Header>

 <!-- navpath-string-tag -->
 <div class="text-sm 2xl:text-lg" >

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
    <div class=""><span class="underline">Detail View</span></div>
  </div>
</div>
</div>


    <form aria-label="New Entry Container" class="mb-10 w-full min-w-0">

        <div class="lg:w-[755px] lg:mx-auto">
            <div class="flex justify-between flex-wrap">
                <h1 class="text-xl font-bold">Detail View</h1>
                <div class="flex gap-1 grow justify-end">
                    <!-- <Button type="button">Preset</Button> -->
                    <!-- <div>&nbsp;|&nbsp;</div> -->
                    <div class="text-black-600 opacity-30">Edit</div>
                </div>
            </div>

            <div aria-label="Drop Down Basics" class="w-full min-w-0">
                <button type="button" @click="basicOpen = !basicOpen" class="mt-1 bg-gradient-to-r from-gray-300 via-gray-200 to-gray-200 flex justify-between items-center p-2 w-full">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 7.5l-9-5.25L3 7.5m18 0l-9 5.25m9-5.25v9l-9 5.25M3 7.5l9 5.25M3 7.5v9l9 5.25m0-9v9" />
                        </svg>
                        <span class="font-bold mr-2">Basics</span>
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

                        <!-- <div class="flex flex-col grow min-w-0">
                            <label aria-label="Category Input" class="w-fit" for="category">Category*:</label>
                            <input class="focus:placeholder-white grow min-w-0" size="10" id="category" type="text" placeholder="" v-model="form.category">
                        </div> -->

                        <div class="flex flex-col grow">
                            <label aria-label="Producer Input" for="producer">Producer*:</label>
                            <input class="min-w-0" type="text" id="producer" v-model="form.producer">
                        </div>
                    </div>
                    <div class="flex flex-col grow mt-3">
                        <label class="" aria-label="Category Input" for="title">Title*:</label>
                        <input class="focus:placeholder-white" id="title" type="text" placeholder="" v-model="form.title">
                    </div>
                    <div class="mt-3">*Required fields</div>
                </div>
            </div>

            <div aria-label="Drop Down Statement" class="">
                <button type="button" @click="statementOpen = !statementOpen" class="mt-4 bg-gradient-to-r from-green-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
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
                <button type="button" @click="timeTrackingOpen = !timeTrackingOpen" class="mt-4 bg-gradient-to-r from-red-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Time Tracking
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="timeTrackingOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="timeTrackingOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="timeTrackingOpen" class="flex flex-col p-3 border bg-gray-100">
                    <div class="flex flex-row gap-3">
                        <div class="w-36">
                            <label class="" aria-label="Statement Input" for="timeTracking">From: </label>
                            <div class="flex grow">
                                <input class="grow" id="timeTracking" type="time" v-model="form.timeTrackingFrom">
                            </div>
                        </div>
                        <div class="w-36">
                            <label class="" aria-label="Statement Input" for="timeTracking">To: </label>
                            <div class="flex grow">
                                <input class="grow" id="timeTracking" type="time" v-model="form.timeTrackingTo">
                            </div>
                        </div>
                        <div class="grow">
                            <label class="" aria-label="Statement Input" for="timeTracking">Sub Category: </label>
                            <div class="flex grow">
                                <input class="grow" id="timeTracking" type="text" v-model="form.timeTrackingSubCategory">
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <label class="" aria-label="Statement Input" for="timeTracking">Activity: </label>
                        <div class="flex gap-1">
                            <input class="grow" id="timeTracking" type="text" v-model="form.timeTrackingActivity">
                        </div>
                    </div>
                </div>
            </div>

            <div aria-label="Drop Down References" class="">
                <button type="button" @click="referencesOpen = !referencesOpen" class="mt-4 bg-gradient-to-r from-indigo-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
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
                </div>
            </div>

            <div aria-label="Drop Down Statement" class="">

                <button type="button" @click="tagsOpen = !tagsOpen" class="mt-4 bg-gradient-to-r from-slate-400 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
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
                    </div>

                    <div aria-label="Drop Down Statement" class="">

                        <button type="button" @click="tagsPickerOpen = !tagsPickerOpen" class="bg-gradient-to-r from-slate-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6z" />
                                </svg>
                                Tags Picker
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path v-if="tagsOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    <path v-if="tagsOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </button>

                        <div v-if="tagsPickerOpen" class="flex flex-col p-3 border bg-gray-100">
                            <label class="" aria-label="Statement Input" for="statement">Tags Picker: </label>
                            <div>Tagsmenu</div>
                        </div>

                    </div>
                </div>
            </div>

            <div aria-label="Drop Down Accounting" class="">
                <button type="button" @click="accountingOpen = !accountingOpen" class="mt-4 bg-gradient-to-r from-yellow-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
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
                    <div class="flex flex-col">
                        <label class="" aria-label="Trader Input" for="trader">Trader: </label>
                        <input class="" id="trader" type="text" v-model="form.trader">
                    </div>
                    <div class="flex flex-row mt-3 gap-3 w-full min-w-0">
                        <div class="flex flex-col grow min-w-0">
                            <label caria-label="Trader Input" for="trader">Price: </label>
                            <input class="grow min-w-0" min="0" step="any" id="trader" type="number" v-model="form.price">
                        </div>
                        <div class="flex flex-col">
                            <label aria-label="Trader Input" for="trader">Curr: </label>
                            <input class="w-16" size="5" id="trader" type="text" v-model="form.currency">
                        </div>
                        <div class="flex flex-col grow">
                            <label aria-label="Trader Input" for="trader">CHF Price: </label>
                            <input class="" min="0" step="any" id="trader" type="text" v-model="form.price_default_currency">
                        </div>
                    </div>

                </div>
            </div>

            <div aria-label="Drop Down Documents" class="">
                <button type="button" @click="documentsOpen = !documentsOpen" class="mt-4 bg-gradient-to-r from-purple-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
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

                <div v-if="documentsOpen" class="flex flex-col border bg-gray-100">

                    <div class="p-3">

                        <table class="text-left w-full table-fixed">
                            <tr class="bg-gray-300">
                                <!-- <th class="w-1/4">Article/Title</th> -->
                                <th class="w-8">#</th>
                                <th class="grow">File</th>
                                <th class="w-10">Ext</th>
                                <th class="w-20">Size</th>
                                <th class="w-40">Created at</th>
                            </tr>
                            <tr v-for="(document, index) in props.documents" :key="document.id" class="even:bg-gray-100 odd:bg-gray-200" >
                                <td>{{ index +1 }}</td>
                                <td class="truncate"><div class="truncate" @click="documentRead(document.id)" type="button">{{ document.path }}</div></td>
                                <td class="truncate"><Link href="">{{ document.extension }}</Link></td>
                                <td class="truncate"><Link href="">{{ parseFloat(document.size/1000/1000).toFixed(2) }} MB</Link></td>
                                <td class="truncate"><Link href="">{{ document.created_at }}</Link></td>
                            </tr>
                        </table>
                    </div>

                    <div aria-label="Drop Down Documents" class="">
                        <button type="button" @click="documentsMediaOpen = !documentsMediaOpen" class="bg-gradient-to-r from-purple-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Media
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path v-if="documentsMediaOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    <path v-if="documentsMediaOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </button>

                        <div v-if="documentsMediaOpen" class="flex flex-col p-3 border bg-gray-100">

                            <div v-for="(document, index) in props.documents">
                                <div class="relative">
                                    <img class="h-36" v-if="document.extension == 'jpg'" :src="'/storage/inventory/'+document.path"/>
                                    <div class="absolute bottom-0 left-0 m-2 px-1 text-sm text-white bg-black">{{ index+1 }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div aria-label="Drop Down Documents" class="">
                        <button type="button" @click="documentsAddOpen = !documentsAddOpen" class="bg-gradient-to-r from-purple-200 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full mt-3">
                            <div class="flex">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                                </svg>
                                Add Files
                            </div>
                            <div>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path v-if="documentsAddOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                    <path v-if="documentsAddOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                </svg>
                            </div>
                        </button>

                        <div v-if="documentsAddOpen" class="flex flex-col p-3 border bg-gray-100">

                            <div class="flex flex-col">
                                <label class="" aria-label="Photos Upload" for="statement">AVI:</label>
                                <input id="statement" type="file">
                            </div>
                            <div class="flex flex-col mt-3">
                                <label class="" aria-label="Photos Upload" for="statement">MP3:</label>
                                <input id="statement" type="file">
                            </div>
                            <div class="flex flex-col mt-3">
                                <label class="" aria-label="Photos Upload" for="statement">JPG/JPEG/PNG/GIF:</label>
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
                        </div>
                    </div>
                </div>
            </div>

            <div aria-label="Drop Down Rating" class="">
                <button type="button" @click="ratingOpen = !ratingOpen" class="mt-4 bg-gradient-to-r from-orange-300 via-gray-200 to-gray-200 font-bold flex justify-between items-center p-2 w-full">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-1">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                        </svg>
                        Rating
                    </div>
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path v-if="ratingOpen == 1" stroke-linecap="round" stroke-linejoin="round" d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                            <path v-if="ratingOpen == 0" stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </div>
                </button>

                <div v-if="ratingOpen" class="p-3 border bg-gray-100">
                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" color="orange" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0a7.454 7.454 0 01-.982-3.172M9.497 14.25a7.454 7.454 0 00.981-3.172M5.25 4.236c-.982.143-1.954.317-2.916.52A6.003 6.003 0 007.73 9.728M5.25 4.236V4.5c0 2.108.966 3.99 2.48 5.228M5.25 4.236V2.721C7.456 2.41 9.71 2.25 12 2.25c2.291 0 4.545.16 6.75.47v1.516M7.73 9.728a6.726 6.726 0 002.748 1.35m8.272-6.842V4.5c0 2.108-.966 3.99-2.48 5.228m2.48-5.492a46.32 46.32 0 012.916.52 6.003 6.003 0 01-5.395 4.972m0 0a6.726 6.726 0 01-2.749 1.35m0 0a6.772 6.772 0 01-3.044 0" />
                            </svg>
                            <div>Quality: {{form.rating_quality}}</div>
                        </div>
                        <div class="flex items-center w-full min-w-0 flex-wrap">
                            <label class="mr-1 hidden lg:block" for="rating_quality">Bad</label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="-10" max="10" step="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_quality">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality">Good</label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="red" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <div>Happyness: {{form.rating_happyness}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality">Bad</label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="-10" max="10" step="1" class="grow" id="rating_quality" v-model="form.rating_happyness">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality">Good</label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>

                    <div class="items-center flex mb-3 w-full flex-col">
                        <div class="flex items-center w-full  justify-start">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" color="blue" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75a4.5 4.5 0 01-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 11-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 016.336-4.486l-3.276 3.276a3.004 3.004 0 002.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008z" />
                            </svg>
                            <div class="">Usability: {{form.rating_usability}}</div>
                        </div>
                        <div class="flex items-center w-full">
                            <label class="mr-1 hidden lg:block" for="rating_quality">Bad</label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="-10" max="10" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_usability">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality">Good</label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
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
                            <label class="mr-1 hidden lg:block" for="rating_quality">Bad</label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="-10" max="10" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_developement">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality">Good</label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
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
                            <label class="mr-1 hidden lg:block" for="rating_quality">Bad</label><label class="mr-1 block lg:hidden" for="rating_quality">-</label>
                            <div class="flex items-center bg-gray-200 rounded-3xl p-1 px-2 grow min-w-0">
                                <input type="range" min="-10" max="10" step="1" size="1" class="grow min-w-0" id="rating_quality" v-model="form.rating_sustainability">
                            </div>
                            <label class="ml-1 hidden lg:block" for="rating_quality">Good</label><label for="rating_quality" class="ml-1 block lg:hidden">+</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-1 mt-3 justify-between">
                <!-- <div>Preset</div>
                <div>&nbsp;|&nbsp;</div> -->
                <Link @click="deleteForm(props.detail.id)" type="button" class="text-red-600 hover:text-red-800" >Delete Entry</Link>
                <Button @click="editForm" type="button" class="text-green-600" hover:text-green-800 :disabled="form.processing">Update Entry</Button>

            </div>

            <!-- <select id="category" v-model="form.category">
                <option value="Accounting/Fact/Media" disabled>Choose Preset</option>
                <option value="Opinion/Diary">Opinion/Diary</option>
                <option value="Accounting/Fact/Media">Accounting/Fact</option>
                <option value="Time Tracking">Time Tracking</option>
            </select> -->

        </div>
    </form>

</Header>
<!-- <input></input> -->

</template>

<script setup>

import { useForm, Link } from '@inertiajs/inertia-vue3';
import { ref, onMounted, computed  } from 'vue';

import Header from "../Layouts/MainNav.vue";

import { Inertia, Method } from "@inertiajs/inertia";

const props = defineProps(['detail', 'documents']);

const data = new FormData();

const dateNow = new Date();
const year  = dateNow.getFullYear();
const month = (dateNow.getMonth() + 1).toString().padStart(2, "0");
const day = dateNow.getDate().toString().padStart(2, "0");

const form = useForm({
    ref_date: props.detail.ref_date,
    // category: '',
    producer: props.detail.producer,
    title: props.detail.title,

    statement: props.detail.statement,

    timeTrackingFrom: props.detail.timeTrackingFrom,
    timeTrackingTo: props.detail.timeTrackingTo,
    timeTrackingSubCategory: props.detail.timeTrackingSubCategory,
    timeTrackingActivity: props.detail.timeTrackingActivity,

    reference: props.detail.reference,

    tag: props.detail.tag,

    trader: props.detail.trader,
    price: props.detail.price,
    currency: props.detail.currency,
    price_default_currency: props.detail.price_default_currency,

    rating_quality: props.detail.rating_quality,
    rating_happyness: props.detail.rating_happyness,
    rating_usability: props.detail.rating_usability,
    rating_developement: props.detail.rating_developement,
    rating_sustainability: props.detail.rating_sustainability,
});

onMounted(() => {
    document.addEventListener('keydown', function (event) {
    if (event.ctrlKey && event.altKey && event.key === 'y') {
        form.ref_date = '2022-01-01';
        form.producer = 'Rico Pfister';
        form.title = 'Velofahrt';

        form.statement = 'Ich war Velofahren.';

        form.timeTrackingFrom = '13:00';
        form.timeTrackingTo = '17:00';
        form.timeTrackingSubCategory = 'Sport';
        form.timeTrackingActivity = 'Biking';

        form.reference = '1';

        form.tag = '#Wetter: Sonne';

        form.trader = 'Amazon';
        form.price = '234.50';
        form.currency = 'EUR';
        form.price_default_currency = '100.75';

        form.rating_quality = '-1';
        form.rating_happyness = '-8';
        form.rating_usability = '2';
        form.rating_developement = '4';
        form.rating_sustainability = '10';
    };
    });
});

let basicOpen = ref(1);
let statementOpen = ref(0);
let timeTrackingOpen = ref(0);
let referencesOpen = ref(0);
let tagsOpen = ref(0);
let tagsPickerOpen = ref(0);
let accountingOpen = ref(0);
let documentsOpen = ref(0);
let documentsMediaOpen = ref(1);
let documentsAddOpen = ref(0);
let ratingOpen = ref(0);

function deleteForm(id) {

    let obj = {
        id: props.detail.id,
    };

    Inertia.post('delete', obj);
}

function editForm() {

    // const formFieldValue = formField;

// alert(entryID);
let obj = {
    id: props.detail.id,
};

if(form.ref_date != props.detail.ref_date) obj.ref_date = form.ref_date;
if(form.producer  != props.detail.producer) obj.producer = form.producer ;
if(form.title != props.detail.title) obj.title = form.title;

if(form.statement != props.detail.statement) obj.statement = form.statement;

if(form.timeTrackingFrom != props.detail.timeTrackingFrom) obj.timeTrackingFrom = form.timeTrackingFrom;
if(form.timeTrackingTo != props.detail.timeTrackingTo) obj.timeTrackingTo = form.timeTrackingTo;
if(form.timeTrackingSubCategory != props.detail.timeTrackingSubCategory) obj.timeTrackingSubCategory = form.timeTrackingSubCategory;
if(form.timeTrackingActivity != props.detail.timeTrackingActivity) obj.timeTrackingActivity = form.timeTrackingActivity;

if(form.reference != props.detail.reference) obj.reference = form.reference;

if(form.tag != props.detail.tag) obj.tag = form.tag;

if(form.trader != props.detail.trader) obj.trader = form.trader;
if(form.price != props.detail.price) obj.price = form.price;
if(form.currency != props.detail.currency) obj.currency = form.currency;
if(form.price_default_currency != props.detail.price_default_currency) obj.price_default_currency = form.price_default_currency;

if(form.rating_quality != props.detail.rating_quality) obj.rating_quality = form.rating_quality;
if(form.rating_happyness != props.detail.rating_happyness) obj.rating_happyness = form.rating_happyness;
if(form.rating_usability != props.detail.rating_usability) obj.rating_usability = form.rating_usability;
if(form.rating_developement != props.detail.rating_developement) obj.rating_developement = form.rating_developement;
if(form.rating_sustainability != props.detail.rating_sustainability) obj.rating_sustainability = form.rating_sustainability;

// Object.keys(form).forEach(key => {

// });

// alert(obj.title);



    Inertia.post('update', obj);
}

</script>
