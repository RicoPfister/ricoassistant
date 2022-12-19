export function tagFromStringToGroup(tagData) {

    let tagArray = [];

    let tagCollectionSplitInGroup = tagData.split(/[\s@]/);
    let tagCollectionSplitInGroupFilter = tagCollectionSplitInGroup.filter(element => element);

    let tagGroupSplitComment = [];
    let tagGroupSplitFilter = [];
    let tagGroupSplitmain = [];
    let tagGroupSplitmainFilter = [];

    tagCollectionSplitInGroupFilter.forEach(tagCollectionEdit);

    function tagCollectionEdit(item, index) {

        //? set nested
        // console.log(tagCollectionSplitInGroupFilter);
        if (tagCollectionSplitInGroupFilter.length > 0) tagArray[index] = [];

        // split comment
        tagGroupSplitComment[index] = item.split(/[(%)]/);
        tagGroupSplitFilter[index] = tagGroupSplitComment[index].filter(element => element != ' ');

        tagGroupSplitmain[index] = tagGroupSplitFilter[index][0].split(/[:]/);
        tagGroupSplitmainFilter[index] = tagGroupSplitmain[index].filter(element => element != ' ');

        // add content tags
        for (let i = 0; i < 3; i++) {
            if (tagGroupSplitmainFilter[index][i]) {
                tagArray[index].push(tagGroupSplitmainFilter[index][i]);
            } else tagArray[index].push('');
        }

        // add comment tag
        if (tagGroupSplitmainFilter[index][1]) {
           tagArray[index].push(tagGroupSplitFilter[index][1]);
        } else tagArray[index].push('');
    }

    return tagArray;
}
