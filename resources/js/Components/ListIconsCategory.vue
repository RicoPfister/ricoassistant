<template>

    <!-- medicine -->
    <svg v-if="props.category == 'medicine'" width="" height="20px" viewBox="0 0 57.023 57.023" xmlns="http://www.w3.org/2000/svg" class="w-fit">
        <g id="Group_11" data-name="Group 11" transform="translate(-999.679 -501.828)" class="flex justify-start text-start border">
            <line id="Line_19" data-name="Line 19" x1="6.732" y2="6.733" transform="translate(1002.967 548.83)" fill="lightblue" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <line id="Line_20" data-name="Line 20" x1="7.734" y2="7.733" transform="translate(1038.168 512.628)" fill="lightblue" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <path id="Path_32" data-name="Path 32" d="M1041.189,533.283h-30.965l-6.084,6.618,5.559,7.368,8.358,7.132,8-5Z" fill="lightblue"/>
            <rect id="Rectangle_3" data-name="Rectangle 3" width="38.33" height="22.548" transform="matrix(0.707, -0.707, 0.707, 0.707, 1002.508, 540.077)" fill="none" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <line id="Line_21" data-name="Line 21" x2="5.904" y2="5.902" transform="translate(1024.781 517.805)" fill="lightblue" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <line id="Line_22" data-name="Line 22" x2="4.024" y2="4.024" transform="translate(1019.951 522.636)" fill="lightblue" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <line id="Line_23" data-name="Line 23" x2="7.973" y2="7.972" transform="translate(1014.852 527.733)" fill="lightblue" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <line id="Line_24" data-name="Line 24" x2="15.943" y2="15.942" transform="translate(1037.931 504.656)" fill="lightblue" stroke="blue" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
        </g>
    </svg>

    <!-- healthiness -->
    <svg v-else-if="props.category == 'healthiness'" width="" height="20px" viewBox="-5.69 0 61.649 61.649" xmlns="http://www.w3.org/2000/svg" class="w-fit">
        <g id="Group_13" data-name="Group 13" transform="translate(-152.087 -712.814)">
            <path id="Path_36" data-name="Path 36" d="M177.757,729.582s.887-14.177,10.639-14.768C188.4,714.814,193.4,728.1,177.757,729.582Z" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <circle id="Ellipse_4" data-name="Ellipse 4" cx="19.933" cy="19.933" r="19.933" transform="translate(154.379 765.848) rotate(-80.874)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <path id="Path_37" data-name="Path 37" d="M169.5,717.814s7.764,6.744,7.722,11.583" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
        </g>
    </svg>

    <!-- psychology -->
    <svg v-else-if="props.category == 'psychology'" width="" height="20px" viewBox="0 0 51.841 51.841" xmlns="http://www.w3.org/2000/svg">
  <g id="Group_34" data-name="Group 34" transform="translate(-573.752 -1353.819)">
    <path id="Path_90" data-name="Path 90" d="M616.586,1396.654a23.92,23.92,0,1,1,0-33.828A23.92,23.92,0,0,1,616.586,1396.654Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_91" data-name="Path 91" d="M610.91,1390.978a15.893,15.893,0,1,1,0-22.477A15.891,15.891,0,0,1,610.91,1390.978Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <rect id="Rectangle_16" data-name="Rectangle 16" width="5.406" height="8.026" transform="translate(580.847 1364.737) rotate(-44.997)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <rect id="Rectangle_17" data-name="Rectangle 17" width="5.406" height="8.025" transform="translate(609.183 1393.073) rotate(-45)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <rect id="Rectangle_18" data-name="Rectangle 18" width="8.026" height="5.406" transform="translate(609.183 1366.59) rotate(-45.003)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <rect id="Rectangle_19" data-name="Rectangle 19" width="8.026" height="5.405" transform="translate(580.847 1394.926) rotate(-45)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

    <!-- social -->
    <svg v-else-if="props.category == 'social'" width="" height="20px" viewBox="0 0 55.818 55.818" xmlns="http://www.w3.org/2000/svg" class="w-fit">
        <g id="Group_6" data-name="Group 6" transform="translate(-1212.948 -289.602)">
            <path id="Path_19" data-name="Path 19" d="M1249.54,294.79s-4.5.25-5,6.25a17.908,17.908,0,0,0,2.5,10.5s2.193-1.558-.028,5.971,7.278,14.529,10.778,6.279-.5-11.783,2-12.641a33.771,33.771,0,0,0,5.382-2.6l-3.229-6.081-5.21-5.421-7.43-4.027Z" fill="orange"/>
            <path id="Path_20" data-name="Path 20" d="M1219.365,331.985s2.675-14.195,6.425-10.695.25,5.5,2.5,9,5.25,1.5,5.5,5.5.755,6.979,2.618,7.241S1222.967,339.984,1219.365,331.985Z" fill="orange"/>
            <path id="Path_21" data-name="Path 21" d="M1266.766,317.511a25.909,25.909,0,1,1-25.91-25.909A25.909,25.909,0,0,1,1266.766,317.511Z" fill="none" stroke="orange" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <path id="Path_22" data-name="Path 22" d="M1240.122,311.619a6.078,6.078,0,1,1-6.078-6.079A6.079,6.079,0,0,1,1240.122,311.619Z" fill="orange"/>
        </g>
    </svg>

    <!-- politics -->
    <svg v-else-if="props.category == 'politics'" width="" height="20px" viewBox="0 -8.97 55.248 55.248" xmlns="http://www.w3.org/2000/svg" class="w-fit">
        <g id="Group_18" data-name="Group 18" transform="translate(-999.439 -727.38)">
            <path id="Path_46" data-name="Path 46" d="M1050,729.38a2.151,2.151,0,0,0-1.773,3.371l-13.353,9.17-6.3-8.653a2.153,2.153,0,1,0-2.527,0l-6.3,8.653-13.352-9.17a2.151,2.151,0,1,0-1.773.934V762.7H1050V733.685a2.152,2.152,0,1,0,0-4.3Z" fill="#fff" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <line id="Line_27" data-name="Line 27" x2="51.248" transform="translate(1001.439 755.82)" fill="#fff" stroke="red" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
            <path id="Path_47" data-name="Path 47" d="M1014.5,748a1.978,1.978,0,1,1-1.979-1.978A1.977,1.977,0,0,1,1014.5,748Z" fill="#d1d3d4"/>
            <path id="Path_48" data-name="Path 48" d="M1029.575,748a1.978,1.978,0,1,1-1.977-1.978A1.978,1.978,0,0,1,1029.575,748Z" fill="#d1d3d4"/>
            <path id="Path_49" data-name="Path 49" d="M1043.894,748a1.978,1.978,0,1,1-1.978-1.978A1.977,1.977,0,0,1,1043.894,748Z" fill="#d1d3d4"/>
        </g>
    </svg>


    <!-- computer -->
    <svg v-else-if="props.category == 'computer'" width="" height="20px" viewBox="-1 0 55 55" xmlns="http://www.w3.org/2000/svg" class="w-fit">
  <g id="Group_23" data-name="Group 23" transform="translate(-786.357 -923.5)">
    <rect id="Rectangle_9" data-name="Rectangle 9" width="49" height="33.111" transform="translate(788.357 943.388)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <rect id="Rectangle_10" data-name="Rectangle 10" width="30.667" height="11" transform="translate(797.191 965.5)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <circle id="Ellipse_8" data-name="Ellipse 8" cx="4" cy="4" r="4" transform="translate(797.191 951.167)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <circle id="Ellipse_9" data-name="Ellipse 9" cx="4" cy="4" r="4" transform="translate(820.191 951.167)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_59" data-name="Path 59" d="M815.441,934h-4.75l-1,9.389h6.75Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <circle id="Ellipse_10" data-name="Ellipse 10" cx="5.25" cy="5.25" r="5.25" transform="translate(807.691 925.5)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

    <!-- entertainment -->
    <svg v-else-if="props.category == 'entertainment'" width="" height="20px" viewBox="0 -4.73 56.763 56.763" xmlns="http://www.w3.org/2000/svg" class="w-fit">
  <g id="Group_25" data-name="Group 25" transform="translate(-1212.645 -925.282)">
    <rect id="Rectangle_11" data-name="Rectangle 11" width="52.763" height="28.757" transform="translate(1214.645 941.827)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_31" data-name="Line 31" x2="31.529" y2="13.908" transform="translate(1232.051 927.919)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_63" data-name="Path 63" d="M1233.09,955.637a5.2,5.2,0,1,1-5.2-5.2A5.2,5.2,0,0,1,1233.09,955.637Z" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_64" data-name="Path 64" d="M1258.035,955.637a5.2,5.2,0,1,1-5.2-5.2A5.2,5.2,0,0,1,1258.035,955.637Z" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_32" data-name="Line 32" x2="3.777" transform="translate(1238.287 950.439)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

    <!-- business -->
    <svg v-else-if="props.category == 'business'" width="" height="20px" viewBox="0 -2.72 54.624 54.624" xmlns="http://www.w3.org/2000/svg" class="w-fit">
  <g id="Group_38" data-name="Group 38" transform="translate(-150.273 -1577.233)">
    <path id="Path_98" data-name="Path 98" d="M159.723,1596.869v13.651h32.746l6.107-13.651Z" fill="#d1d3d4"/>
    <path id="Path_99" data-name="Path 99" d="M152.273,1579.233h7.683v31.286h32.513l10.428-23.312h-39.26" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_100" data-name="Path 100" d="M167.668,1620.451a3.972,3.972,0,1,1-3.973-3.973A3.972,3.972,0,0,1,167.668,1620.451Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_101" data-name="Path 101" d="M187.532,1620.451a3.973,3.973,0,1,1-3.972-3.973A3.972,3.972,0,0,1,187.532,1620.451Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

    <!-- religion -->
    <svg v-else-if="props.category == 'religion'" width="" height="20px" viewBox="-0.15 0 50.298 50.298" xmlns="http://www.w3.org/2000/svg" class="w-fit">
  <g id="Group_50" data-name="Group 50" transform="translate(-1003.048 -1782.116)">
    <path id="Path_132" data-name="Path 132" d="M1026.82,1785.056v44.25h-14.667v-31.417l1.583-4.833,2.5-2.75,3.25-2.583,4.667-2.25Z" fill="#d1d3d4"/>
    <path id="Path_133" data-name="Path 133" d="M1045.6,1830.413v-28.75a17.55,17.55,0,0,0-35.1,0v28.75Z" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_53" data-name="Line 53" x2="46" transform="translate(1005.048 1830.413)" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_54" data-name="Line 54" y1="46.298" transform="translate(1028.048 1784.116)" fill="none" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_55" data-name="Line 55" y2="3.529" transform="translate(1033.57 1808.194)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

    <!-- administration -->
    <svg v-else-if="props.category == 'administration'" width="" height="20px" viewBox="-5.91 0 53.785 53.785" xmlns="http://www.w3.org/2000/svg" class="w-fit">
  <g id="Group_44" data-name="Group 44" transform="translate(-1005.07 -1571.473)">
    <rect id="Rectangle_21" data-name="Rectangle 21" width="37.955" height="45.862" transform="translate(1007.07 1577.396)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <rect id="Rectangle_22" data-name="Rectangle 22" width="27.424" height="8.923" transform="translate(1012.301 1573.473)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_48" data-name="Line 48" x2="19.406" transform="translate(1015.131 1591.345)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_49" data-name="Line 49" x2="9.03" transform="translate(1015.131 1600.777)" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

    <!-- diary -->
    <svg v-else-if="props.category == 'diary'" width="" height="20px" viewBox="0 -3.34 54.5 54.5" xmlns="http://www.w3.org/2000/svg" class="w-fit">
  <g id="Group_21" data-name="Group 21" transform="translate(-363.971 -934.155)">
    <rect id="Rectangle_8" data-name="Rectangle 8" width="50.5" height="35" transform="translate(365.971 936.155)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_54" data-name="Path 54" d="M375.971,979.966h40.5V953.155Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_55" data-name="Path 55" d="M406.471,979.966h-40.5V953.155Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <path id="Path_56" data-name="Path 56" d="M365.971,979.966l25.25-26.811,25.25,26.811Z" fill="#fff" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
    <line id="Line_30" data-name="Line 30" x2="20.82" transform="translate(372.4 943.155)" fill="#d1d3d4" stroke="#231f20" stroke-linecap="round" stroke-linejoin="round" stroke-width="4"/>
  </g>
</svg>

</template>

<script setup>

const props = defineProps(['category']);

</script>
