export function tagFromStringToGroup(tagData) {

    // console.log(tagData);

    let tagArray = [];

    // split into tag groups
    let tagCollectionSplitInGroup = tagData.split(/[@]/);
    // console.log(tagCollectionSplitInGroup);

    // removes empty indexes
    let tagCollectionSplitInGroupFilter = tagCollectionSplitInGroup.filter(element => element);
    // console.log(tagCollectionSplitInGroupFilter);

    // variable definition
    let tagGroupSplitComment = [];
    let tagGroupSplitFilter = [];
    let tagGroupSplitmain = [];
    let tagGroupSplitPreset = [];
    let tagGroupSplitPresetFilter = [];
    let tagGroupSplitmainFilter = [];

    // split into tag group sections
    tagCollectionSplitInGroupFilter.forEach(tagCollectionEdit);

    function tagCollectionEdit(item, index) {

        // console.log(tagCollectionSplitInGroupFilter);
        if (tagCollectionSplitInGroupFilter.length > 0) tagArray[index] = [];

        // split comment
        tagGroupSplitComment[index] = item.split(/[(%)]/);
        tagGroupSplitFilter[index] = tagGroupSplitComment[index].filter(element => element != '');
        // console.log(tagGroupSplitFilter);

        // // split category/preset
        // tagGroupSplitPreset[index] = tagGroupSplitFilter[index][0].split(/[:preset]/);
        // tagGroupSplitPresetFilter[index] = tagGroupSplitPreset[index].filter(element => element != '');
        // console.log(tagGroupSplitPresetFilter[index]);

        //! preset part is obsolete. delete?
        // check if tag input contains preset
        if (tagGroupSplitFilter[index][0].match(/^Preset/)) {
                // split category, context and detail
            tagGroupSplitPreset[index] = tagGroupSplitFilter[index][0].split(/(Preset:.+?:+.+?(?=:))/);
            // console.log(tagGroupSplitPreset[index]);
            tagGroupSplitPresetFilter[index] = tagGroupSplitPreset[index].filter(element => element != '');
            // console.log(tagGroupSplitPresetFilter[index][0]);

            // split category, context and detail
            tagGroupSplitmain[index] = tagGroupSplitPresetFilter[index][1].split(/[:]/);
            // console.log(tagGroupSplitmain);

            tagGroupSplitmainFilter[index] = tagGroupSplitmain[index].filter(element => element != '');
            // console.log(tagGroupSplitmainFilter[index]);

            // add single tag group to tagArray

            // add preset to tagArray
            tagArray[index].push(tagGroupSplitPresetFilter[index][0]);

            // add context, value to tagArray
            for (let i = 0; i < 2; i++) {
                if (tagGroupSplitmainFilter[index][i]) {
                    tagArray[index].push(tagGroupSplitmainFilter[index][i]);
                } else tagArray[index].push('');
            }

            // console.log(tagArray);

            // add comment tag to tagArray
            if (tagGroupSplitFilter[index][1]) {
            tagArray[index].push(tagGroupSplitFilter[index][1]);
            } else tagArray[index].push('');

        // regular tag input
        } else {
            // console.log('ok');
            // split category, context and detail
            tagGroupSplitmain[index] = tagGroupSplitFilter[index][0].split(/[:]/);
            // console.log(tagGroupSplitmain[index]);
            tagGroupSplitmainFilter[index] = tagGroupSplitmain[index].filter(element => element != '');
            // console.log(tagGroupSplitmainFilter);

            // add single tag group to tagArray

            // add context, value to tagArray
            for (let i = 0; i < 3; i++) {
                if (tagGroupSplitmainFilter[index][i]) {
                    tagArray[index].push(tagGroupSplitmainFilter[index][i]);
                }
                // set empty value
                // else tagArray[index].push('');
            }

            // console.log(tagArray);
            // console.log(tagGroupSplitmainFilter);
            // console.log(tagGroupSplitFilter);

            // add comment tag to tagArray
            if (tagGroupSplitFilter[index][1]) {
            tagArray[index].push(tagGroupSplitFilter[index][1]);
            }
            // set empty value
            // else tagArray[index].push('');
        }
    }

    // console.log(tagArray);
    return tagArray;
}
