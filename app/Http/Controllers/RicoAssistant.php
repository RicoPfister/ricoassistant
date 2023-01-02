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
use App\Models\IndexTagPreset;

use App\Models\SectionBasic;
use App\Models\SectionStatement;
use App\Models\SectionActivity;
use App\Models\SectionSource;

use App\Models\Ref;

use App\Models\Tag;
use App\Models\TagPreset;
use App\Models\TagCategory;
use App\Models\TagContext;
use App\Models\TagDetail;
use App\Models\TagValue;

class RicoAssistant extends Controller {

    // filter
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

            $basic = SectionBasic::find($request->basic_id);

            return Inertia::render('TabManager/TabManager', ['detail' => $basic]);
    }

    // store
    // -------------------------------------------------------
    public function store(Request $request) {

        // dd($request);

        // get user data
        $user = Auth::user();

        // validation
        $validated = $request->validate([
            'basicData.refDate' => 'required',
            'basicData.medium' => 'required',
            'basicData.title' => 'required',
        ]);

        // create tag function
        function tagData($request, $index, $basics, $id, $id2) {

            switch ($id) {

                case 2:
                    foreach ($request->statementData['tag'][$index] as $key => $value) {

                        $content_check = DB::table('tag_categories')->where('content', '=', $value[0])->get();

                        // dd($content_check);
                        // dd($value);

                        // check data availability and db uniqueness and store tag category
                        if (isset ($value[0])) {

                            // dd('ok');

                            if (count($content_check) > 0) {
                                // dd('ok');
                                // dd($content_check[0]);
                                $content = $content_check[0];

                                $tag1 = new Tag();
                                $tag1->basic_id = $basics->id;
                                $tag1->section_table = 2;
                                $tag1->section_table_id = $id2->id;
                                $tag1->tag_table = 1;
                                $tag1->tag_table_id = $content->id;
                                $tag1->tracking = $request->ip();
                                $tag1->save();

                                $tag1->tag_id = $tag1->id;
                                $tag1->save();

                                // dd('ok');
                            }
                            else {
                                $tag_category = new TagCategory();
                                $tag_category->content = $value[0];
                                $tag_category->tracking = $request->ip();
                                $tag_category->save();

                                $content = $tag_category;

                                $tag1 = new Tag();
                                $tag1->basic_id = $basics->id;
                                $tag1->section_table = 2;
                                $tag1->section_table_id = $id2->id;
                                $tag1->tag_table = 1;
                                $tag1->tag_table_id = $content->id;
                                $tag1->tracking = $request->ip();
                                $tag1->save();

                                $tag1->tag_id = $tag1->id;
                                $tag1->save();

                                // dd('ok');
                            };
                        };

                        // check data availability and db uniqueness and store tag context
                        if (isset ($value[1])) {
                            $content_check = DB::table('tag_contexts')->where('content', '=', $value[1])->get();

                            if (count($content_check) > 0) $content = $content_check[0];
                            else {
                                $tag_context = new TagContext();
                                $tag_context->content = $value[1];
                                $tag_context->tracking = $request->ip();
                                $tag_context->save();
                                $content = $tag_context;
                            }

                            $tag2 = new Tag();
                            $tag2->basic_id = $basics->id;
                            $tag2->section_table = 2;
                            $tag2->section_table_id = $id2->id;
                            $tag2->tag_id = $tag1->id;
                            $tag2->tag_table = 2;
                            $tag2->tag_table_id = $content->id;
                            $tag2->tracking = $request->ip();
                            $tag2->save();
                        };

                        // check data availability and db uniqueness and store tag value
                        if (isset ($value[0])) {
                            $content_check = DB::table('tag_values')->where('content', '=', $value[2])->get();

                            if (count($content_check) > 0) $content = $content_check[0];
                            else {
                                $tag_value = new TagValue();
                                $tag_value->content = $value[2];
                                $tag_value->tracking = $request->ip();
                                $tag_value->save();
                                $content = $tag_value;
                            }

                            $tag3 = new Tag();
                            $tag3->basic_id = $basics->id;
                            $tag3->section_table = 2;
                            $tag3->section_table_id = $id2->id;
                            $tag3->tag_id = $tag1->id;
                            $tag3->tag_table = 3;
                            $tag3->tag_table_id = $content->id;
                            $tag3->tracking = $request->ip();
                            $tag3->save();
                        };

                        // check availability and db uniqueness and store tag detail
                        if (isset ($value[0])) {
                            $content_check = DB::table('tag_details')->where('content', '=', $value[3])->get();

                            if (count($content_check) > 0) $content = $content_check[0];
                            else {
                                $tag_details = new TagDetail();
                                $tag_details->content = $value[3];
                                $tag_details->tracking = $request->ip();
                                $tag_details->save();
                                $content = $tag_details;
                            }

                            $tag4 = new Tag();
                            $tag4->basic_id = $basics->id;
                            $tag4->section_table = 2;
                            $tag4->section_table_id = $id2->id;
                            $tag4->tag_id = $tag1->id;
                            $tag4->tag_table = 4;
                            $tag4->tag_table_id = $content->id;
                            $tag4->tracking = $request->ip();
                            $tag4->save();
                        };
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

        // create reference function
        function reference($db_id, $request, $basics) {

            // get db_name
            $db_name_list = DB::table('index_databases')->where('id', '=', $db_id)->pluck('db_name');
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
        $basics = new SectionBasic();
        $basics->ref_date = $request->basicData['refDate'];
        $basics->title = $request->basicData['title'];
        $basics->medium = $request->basicData['medium'];
        $basics->user_id = $user->id;
        $basics->tracking = $request->ip();
        $basics->save();

        // create statement
        if (isset($request->statementData)){

            $statement = new SectionStatement();
            $statement->basic_id = $basics->id;
            $statement->statement = $request->statementData['statement'];
            $statement->tracking = $request->ip();
            $statement->save();

            // fire reference function
            if (isset($request->statementData['reference'])) reference($db_id = 2, $request, $basics);

            // fire tag function
            if (isset ($request->statementData['tag'])) tagData($request, 0, $basics, 2, $statement);
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

            DB::table('section_activities')->insert($activities);

            // fire reference function
            if (isset($request->activityData['reference'])) $checkValue = $request->activityData['reference'];
            else $checkValue = '';

            reference($db_id = 4, $checkValue, $request, $basics);
        }

        // create source
        if (isset ($request->sourceData['filelist'])) {

            // store file meta data
            foreach($request->sourceData['filelist'] as $index => $dataString) {

                $sources = new SectionSource();
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
                        $parent_basic = DB::table('section_basics')
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

        $db_id = DB::table('section_basics')->where('title', '=', $request->basicTitle)->pluck('id');

        // check if "last used" was selected
        //-------------------------------------
        if ($request->reference == 'lastUsed') {

            // get last 10 references
            $referencedIds = DB::table('section_basics')
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

            $referencesResultCheck = DB::table('section_basics')
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
        $basicTitleResultCheck = DB::table('section_basics')
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

    // get tag list for tag selection
    // -------------------------------------------------------
    public function tag(Request $request) {

        // select all unique categories
        $tag_category_distinct_id = DB::table('tag_categories')
        ->select('id', 'content')
        ->get();

        // dd($tag_category_distinct_id);

        $tag_collection_category_context = [];
        foreach ($tag_category_distinct_id as $key => $tag_single_category) {

            // dd($tag_single_category);

            // dd($tag_single_category);

            // step 2.1: collection db ids from a single category
            $tag_category_id = DB::table('tags')
            ->where('tag_table', '=', 1)
            ->where('tag_table_id', '=', $tag_single_category->id)
            ->get()
            ->pluck('tag_id');

            // dd($tag_category_id);

            // step 2.2: check if preset exists and save data in array
            // $tag_preset_id_single = DB::table('tag_presets')
            // ->where('id', '=', $tag_single_id)
            // ->select('id', 'content')
            // ->get();

            // if () {

            // }

            // step 2.2: collection context ids from a single category
            $tag_context_distinct = [];
            foreach ($tag_category_id as $tag_id_index => $tag_id) {

                $tag_context_id = DB::table('tags')
                ->where('tag_id', '=', $tag_id)
                ->where('tag_table', '=', 2)
                ->get()
                ->pluck('tag_table_id');

                // dd($tag_context_id[0]);
                array_push($tag_context_distinct, $tag_context_id[0]);
            }

                // keep only unique tag context ids
                $tag_context_distinct_unique = array_unique($tag_context_distinct);

                // dd($tag_context_distinct_unique);

                // step 2.3: collect all tag context contents from a single category
                $tag_context_id_single_collection = [];
                foreach ($tag_context_distinct_unique as $tag_id => $tag_single_id) {
                    $tag_context_id_single = DB::table('tag_contexts')
                    ->where('id', '=', $tag_single_id)
                    ->select('id', 'content')
                    ->get();

                    // dd($tag_context_id_single);

                    // step 2.4: gather all unique contexts from a single category
                    array_push($tag_context_id_single_collection, $tag_context_id_single[0]->content);
                }

            array_push($tag_collection_category_context, [$tag_single_category->content, $tag_context_id_single_collection]);

        };

        // preset collection

        // $tag_preset_
        // DB::table('')

        // $tag_collection_preset

        $tagCollectionSelection['tagCollection'] = $tag_collection_category_context;
        // $tagCollectionSelection['tagCollection'] = $tag_collection_preset;
        $tagCollectionSelection['misc']['parentId']= $request->parentId;
        $tagCollectionSelection['misc']['parentIndex']= $request->parentIndex;

        // dd($tagCollectionSelection);

        return Inertia::render('Create', ['fromController' => $tagCollectionSelection]);
    }

    // get tag list for tag selection
    // -------------------------------------------------------
    public function preset_store(Request $request) {

        // dd($request);

        if (isset($request->preset_name)) {
            // dd($request);
            $tag_preset = new IndexTagPreset();
            $tag_preset->preset_name = $request->preset_name;
            $tag_preset->tracking = $request->ip();
            $tag_preset->save();
        }

        if (isset($request->preset_group)) {

            // dd($request);
            // dd($request->preset_group);

            // $group_id = DB::table('index_tag_presets')

            // $preset_id = ;

            // dd($request->preset_group['tag_category']);

            $tag_preset = new TagPreset();

            // dd($preset_id);
            $tag_preset->group_id = DB::table('index_tag_presets')
            ->where('preset_name', '=', $request->preset_group['preset_name'])
            ->pluck('id')[0];

            $tag_preset->tag_category = DB::table('tag_categories')
            ->where('content', '=', $request->preset_group['tag_category'])
            ->pluck('id')[0];

            // convert tag category name to id
            $tag_category_id = DB::table('tag_categories')
            ->where('content', '=', $request->preset_group['tag_category'])
            ->pluck('id');

            // convert tag context name to id
            $tag_context_id = DB::table('tag_contexts')
            ->where('content', '=', $request->preset_group['tag_context'])
            ->pluck('id');

            // dd($tag_category_id[0]);

            // get tag category tag group ids
            $tags_category_id = DB::table('tags')
            ->where('tag_table', '=', 1)
            ->where('tag_table_id', '=', $tag_category_id[0])
            ->get();




            // $tags_context_id

            // dd($tags_category_id);
            // dd($tags_category_id[0]->tag_id);

            foreach ($tags_category_id as $key => $value) {

                $tags_context_id = DB::table('tags')
                ->where('tag_table', '=', 2)
                ->where('tag_id', '=', $value->tag_id)
                ->where('tag_table_id', '=', $tag_context_id[0])
                ->get();

                if(count($tags_context_id)) {
                    // dd($tags_context_id[0]->id);
                    $tag_preset->tag_context = $tags_context_id[0]->id;
                    break;
                }
            }

            $tag_preset->tracking = $request->ip();
            $tag_preset->save();




            // dd($tags_context_id);

            // $tag_id = db

            // $tag_context_id = DB::table('tags')
            // ->where('')

            // $tag_preset->tag_context = DB::table('tag_contexts')
            // ->where('content', '=', $request->preset_group['tag_context'])
            // ->pluck('id')[0];

            // $tag_preset->tag_context =;
            $tag_preset->tracking = $request->ip();
            $tag_preset->save();
        }

        return Inertia::render('Create');
        // return redirect()->route('tag')->with('message', 'Entry Successfully Created');
    }
}
