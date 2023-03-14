export function validation(section, data, form) {

    let validation_response = {};

    if (section == 'basic') {

        if (form.basicData.medium == undefined) {
             validation_response['basicData'] = 1;
        }
    }

    console.log(validation_response);

    return validation_response;
}
