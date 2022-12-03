export function tagFromStringToGroup(tagData) {

    let tagArray = [];

    console.log(tagData);
    let tagCollectionSplitInGroup = tagData.split(/[\s@]/);
    let tagCollectionSplitInGroupFilter = tagCollectionSplitInGroup.filter(element => element);

    let tagGroupSplitComment = [];
    let tagGroupSplitFilter = [];
    let tagGroupSplitmain = [];
    let tagGroupSplitmainFilter = [];

    tagCollectionSplitInGroupFilter.forEach(tagCollectionEdit);

    function tagCollectionEdit(item, index) {

        // split comment
        tagGroupSplitComment[index] = item.split(/[(%)]/);
        tagGroupSplitFilter[index] = tagGroupSplitComment[index].filter(element => element != ' ');

        tagGroupSplitmain[index] = tagGroupSplitFilter[index][0].split(/[:]/);
        tagGroupSplitmainFilter[index] = tagGroupSplitmain[index].filter(element => element != ' ');

        // add content tags
        for (let i = 0; i < 3; i++) {
            if (tagGroupSplitmainFilter[index][i]) {
                tagArray.push(tagGroupSplitmainFilter[index][i]);
            } else tagArray.push('');
        }

        // add comment tag
        if (tagGroupSplitmainFilter[index][1]) {
            tagArray.push(tagGroupSplitFilter[index][1]);
        } else tagArray.push('');
    }

    return tagArray;
}
