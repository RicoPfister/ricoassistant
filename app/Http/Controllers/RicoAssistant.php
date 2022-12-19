<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Redirect;
use Illuminate\Http\Request;
use Illuminate\Http\Post;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Contact;

use App\Models\IndexDatabase;
use App\Models\IndexMedium;

use App\Models\SectionBasic;
use App\Models\SectionStatement;
use App\Models\SectionActivity;
use App\Models\SectionSource;

use App\Models\Ref;

use App\Models\Tag;
use App\Models\TagCategory;
use App\Models\TagContext;
use App\Models\TagDetail;
use App\Models\TagValue;

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

        $user = Auth::user();

            $basic = Basic::find($request->basic_id);

            return Inertia::render('TabManager/TabManager', ['detail' => $basic]);
    }

    // store
    // -------------------------------------------------------
    public function store(Request $request) {

        $user = Auth::user();

        $validated = $request->validate([
            'basicData.refDate' => 'required',
            'basicData.medium' => 'required',
            'basicData.title' => 'required',
        ]);

        // create tag
        function tagData($request, $index, $basics, $id, $id2) {

            switch ($id) {

                case 2:
                    foreach ($request->statementData['tag'][$index] as $key => $value) {
                        $tag = new Tag();
                        $tag->basic_id = $basics->id;
                        $tag->db_id = 2;
                        if (isset ($value[0])) $tag->tag_category = $value[0];
                        if (isset ($value[1])) $tag->tag_context = $value[1];
                        if (isset ($value[2])) $tag->tag_content = $value[2];
                        if (isset ($value[3])) $tag->tag_comment = $value[3];
                        $tag->tracking = $request->ip();
                        $tag->save();
                    }
                break;

                case 3:
                    foreach ($request->sourceData['tag'][$index] as $key => $value) {
                        $tag = new Tag();
                        $tag->basic_id = $basics->id;
                        $tag->db_id = 3;
                        $tag->db_index = $id2->id;
                        if (isset ($value[0])) $tag->tag_category = $value[0];
                        if (isset ($value[1])) $tag->tag_context = $value[1];
                        if (isset ($value[2])) $tag->tag_content = $value[2];
                        if (isset ($value[3])) $tag->tag_comment = $value[3];
                        $tag->tracking = $request->ip();
                        $tag->save();
                    }
                break;
            }
        };

        // create reference
        function reference($db_id, $request, $basics) {

            // get db_name
            $db_name_list = DB::table('database_lists')->where('id', '=', $db_id)->pluck('db_name');
            $db_name = $db_name_list[0].'Data';

                // foreach ($request->activityTo as $i=>$activity) {
                foreach ($request->$db_name['reference'] as $key => $value) {
                    $ref = new Ref();
                    $ref->basic_id = $basics->id;
                    $ref->basic_ref = $value['basic_id'];
                    $ref->ref_db_id = $db_id;
                    $ref->ref_db_index = 1;
                    $ref->tracking = $request->ip();
                    $ref->save();
                }

        }

        // create basic
        $basics = new Basic();
        $basics->ref_date = $request->basicData['refDate'];
        $basics->title = $request->basicData['title'];
        $basics->medium = $request->basicData['medium'];
        $basics->user_id = $user->id;
        $basics->tracking = $request->ip();
        $basics->save();

        // create statement
        if (isset($request->statementData)){
            $statement = new Statement();
            $statement->basic_id = $basics->id;
            $statement->statement = $request->statementData['statement'];
            $statement->tracking = $request->ip();
            $statement->save();

            // fire reference function
            if (isset($request->statementData['reference'])) reference($db_id = 2, $request, $basics);

            // fire tag function
            if (isset ($request->statementData['tag'])) tagData($request, 0, $basics, 2, '');

        }

        // create activity
        if ($request->activityData){

            foreach ($request->activityData['activityTo'] as $i=>$activity) {

                if (is_numeric($request->activityData['activityTo'][$i])) {

                    $activities[$i] = [
                        'basic_id' => $basics->id,
                        'activityTo' => $activity,
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

            reference($db_id = 4, $checkValue, $request, $basics);
        }

        if (isset ($request->sourceData['filelist'])) {

            // store file meta data
            foreach($request->sourceData['filelist'] as $index => $dataString) {

                $sources = new Source();
                $sources->basic_id = $basics->id;
                $sources->path = $dataString['file']->hashName();
                $sources->extension = $dataString['file']->extension();
                $sources->size = $dataString['file']->getSize();
                $sources->tracking = $request->ip();
                $sources->save();

                // create tag
                if (isset ($request->sourceData['tag'])) tagData($request, $index, $basics, 3, $sources);
            }

            // store file content data
            foreach($request->file('sourceData')['filelist'] as $dataString2) {
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

        function reference_inheritance_list($id, $i, $user) {

            $counter = 1;

            $parent_list = [];

            // check if there are children
            $parent_ref = DB::table('refs')
            ->where('status', '=', null)
            ->where('basic_id', '=', $id->id)
            ->first();

            if (isset($parent_ref->basic_ref)) {
                $parent_checker_next_value = $parent_ref->basic_ref;

                do  {
                    if ($parent_ref->basic_id != $parent_ref->basic_ref) {
                        // get corresponding basic db entry data
                        $parent_basic = DB::table('basics')
                        ->where('status', '=', null)
                        ->where('user_id', '=', $user->id)
                        ->where('id', '=', $parent_checker_next_value)
                        ->first();

                        // check next ref db entry
                        $parent_ref = DB::table('refs')
                        ->where('status', '=', null)
                        ->where('basic_id', '=', $parent_checker_next_value)
                        ->first();

                        array_push($parent_list, $parent_basic);
                        $parent_checker_next_value = $parent_ref->basic_ref;
                        $parent_checker = 1;
                        $counter++;
                    }
                    else $parent_checker = 0;
                } while ($parent_checker || $counter > 10);
            }

            return $parent_list;
        }

        $user = Auth::user();
        $result = [];

        $db_id = DB::table('basics')->where('title', '=', $request->basicTitle)->pluck('id');

        // check if "last used" was selected
        //-------------------------------------
        if ($request->reference == 'lastUsed') {

            // get last 10 references
            $referencedIds = DB::table('basics')
                ->where('status', '=', null)
                ->where('user_id', '=', $user->id)
                ->orderByDesc('updated_at')
                ->take(10)
                ->get();

            foreach ($referencedIds as $i=>$id) {

                $result['referencesResult'][$i]['title'] = $id->title;
                $result['referencesResult'][$i]['medium'] = $id->medium;
                $result['referencesResult'][$i]['medium_name'] = DB::table('medium_lists')->where('id', '=', $id->medium)->pluck('medium_name');
                $result['referencesResult'][$i]['id'] = $id->id;
                $result['referencesResult'][$i]['ref_date'] = $id->ref_date;
                $result['referencesResult'][$i]['updated_at'] = $id->updated_at;

                $tag = DB::table('tags')
                ->where('basic_id', '=', $id->id)
                ->where('tag_context', '=', 'ActivityDiagramColor')
                ->get();

                if (count($tag)) {
                    $result['referencesResult'][$i]['color'] = $tag[0]->tag_content;
                } else {};

                $result['referencesResult'][$i]['basic_id'] = $id->id;

                $result['referencesResult'][$i]['inheritance'] = reference_inheritance_list($id, $i, $user);
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

        return Inertia::render('Create', ['fromController' => $result]);
    }

    // basic titlecheck
    // -------------------------------------------------------
    public function titlecheck(Request $request) {

        // user auth
        $user = Auth::user();
        $result = [];

        // create instant search results
        $basicTitleResultCheck = DB::table('basics')
                ->where('status', '=', null)
                ->where('user_id', '=', $user->id)
                ->where('title', '=', $request->basicTitle)
                ->get();

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

            } else {
                // else set title to null
                $basicResult['basicResult'][0]['title'] = '';
            };

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
        $tagCollectionSelection['misc']['parentId']= $request->parentId;
        $tagCollectionSelection['misc']['parentIndex']= $request->parentIndex;

        return Inertia::render('Create', ['fromController' => $tagCollectionSelection]);
    }
}
