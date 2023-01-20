export function dateNow() {

    // Date now
    const dateData = new Date();
    const year  = dateData.getFullYear();
    const month = (dateData.getMonth() + 1).toString().padStart(2, "0");
    const day = dateData.getDate().toString().padStart(2, "0");
    const dateNow = year+'-'+month+'-'+day;

    return dateNow;
}
