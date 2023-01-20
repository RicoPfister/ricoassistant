export function dateNow() {

    // Date now
    const dateData = new Date();
    const year  = dateData.getFullYear();
    const month = (dateData.getMonth() + 1).toString().padStart(2, "0");
    const day = dateData.getDate().toString().padStart(2, "0");
    const dateNow = year+'-'+month+'-'+day;

    return dateNow;
}

export function humanTime(d) {

    var h = Math.floor(d / 3600);
    var m = Math.floor((d % 3600) / 60);
    var s = Math.floor((d % 3600) % 60);

    var hDisplay = h + ":";
    var mDisplay = m.toString().padStart(2, '0') + ":";
    var sDisplay = s.toString().padStart(2, '0');

    return hDisplay + mDisplay + sDisplay;
}

export function DBToList(d) {

    let year = d.slice(0, 4);
    let month = d.slice(5, 7);
    let day = d.slice(8, 10);

    return year+'.'+month+'-'+day;
}
