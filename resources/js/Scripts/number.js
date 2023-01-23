export function fileSize(data) {

    let conversion = 0;
    let conversionRounded = 0;

    function epsilonRounded(data) {
        return Math.round((data + Number.EPSILON) * 10) / 10;
    }

    if (data < 100) {
        conversion = data + ' B';
    }

    else if (data < 100000) {
        conversion = epsilonRounded(data/1000) + ' KB';
    }

    else if (data >= 100000) {
        conversion = epsilonRounded(data/1000/1000) + ' MB';
    }

    else if (data > 100000000) {
        conversion = epsilonRounded(data/1000/1000/1000) + ' GB';
    }

    else if (data > 100000000000) {
        conversion = +999 + 'GB';
    }


    return conversion;
}
