<?php

$validation_collection = [
    'basicData.ref_date' => 'required|regex:/^[0-9]{4}-[0-9][0-9]-[0-9][0-9]$/',
    'basicData.medium' => 'required|filled',
    'basicData.title' => 'required|min:3',
];

if (array_search(4, $request->componentCollection)) $validation_collection['statementData.statement'] = 'required|filled';
if (array_search(4, $request->componentCollection)) {

    if (isset($request->statementData['tag'])) {
        foreach ($request->statementData['tag'] as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $validation_collection['statementData.tag.' . $key . '.' . $key2 . '.0'] = 'required|filled';
                $validation_collection['statementData.tag.' . $key . '.' . $key2 . '.1'] = 'required|filled';
                $validation_collection['statementData.tag.' . $key . '.' . $key2 . '.2'] = 'required|filled';
            }
        }
    }
}

if (array_search(6, $request->componentCollection)) $validation_collection['sourceData.filelist'] = 'required';
if (array_search(6, $request->componentCollection)) $validation_collection['sourceData.filelist.*.type'] = 'filled';

if (isset($request->sourceData['tag'])) {
    foreach ($request->sourceData['tag'] as $key => $value) {
        foreach ($value as $key2 => $value2) {
            $validation_collection['sourceData.tag.' . $key . '.' . $key2 . '.0'] = 'required|filled';
            $validation_collection['sourceData.tag.' . $key . '.' . $key2 . '.1'] = 'required|filled';
            $validation_collection['sourceData.tag.' . $key . '.' . $key2 . '.2'] = 'required|filled';
        }
    }
}

if (array_search(5, $request->componentCollection)) $validation_collection['activityData.reference_parents.*.0.basic_id'] = 'required|filled';
if (array_search(5, $request->componentCollection)) $validation_collection['activityData.activityTo'] = 'required';

if (array_search(5, $request->componentCollection)) {

    if (isset($request->activityData['tag'])) {
        foreach ($request->activityData['tag'] as $key => $value) {
            if ($value) {
                foreach ($value as $key2 => $value2) {
                    $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.0'] = 'required|filled';
                    $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.1'] = 'required|filled';
                    $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.2'] = 'required|filled';
                }
            }
        }
    }
}

if (isset($request->activityData['activityTo'])) {
    for ($a = 0; $a < count($request->activityData['activityTo']); $a++) {
        $validation_collection['activityData.reference_parents.'.$a] = 'required|filled';
    }

    $validation_collection['activityData.activityTo.*'] = 'filled|between:0,2400';

    // last entry must end with 2400
    // $validation_collection['activityData.activityTo.' . count($request->activityData['activityTo'])-1] = 'in:2400';
}

// dd($validation_collection);

$validated = $request->validate($validation_collection);

?>
