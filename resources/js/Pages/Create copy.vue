// for (let p=0; p < forLoop; p++) {

    //     alert();
    // totalMinutes123 += activityDayOverviewDiagram1a.value[p];

    minutesNew = (((form.activityTo[i] - (form.activityTo[i] % 100)) / 100 * 60) + form.activityTo[i] % 100);


    // }
    // alert('old'+totalMinutes123);

        // alert('total2:'+totalMinutesOld);


        if (form.activityTo[i] != '' &&  minutesNew <= 720) {

            if (j == 1) {
                // alert('min:'+minutesNew);
                // totalMinutes123 += totalMinutesOld;
                totalMinutesOld - totalMinutes;
                // totalMinutes += minutesNew;
                totalMinutesOld += minutesNew;
                activityDayOverviewDiagram1a.value[i] = minutesNew;

        } else if (j == 0) {
            // totalMinutes123 += totalMinutesOld;
            minutesNew = (((form.activityTo[i] - (form.activityTo[i] % 100)) / 100 * 60) + form.activityTo[i] % 100);
            // totalMinutes += minutesNew;
            // alert(minutesNew);
            activityDayOverviewDiagram1a.value[i] = minutesNew;
            totalMinutesOld += minutesNew;


            j = 1;
            // alert('a:'+minutesNew);
            }


        };
            if (minutesNew > 720 && k == 0) {

                alert('yesman');
                // alert('total2:'+totalMinutes123);



                minutesNew = (((form.activityTo[i] - (form.activityTo[i] % 100)) / 100 * 60) + form.activityTo[i] % 100) - 720
                activityDayOverviewDiagram1a.value[i-1] += 720 - totalMinutes123;
                activityDayOverviewDiagram1b.value[0] = minutesNew - 720
                // alert('excess:' + minutesNew);
                totalMinutesOld += minutesNew;
                k = 1;
            }



        // totalMinutes123 += minutesNew;



        // totalMinutesOld += minutesNew;

































        for (let i = 0; i < forLoop; i++) {

// alert('test');

time = (((form.activityTo[i] - (form.activityTo[i] % 100)) / 100 * 60) + form.activityTo[i] % 100);
minutes = time - totalMinutes;

if (time < 720) {
    // alert('check1');
    activityDayOverviewDiagram1a.value[i] = minutes;
    activityDayOverviewDiagram1b.value[i] = 0;

    totalMinutes += minutes;
}

if (time == 720) {
    alert('check2');
    activityDayOverviewDiagram1a.value[i] = minutes;
    j = 1;

    totalMinutes += minutes;
}

if (time > 720 && j == 1) {
    alert('check3: ' + minutes);
    activityDayOverviewDiagram1b.value[i] = minutes;

    totalMinutes += minutes;
}

if (time > 720 && j == 0) {
    alert('check4: ' + time);
    activityDayOverviewDiagram1a.value[i] = 720 - totalMinutes;
    activityDayOverviewDiagram1b.value[i] = time - 720;
    j = 1;

    totalMinutes += minutes;
}
}
