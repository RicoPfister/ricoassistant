<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Post;
use App\Models\Tag;
use App\Models\Basic;
use App\Models\Rating;
use App\Models\Ref;
use App\Models\Statement;
use App\Models\Accounting;
use App\Models\DatabaseList;
use App\Models\User;
use App\Models\Contact;
use App\Models\Source;
use App\Models\Activity;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RicoAssistant extends Controller {

    public function filter(Request $request) {

        $user = Auth::user();

        $publicAuth = Basic::all()
            ->where('status', '=', '')
            ->take(20);

        if (isset($user)) {$userAuth = Basic::all()->where('user_id', '=', $user->id)->take(1); $listAuth = $publicAuth->merge($userAuth);}
        else {$listAuth = $publicAuth;};

        return Inertia::render('TabManager/TabManager', ['list' => $listAuth]);
    }

    // detail
    // -------------------------------------------------------
    public function detail(Request $request) {

        // dd($request);
        dd($request->reference);
        // dd($request->basic_id);

        $user = Auth::user();

            $basic = Basic::find($request->basic_id);

            return Inertia::render('TabManager/TabManager', ['detail' => $basic]);
    }

    // store
    // -------------------------------------------------------
    public function store(Request $request) {

        // dd($request);
        // dd($request->referenceReference['fromController']['referencesResult']);
        // dd($request->reference['reference']);
        // dd($request->basic);
        // dd($request->filelist);

        $user = Auth::user();

        $validated = $request->validate([
            'basicData.refDate' => 'required',
            'basicData.medium' => 'required',
            'basicData.title' => 'required',
        ]);

        // dd($request);

        // create tag
        function tagData($request, $id, $index, $basics, $sources) {

            switch ($id) {

                case 2:
                    if (isset ($request->tagData['tagSource'][$index])) {
                        $tag = new Tag();
                        $tag->db_name = 2;
                        $tag->db_id = $sources->id;
                        if (isset ($request->tagData['tagSource'][$index][0])) $tag->tag_category = $request->tagData['tagSource'][$index][0];
                        if (isset ($request->tagData['tagSource'][$index][1])) $tag->tag_context = $request->tagData['tagSource'][$index][1];
                        if (isset ($request->tagData['tagSource'][$index][2])) $tag->tag_content = $request->tagData['tagSource'][$index][2];
                        if (isset ($request->tagData['tagSource'][$index][3])) $tag->tag_comment = $request->tagData['tagSource'][$index][3];
                        $tag->tracking = $request->ip();
                        $tag->save();
                    }
                break;
            }
        };

        // create reference
        function reference($db_id, $checkValue, $request, $basics) {

            // get db_name
            $db_name_list = DB::table('database_lists')->where('id', '=', $db_id)->pluck('db_name');
            $db_name = $db_name_list[0].'Data';
            // parse_str($db_name[0].'Data', $db_name2);
            // dd($db_name[0]);
            // $test = 'statementData';
            // dd($db_name[0].'Data');
            // dd($request->$db_name['reference'] );

            // dd($checkValue);

            if (!$checkValue) {
                $ref = new Ref();
                $ref->basic_id = $basics->id;
                $ref->basic_ref = $basics->id;
                $ref->ref_db_id = $db_id;
                $ref->ref_db_index = 1;
                $ref->tracking = $request->ip();
                $ref->save();
            }

            else {
                // foreach ($request->activityTo as $i=>$activity) {
                foreach ($request->$db_name['reference'] as $key => $value) {
                    // dd($value);
                    $ref = new Ref();
                    $ref->basic_id = $basics->id;
                    $ref->basic_ref = $value['basic_id'];
                    $ref->ref_db_id = $db_id;
                    $ref->ref_db_index = 1;
                    $ref->tracking = $request->ip();
                    $ref->save();
                }
            }
        }

        $basics = new Basic();
        $basics->ref_date = $request->basicData['refDate'];
        $basics->title = $request->basicData['title'];
        $basics->medium = $request->basicData['medium'];
        // $basic->status = $request->basicData['status'];
        $basics->user_id = $user->id;
        $basics->tracking = $request->ip();
        $basics->save();

        if (isset($request->statementData)){
            $statement = new Statement();
            $statement->basic_id = $basics->id;
            $statement->statement = $request->statementData['statement'];
            $statement->tracking = $request->ip();
            $statement->save();

            // fire reference function
            if (isset($request->statementData['reference'])) $checkValue = $request->statementData['reference'];
            else $checkValue = '';
            // dd($checkValue);
            reference($db_id = 2, $checkValue, $request, $basics);
        }

        // dd($checkValue);
        if ($request->activityData){

            // dd($request->activityData['activityTo'][0]);

            foreach ($request->activityData['activityTo'] as $i=>$activity) {

                // dd($activity);

                // dd($request->activityData['activityTo'][$i]);

                if (is_numeric($request->activityData['activityTo'][$i])) {

                    $activities[$i] = [
                        'basic_id' => $basics->id,
                        'activityTo' => $activity,
                        // 'reference' => $request->reference[$i],
                        'tracking' => $request->ip(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }
            };

            DB::table('activities')->insert($activities);

            // fire reference function
            if (isset($request->activityData['reference'])) $checkValue = $request->activityData['reference'];
            else $checkValue = '';
            // dd($checkValue);
            reference($db_id = 4, $checkValue, $request, $basics);
        }

        // dd($request);

        // store reference reference
        // ------------------------------
        if (!isset($request->referenceReference)){

            $ref = new Ref();
            $ref->basic_id = $basics->id;
            $ref->basic_ref = $basics->id;
            $ref->ref_db_id = 1;
            $ref->ref_db_index = 1;
            $ref->tracking = $request->ip();
            $ref->save();
        }

        else if (isset($request->referenceReference)){
            $ref = new Ref();
            $ref->basic_id = $basics->id;
            $ref->basic_ref = $request['referenceReference']['reference'][0]['basic_id'];
            $ref->ref_db_id = 1;
            $ref->ref_db_index = 1;
            $ref->tracking = $request->ip();
            $ref->save();
        }

        // // store activity reference
        // //-------------------------------
        // if (!isset($request->reference)){
        //     // dd($request);
        //     $ref = new Ref();
        //     $ref->basic_id = $basics->id;
        //     $ref->basic_ref = $basics->id;
        //     // $ref->ref_db_id = 1;
        //     $ref->ref_db_index = 1;
        //     $ref->tracking = $request->ip();
        //     $ref->save();
        // }

        if (isset($request->reference)){

            foreach($request->reference['reference'] as $index => $data) {
                $ref = new Ref();
                $ref->basic_id = $basics->id;
                $ref->basic_ref = $request['reference']['reference'][$index]['basic_id'];
                // $ref->ref_db_id = 1;
                $ref->ref_db_index = 1;
                $ref->tracking = $request->ip();
                $ref->save();
            }
        }

        // if ($accounting == 1){

        //     $accounting = new Accounting();

        //     $accounting->basic_id = $basic->id;
        //     $accounting->accounting_producer = $request->accounting_producer;
        //     $accounting->accounting_trader = $request->accounting_trader;
        //     $accounting->accounting_price = $request->accounting_price;
        //     $accounting->accounting_currency = $request->accounting_currency;
        //     $accounting->accounting_price_default_currency = $request->accounting_price_default_currency;
        //     $accounting->tracking = $request->ip();
        //     $accounting->save();
        // }

        // store files
        if (isset($request->filelist)) {

            // dd($request);

            // store file meta data
            foreach($request->file('filelist') as $index => $dataString) {

                // dd($dataString['file']->hashName());

                $sources = new Source();
                $sources->basic_id = $basics->id;
                $sources->path = $dataString['file']->hashName();
                $sources->extension = $dataString['file']->extension();
                $sources->size = $dataString['file']->getSize();
                $sources->tracking = $request->ip();
                $sources->save();

                // dd($request);

                // isset tagData: execute tagData function
                if (isset ($request->tagData['tagSource'])) tagData($request, 2, $index, $basics, $sources);
            }

            // store file content data
            foreach($request->file('filelist') as $dataString2) {
                Storage::disk('local')->put('public/images/inventory/', $dataString2['file']);
            }
        }

        return redirect()->route('/')->with('message', 'Entry Successfully Created');
    }

    // update
    // -------------------------------------------------------
    public function update(Request $request) {

        foreach($request->all() as $key => $value) {

            if ($key != 'id'){
                $update = DB::table('ricoassistants')
                ->where('id', $request->id)
                ->update([$key => $value]);
            }

        }
        return redirect()->route('/')->with('message', 'Entry Successfully Updated');
    }

    public function delete(Request $request) {

        DB::table('basics')->where('id', '=', $request->id)->delete();

        return redirect()->route('/')->with('message', 'Entry Successfully Deleted');
    }

    // reference
    // -------------------------------------------------------
    public function reference(Request $request) {

        // dd($request);
        // dd($request->parentId);

        $user = Auth::user();
        $result = [];

        $db_id = DB::table('basics')->where('title', '=', $request->basicTitle)->pluck('id');
        // dd($db_id[0]);

        // check if "last used" was selected
        //-------------------------------------
        if ($request->reference == 'lastUsed') {

            // get last 10 references
            $referencedIds = DB::table('refs')
                ->where('status', '=', null)
                ->where('basic_id', '=', $user->id)
                // ->distinct('basic_id')
                // ->where('basic_id', '=', 'basic_ref')
                // ->whereRaw('basic_id = basic_ref')
                ->orderByDesc('updated_at')
                ->take(10)
                ->get();

            // dd($referencedIds);

            foreach ($referencedIds as $i=>$id) {

                $result['referencesResult'][$i]['title'] = $id->title;
                $result['referencesResult'][$i]['medium'] = $id->medium;
                $result['referencesResult'][$i]['id'] = $id->id;

                $tag = DB::table('tags')
                ->where('basic_id', '=', $id->id)
                ->where('tag_context', '=', 'ActivityDiagramColor')
                ->get();

                if (count($tag)) {
                    $result['referencesResult'][$i]['color'] = $tag[0]->tag_content;
                } else {};

                $result['referencesResult'][$i]['basic_id'] = $id->id;
            };

            $result['misc']['row'] = $request->row;
        }

        // 'reference input' was set
        //-------------------------------------
        else {

            $referencesResultCheck = DB::table('basics')
                ->where('status', '=', null)
                ->where('user_id', '=', $user->id)
                ->where('title', 'LIKE', '%'.$request->reference.'%')
                ->get();

            if (count($referencesResultCheck)) {

                foreach ($referencesResultCheck as $i=>$id) {

                    if (count($referencesResultCheck) == 0) {} else {
                        $result['referencesResult'][$i]['title'] = $id->title;

                        $tag = DB::table('tags')
                            ->where('basic_id', '=', $id->id)
                            ->where('tag_context', '=', 'ActivityDiagramColor')
                            ->get();

                        // dd($tag);

                        if (count($tag)) {
                            $result['referencesResult'][$i]['color'] = $tag[0]->tag_content;
                        } else {};

                        $result['referencesResult'][$i]['medium'] = $id->medium;
                        $result['referencesResult'][$i]['id'] = $id->id;
                    }
                    $result['referencesResult'][$i]['basic_id'] = $id->id;
                }

                $result['misc']['row'] = $request->row;

            } else {
                $result['misc']['row'] = 0;

            };
        }

        $result['misc']['parentId'] = $request->parentId;

        // dd($result);

        return Inertia::render('Create', ['fromController' => $result]);
    }

    // basic titlecheck
    // -------------------------------------------------------
    public function titlecheck(Request $request) {

        // dd($request);

        // user auth
        $user = Auth::user();
        $result = [];

        // create instant search results
        $basicTitleResultCheck = DB::table('basics')
                ->where('status', '=', null)
                ->where('user_id', '=', $user->id)
                ->where('title', '=', $request->basicTitle)
                ->get();

        // dd($basicTitleResultCheck);

            // isolate collection title and duplicated dates
            if (count($basicTitleResultCheck)) {

                $a = 0;
                $aa = 0;

                foreach ($basicTitleResultCheck as $i=>$id) {

                    // check for date duplicates
                    if ($id->ref_date == $request->basicRefDate) {

                        $date[$a]['title'] = $id->title;
                        $date[$a]['ref_date'] = $id->ref_date;
                        $date[$a]['warning'] = 2;
                        $a++;
                    }

                    else {
                        $title[$aa]['title'] = $id->title;
                        $title[$aa]['ref_date'] = $id->ref_date;
                        $title[$aa]['warning'] = 1;
                        $aa++;
                    }
                }

                // dd($title);
                // dd($date);

                // add title to collection
                if (isset($date[0]['ref_date']) && isset($title[0]['title'])) {

                    $ii = 0;

                    foreach ($date as $i=>$id1) {

                        $basicResult['basicResult'][$ii] = $id1;
                        $ii++;
                    };

                    foreach ($title as $a=>$id2) {

                        $basicResult['basicResult'][$ii] = $id1;
                        $ii++;
                    };

                    $basicResult['basicResult'][0]['warning'] = '2';

                } elseif (isset($date[0]['ref_date'])) {

                    $basicResult['basicResult'] = $date;
                    $basicResult['basicResult'][0]['warning'] = '2';

                } elseif (isset($title)) {
                    $basicResult['basicResult'] = $title;
                    $basicResult['basicResult'][0]['warning'] = '1';
                };

                // dd($basicResult);

                // $basicResult['basicResult']['ref_date'][$i] = $id->ref_date;
                // $basicResult['basicResult']['title'][$i] = $id->title;

            } else {
                // else set title to null
                $basicResult['basicResult'][0]['title'] = '';
            };

            // dd($basicResult['basicResult']['ref_date']);
            // dd($basicResult['basicResult']['warning']);
            // dd($basicResult);

        return Inertia::render('Create', ['fromController' => ['misc' => ['parentId' => $request->parentId], $basicResult]]);
    }

    // tag
    // -------------------------------------------------------
    public function tag(Request $request) {

        $tagCollectionRaw = DB::table('tags')->get();

        foreach($tagCollectionRaw as $key => $value) {

            $tagCollectionSelection['tagCollection'][$key][0] = $value->tag_category;
            $tagCollectionSelection['tagCollection'][$key][1][1] = $value->tag_context;
        }

        // dd($tagCollectionSelection);

        return Inertia::render('Create', ['dataCommon' => $tagCollectionSelection]);
    }

}
