<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Redirect;
use Illuminate\Http\Request;
// use Illuminate\Http\Response;
use Illuminate\Http\Post;
use Symfony\Component\HttpFoundation\Response;
// use Illuminate\Http\RedirectResponse;
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

    // show filter (show default list view)
    public function filter(Request $request) {

        $user = Auth::user();

        $publicAuth = DB::table('section_basics')
            ->where('status', '=', 1)
            ->select('id', 'medium', 'title', 'ref_date')
            ->limit(20)
            ->latest('updated_at')
            ->get();

        // dd($publicAuth);

        if (isset($user)) {$userAuth = SectionBasic::all()->where('user_id', '=', $user->id)->take(20)->sortByDesc('updated_at'); $listAuth = $publicAuth->merge($userAuth);}
        else {$listAuth = $publicAuth;};

        // dd($listAuth);

        return Inertia::render('TabManager/TabManager', ['list' => $listAuth]);
    }

    // detail
    // -------------------------------------------------------
    public function detail(Request $request) {

        // dd($request);
        // dd($request);

        $user = Auth::user();

        // get detail tags
        function detail_tag($basic_id, $section_id) {

            // dd($detail);
            // dd($basic_id);
            // dd($section_content);

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');

            $db_name = $form_section_name [0].'Data';

            // get tag groups
            $tag_rawdata = DB::table('tags')
            ->where('basic_id', '=', $basic_id)
            ->where('section_table', '=', $section_id)
            ->where('status', '=', null)
            ->get()
            ->groupBy(['section_table_id', 'tag_id']);

            // ->groupBy();

            // dd($tag_rawdata);

            if (count($tag_rawdata) > 0) {

                // tag array definition

                $i = 0;
                // create tag groups per file content
                foreach ($tag_rawdata as $key => $value) {

                    // dd($value);

                    // $detail[$db_name]['tag'][$i] = [];
                    $i2 = 0;
                    // create tag groups content
                    foreach ($value as $key2 => $value2) {

                        // dd($value2);

                        // dd($value);
                        // array_push($detail['statementData']['tag'], []);

                        $detail[$db_name]['tag'][$key][$i2] = [];

                        foreach ($value2 as $key3 => $value3) {

                            // dd($value3);
                            // dd($key);



                            // dd($detail);
                            // dd($value2);
                            if ($value3->tag_table == 1) $tag_table = 'tag_categories';
                            if ($value3->tag_table == 2) $tag_table = 'tag_contexts';
                            if ($value3->tag_table == 3) $tag_table = 'tag_values';
                            if ($value3->tag_table == 4) $tag_table = 'tag_details';

                            $tag_group_content = DB::table($tag_table)
                            ->where('id', '=', $value3->tag_table_id)
                            ->pluck('content')[0];

                            // dd($detail);

                            // tag push to dedicated collection

                            // dd($detail);
                            // dd($db_name == 'sourceData');
                            // dd($detail[$db_name]['files'][0]);

                            // if ($db_name == 'sourceData') {
                            //     $detail[$db_name]['files'][0]->test = 123;
                            // }


                                // if (!issset($detail[$db_name]['tag'])) $detail[$db_name]['tag'] = [];
                                // dd($section_content[$i2]->id, $value3->section_table_id);

                                // if ($section_content[$i2]->id == $value3->section_table_id) array_push($detail[$db_name]['tag'][$i][$i2], $tag_group_content);

                                // if (array_key_exists($value3->section_table_id, $section_content)) {
                                array_push($detail[$db_name]['tag'][$key][$i2], $tag_group_content);
                                // }

                        }
                        // dd($detail);
                        $i2++;
                        // $detail['statementData']['tag'].push()

                        }
                        $i++;
                }
                // dd($detail);
                return $detail[$db_name]['tag'];
            }

        }

        function detail_reference_parents($detail, $request, $section_id) {

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');
            $db_name = $form_section_name [0].'Data';

            $i = 0;
            $basic_ref = $detail['basicData']['id'];

            // get reference id
            $reference_id = DB::table('refs')
            ->where('basic_id', '=', $basic_ref)
            // ->join('section_basic', 'section_basic.id', '=', )
            ->get();

            // dd($reference_id);

            // if (count(reference_id) > 0) {

                foreach ($reference_id as $key => $value) {

                    // dd($key);
                    // dd($value);

                    $i = 0;
                    do {
                        $_reference_parents_id = DB::table('section_basics')
                        ->where('id', '=', $value->basic_ref)
                        ->get();

                        // dd($_reference_parents_id);

                        $detail['reference_parents'][$key][$i] = $_reference_parents_id[0];
                        // dd($detail);
                        $i++;

                        // $value->

                        $basic_ref = $value->basic_ref;

                        // dd($basic_ref);

                        $next_value = DB::table('refs')
                        ->where('basic_id', '=', $basic_ref)
                        // ->join('section_basic', 'section_basic.id', '=', )
                        ->get();
                        // dd($reference_id);

                        if (count($next_value) > 0)  {
                            $value = $next_value[0];
                        }


                        // dd($value);
                        // dd(count($value) > 0);

                    } while (count($next_value) > 0);
                }
            // }
            if (isset($detail['reference_parents'])) return $detail['reference_parents'];
        }

        function detail_reference_children($detail, $request, $section_id) {

            // dd('ok');

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');
            $db_name = $form_section_name [0].'Data';

            // dd($request->basic_id);
            // dd($form_section_name);

            // get reference children data
            $reference_children_id = DB::table('refs')
            ->where('basic_ref', '=', $request->basic_id)
            ->get();

            // dd($reference_children_id);

            foreach ($reference_children_id as $key => $value) {

                // dd($value);
                // dd($value->ref_db_id);

                $reference_children_title = DB::table('section_basics')
                ->where('id', '=', $value->basic_id)
                ->get();

                // dd($reference_children_title);
                // dd($detail);

                $detail_reference_children[$key] = $reference_children_title;
                // $detail[$db_name]['reference_children'][0]->put('test', 123);
                // $detail[$db_name]['reference_children'][0]['test'] = [123];
                // dd($value->ref_db_index);
                // dd($detail[$db_name]['reference_children']);

                // check and get activity data
                if ($value->ref_db_id == 4) {
                    $detail_reference_children[$key][0]->ref_id = DB::table('section_activities')
                    ->where('id', '=', $value->ref_db_index)
                    ->get();

                }

                else if ($value->ref_db_id == 3) {
                    // check and get source data
                    $detail_reference_children[$key][0]->ref_id = DB::table('section_sources')
                    ->where('basic_id', '=', $value->ref_db_index)
                    ->get();

                }

                $detail_reference_children[$key][0]->ref_db_id = $value->ref_db_id;

                // dd($form_section_name);
                // dd($detail[$db_name]['reference_children'][$key][0]);

                $ref_db_name  = DB::table('index_databases')
                ->where('id', '=', $detail_reference_children[$key][0]->ref_db_id)
                ->pluck('db_name');

                // dd($ref_db_name[0]);

                $detail_reference_children[$key][0]->ref_db_name = $ref_db_name[0];
                // $detail[$db_name]['reference_children'][0][0][1] = 123;
                // dd($detail);
                // array_push($detail[$db_name]['reference_children'][1][$key], ['test' => 123]);

                // dd($detail[$db_name]['reference_children'][1]);
            };

            // dd($detail_reference_children[$key]);
            // dd($detail_reference_children);
            if (isset($detail_reference_children)) return $detail_reference_children;
        }

        // create basic collection
        // ++++++++++++++++++++++++++++++++++++
        $detail['basicData'] = SectionBasic::find($request->basic_id);

        // create statement collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_statement = DB::table('section_statements')
        ->where('basic_id', '=', $request->basic_id)
        ->get();

        if (count($detail_statement) > 0) {
            // dd('ok');
            $detail['statementData']['statement'] = $detail_statement[0];

            // dd(detail_tag($request, $db_section_id, $db_name));

            $db_section_id = 2;

            $detail_tag_collection = detail_tag($request->basic_id, $db_section_id);

            // dd($detail_tag_collection);

            if (isset($detail_tag_collection)) {

                foreach ($detail_tag_collection as $key => $value) {
                    $detail['statementData']['tag'][0] = $value;
                }
            }

            // dd('ok');

            $detail_reference_parents_collection = detail_reference_parents($detail, $request, $db_section_id);
            // dd($detail_reference_parents_collection);
            if (isset($detail_reference_parents_collection)) {
                $detail['statementData']['reference_parents'] = $detail_reference_parents_collection;
            }

            $detail_reference_children_collection = detail_reference_children($detail, $request,  $db_section_id);
            // dd($detail_reference_children_collection);
            if (isset($detail_reference_children_collection)) {
                $detail['statementData']['reference_children'] = $detail_reference_children_collection;
            }
        }

        // create activity collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_activity = DB::table('section_activities')
        ->where('basic_id', '=', $request->basic_id)
        ->get();

        // dd($detail_activity);

        if (count($detail_activity) > 0) {
            $detail['activityData']['activityTime'] = $detail_activity;

            $db_section_id = 4;

            $detail_tag_collection = detail_tag($request->basic_id, $db_section_id);

            // dd($detail_tag_collection);

            // dd($detail_tag_collection, $detail_source);
            // dd(array_key_exists(3, $detail_tag_collection[0]));


            if (isset($detail_tag_collection)) {

                // dd($detail_activity);

                foreach ($detail_activity as $key => $value) {
                    // dd($key);
                    // dd($value);



                        if (array_key_exists($value->id, $detail_tag_collection)) {
                            $detail['activityData']['tag'][$key] = $detail_tag_collection[$value->id];
                        }


                }
            }

            // dd('ok');

            $detail_tag_collection = detail_tag($request->basic_id, $db_section_id);

            // dd($detail_tag_collection);

            $detail_reference_parents_collection = detail_reference_parents($detail, $request, $db_section_id);
            // dd($detail_reference_parents_collection);
            if (isset($detail_reference_parents_collection)) {
                $detail['activityData']['reference_parents'] = $detail_reference_parents_collection;
            }

            $detail_reference_children_collection = detail_reference_children($detail, $request,  $db_section_id);
            // dd($detail_reference_children_collection);
            if (isset($detail_reference_children_collection)) {
                $detail['activityData']['reference_children'] = $detail_reference_children_collection;
            }
        }

        // create source collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_source = DB::table('section_sources')
        ->where('basic_id', '=', $request->basic_id)
        ->get();

        // dd($detail_source);

        if (count($detail_source) > 0) {
            $detail['sourceData']['files'] = $detail_source;

            $db_section_id = 3;

            // dd($detail);

            // fire 'create tags' function
            $detail_tag_collection = detail_tag($request->basic_id, $db_section_id);

            // dd($detail_tag_collection, $detail_source);
            // dd(array_key_exists(3, $detail_tag_collection[0]));


            if (isset($detail_tag_collection)) {

                foreach ($detail_source as $key => $value) {
                    // dd($key);
                    // dd($value);



                        if (array_key_exists($value->id, $detail_tag_collection)) {
                            $detail['sourceData']['tag'][$key] = $detail_tag_collection[$value->id];
                        }


                }
            }




            // dd($detail);

            // if (isset($detail_tag_collection)) {
            //
            // }
            // dd('ok');

            // fire 'create parents reference' function
            $detail_reference_parents_collection = detail_reference_parents($detail, $request, $db_section_id);
            // dd($detail_reference_parents_collection);
            if (isset($detail_reference_parents_collection)) {
                $detail['sourceData']['reference_parents'] = $detail_reference_parents_collection;
            }

            // fire 'create children reference' function
            $detail_reference_children_collection = detail_reference_children($detail, $request,  $db_section_id);
            // dd($detail_reference_children_collection);
            if (isset($detail_reference_children_collection)) {
                $detail['sourceData']['reference_children'] = $detail_reference_children_collection;
            }
        }

        // dd($section_raw);

        // $section_collection = array_slice($section_raw, 3);

        // dd($section_collection);

        // dd($detail);

        return Inertia::render('TabManager/TabManager', ['detail' => $detail]);

        // return Inertia::render('TabManager/TabManager', ['detail' => $detail])->toResponse($request)->setStatusCode(206);;
    }

    // store
    // -------------------------------------------------------
    public function store(Request $request) {

        // dd($request);

        // get user data
        $user = Auth::user();

        // validation
        $validated = $request->validate([
            'basicData.ref_date' => 'required',
            'basicData.medium' => 'required',
            'basicData.title' => 'required',
        ]);

        // dd($request);

        // create tag function
        function tagData($request, $index, $basics, $id2, $db_section_id, $db_name) {

            // dd($request, $index, $basics, $id2, $db_section_id, $db_name);

            // dd($request->$db_name['tag']);

            foreach ($request->$db_name['tag'][$index] as $key => $value) {

                // dd($value[0]);

                $content_check = DB::table('tag_categories')
                ->where('content', '=', $value[0])
                ->get();

                // dd($content_check);
                // dd($value);

                // check data availability. db uniqueness and store tag category
                if (isset ($value[0])) {

                    // dd('ok');

                    // dd($content_check);

                    if (count($content_check) > 0) {
                        // dd('ok');
                        // dd($content_check[0]);
                        $content = $content_check[0];

                        $tag1 = new Tag();
                        $tag1->basic_id = $basics->id;
                        $tag1->section_table = $db_section_id;
                        $tag1->section_table_id = $id2;
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
                        $tag1->section_table = $db_section_id;
                        $tag1->section_table_id = $id2;
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
                    $tag2->section_table = $db_section_id;
                    $tag2->section_table_id = $id2;
                    $tag2->tag_id = $tag1->id;
                    $tag2->tag_table = 2;
                    $tag2->tag_table_id = $content->id;
                    $tag2->tracking = $request->ip();
                    $tag2->save();
                };

                // check data availability and db uniqueness and store tag value
                if (isset ($value[2])) {
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
                    $tag3->section_table = $db_section_id;
                    $tag3->section_table_id = $id2;
                    $tag3->tag_id = $tag1->id;
                    $tag3->tag_table = 3;
                    $tag3->tag_table_id = $content->id;
                    $tag3->tracking = $request->ip();
                    $tag3->save();
                };

                // check availability and db uniqueness and store tag detail
                if (isset ($value[3])) {
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
                    $tag4->section_table = $db_section_id;
                    $tag4->section_table_id = $id2;
                    $tag4->tag_id = $tag1->id;
                    $tag4->tag_table = 4;
                    $tag4->tag_table_id = $content->id;
                    $tag4->tracking = $request->ip();
                    $tag4->save();
                };
            }
        };

        // create reference function
        function reference($db_id, $db_name, $request, $basics, $section_data, $i) {

            // dd($db_id, $db_name, $request, $basics, $section_data, $i);

            // foreach ($request->activityTo as $i=>$activity) {
            // foreach ($request->$db_name['reference'] as $key => $value) {
                $ref = new Ref();
                $ref->basic_id = $basics->id;
                $ref->basic_ref = $request->$db_name['reference'][$i]['basic_id'];
                $ref->ref_db_id = $db_id;
                $ref->ref_db_index = $section_data;
                $ref->tracking = $request->ip();
                $ref->save();
            // }

            // dd(['ref_id' => $ref->id]);

            return $ref->id;
        }

        // create basic
        $basics = new SectionBasic();
        $basics->ref_date = $request->basicData['ref_date'];
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

            // set section id
            $db_section_id = 2;
            $activities = 0;

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $db_section_id)
            ->pluck('db_name');
            $db_name = $form_section_name [0].'Data';

            // fire reference function
            if (isset($request->statementData['reference'])) {
                reference($db_section_id, $db_name, $request, $basics, $activities, 0);
            }

            // fire tag function
            if (isset ($request->statementData['tag'])) {
                tagData($request, 0, $basics, $statement->id, $db_section_id, $db_name);
            }
        }

        // create activity
        if ($request->activityData){

            // set section id
            $db_section_id = 4;

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $db_section_id)
            ->pluck('db_name');
            $db_name =  $form_section_name [0].'Data';

            // dd($request->activityData['activityTo']);

            foreach ($request->activityData['activityTo'] as $i => $activity) {

                // dd($i);
                // dd($activity);

                if (is_numeric($request->activityData['activityTo'][$i])) {

                    // store activity index data
                    $activites = new SectionActivity();
                    $activites->basic_id = $basics->id;
                    $activites->activityTime = $request->activityData['activityTime'][$i];
                    $activites->tracking = $request->ip();
                    $activites->created_at = now();
                    $activites->updated_at = now();
                    $activites->save();

                    // dd($activities);
                    // $activities_id = DB::table('section_activities')->insertGetId($activities[$i]);
                    // dd($$activities_id);

                    // fire reference function
                    // if (isset($request->activityData['reference'])) {
                    //     $checkValue = $request->activityData['reference'];
                    // }
                    // else $checkValue = '';
                    // dd($activities[0]);
                    // dd(reference($db_section_id, $db_name, $request, $basics, $activities_id, $i));

                    // dd($ref);

                    // dd(reference($db_section_id, $db_name, $request, $basics, $activities_id, $i));

                    $activites->ref_id = reference($db_section_id, $db_name, $request, $basics, $activites->id, $i);
                    $activites->save();

                    // $activities_reference = DB::table('section_activities')->insert(reference($db_section_id, $db_name, $request, $basics, $activites->id, $i));

                    // fire tag function
                    // dd($request->activityData['tag']);

                    if (isset($request->activityData['tag'][$i])) {
                        // dd($db_name);
                        tagData($request, $i, $basics, $activites->id, $db_section_id, $db_name);

                        // $request, $index, $basics, $id2, $db_name, $db_section_id
                    }
                }
            };


        }

        // create source
        if (isset ($request->sourceData['filelist'])) {

            // set section id
            $db_section_id = 3;

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $db_section_id)
            ->pluck('db_name');
            $db_name =  $form_section_name [0].'Data';

            // dd($request->sourceData['filelist']);

            // store file meta data
            foreach($request->sourceData['filelist'] as $index => $dataString) {

                $sources = new SectionSource();
                $sources->basic_id = $basics->id;
                $sources->path = $dataString['file']->hashName();
                $sources->extension = $dataString['file']->extension();
                $sources->size = $dataString['file']->getSize();
                $sources->tracking = $request->ip();
                $sources->save();

                // fire tag function
                // dd($request->activityData['tag']);
                if (isset($request->sourceData['tag'][$index])) {
                    // dd($db_name);
                    tagData($request, $index, $basics, $sources->id, $db_section_id, $db_name);
                    // tagData($request, $i, $basics, $activities_id, $db_section_id, $db_name);
                }
            }

            // create tag
            // if (isset ($request->sourceData['tag'])){
            //     tagData($db_section_id, $db_name, $request, $basics,$sources->id, $index);
            // }
            if (isset($request->sourceData['reference'])) {
                reference($db_section_id, $db_name, $request, $basics, $sources->basic_id, 0);
            };
            // reference($db_section_id, $db_name, $request, $basics, $activities_id, $i);

            // store file content data
            foreach($request->file('sourceData')['filelist'] as $dataString2) {
                Storage::disk('local')->put('public/images/inventory/', $dataString2['file']);
            }
        }

        // dd('ok');

        return redirect()->route('/')->with('message', 'Entry Successfully Created');
    }

    // update
    // -------------------------------------------------------
    public function update (Request $request) {
        // dd($request->statementData['statement']);
        // dd($request);

        // *****update basic data*****
        $update_basic_db_data = DB::table('section_basics')
        ->where('id', '=', $request->basicData['id'])
        ->update(['title' => $request->basicData['title'], 'ref_date' => $request->basicData['ref_date'], 'medium' => $request->basicData['medium']]);

        // *****update statement data*****
        $update_statement_db_data = DB::table('section_statements')
        ->where('basic_id', '=', $request->basicData['id'])
        ->update(['statement' => $request->statementData['statement']]);

        // *****update tag data*****

        // get tag table id by basic id
        $update_tag_db_data = DB::table('tags')
        ->where('basic_id', '=', $request->basicData['id'])
        ->where('status', '=', null)
        ->get()
        ->groupBy('tag_id')
        ->values();

        // dd($update_tag_db_data);
        // dd($request->statementData['tag']);




        // create db tag name collection
        // ------------------------------------------

        $db_tag_data = [];

        $a = 0;

        // split db tags in groups
        foreach ($update_tag_db_data as $i => $id) {

            // dd($id);

            $a2 = 0;
            foreach ($id as $i2 => $id2) {

                // dd($i2, $id2);

                switch ($i2) {
                    case 0:
                        $tag_table = 'tag_categories';
                        break;

                    case 1:
                        $tag_table = 'tag_contexts';
                        break;

                    case 2:
                        $tag_table = 'tag_values';
                        break;

                    case 3:
                        $tag_table = 'tag_details';
                        break;
                }

                // get tag group section name by tag table id
                $tag_table_id = DB::table($tag_table)
                ->where('id', '=', $id2->tag_table_id)
                ->get();

                foreach ($tag_table_id as $i3 => $id3) {
                    // dd($id3);
                    $db_tag_data[$a][$a2] = $id3->content;
                    $a2++;
                }

                // dd($tag_table_id[0]->content);

                // dd($tag_table_id[0]->content == $request);

            }
            $a++;

        }

        // dd($db_tag_data);



        // update db tags
        // ------------------------------------------

        // dd($request);

        // split updated tags in groups
        foreach ($request->statementData['tag'][0] as $i => $id) {

            // dd($i, $id);

            // check if tag group exists
            if (isset($db_tag_data[$i])) {

                // dd('ok');

                // get tag group section
                foreach ($id as $i2 => $id2) {
                // dd($id2);

                    // fire when tag group section name changed
                    // ---------------------------------



                    if ($id2 != $db_tag_data[$i][$i2]) {

                        // get tag section

                        switch ($i2) {
                            case 0:
                                $tag_table = 'tag_categories';
                                $tag_table_model = New TagCategory();
                                break;

                            case 1:
                                $tag_table = 'tag_contexts';
                                $tag_table_model = New TagContext();
                                break;

                            case 2:
                                $tag_table = 'tag_values';
                                $tag_table_model = New TagValue();
                                break;

                            case 3:
                                $tag_table = 'tag_details';
                                $tag_table_model = New TagDetail();
                                break;
                        }

                        // check if tag group section name exists
                        $tag_name_check = DB::table($tag_table)
                        ->where('content', '=', $id2)
                        ->get();

                        // dd($tag_name_check[0]->id);

                        // if name was found
                        if (isset($tag_name_check[0])) {
                            // dd('+');

                            // dd($update_tag_db_data[$i][$i2]);

                            $tag_name_check = DB::table('tags')
                            ->where('basic_id', '=', $update_tag_db_data[$i][$i2]->basic_id)
                            ->where('tag_id', '=', $update_tag_db_data[$i][$i2]->tag_id)
                            ->where('tag_table', '=', $update_tag_db_data[$i][$i2]->tag_table)
                            ->update(['tag_table_id' => $tag_name_check[0]->id]);
                        }

                        // if name was not found
                        else {

                            // $test = new TagCategory();

                            $tag_category = $tag_table_model;
                            $tag_category->content = $id2;
                            $tag_category->tracking = $request->ip();
                            $tag_category->save();

                            $tag_name_check = DB::table('tags')
                            ->where('basic_id', '=', $update_tag_db_data[$i][$i2]->basic_id)
                            ->where('tag_id', '=', $update_tag_db_data[$i][$i2]->tag_id)
                            ->where('tag_table', '=', $update_tag_db_data[$i][$i2]->tag_table)
                            ->update(['tag_table_id' => $tag_category->id]);
                        }
                    }
                }
            } else {

            // dd('ok');
            // dd($id2);

            // create new tag
            // ********************************************






                                // edit tag group section
                foreach ($id as $i2 => $id2) {

                    // dd($i2, $id2);

                    switch ($i2) {
                        case 0:
                            $tag_table = 'tag_categories';
                            $tag_table_model = New TagCategory();
                            break;

                        case 1:
                            $tag_table = 'tag_contexts';
                            $tag_table_model = New TagContext();
                            break;

                        case 2:
                            $tag_table = 'tag_values';
                            $tag_table_model = New TagValue();
                            break;

                        case 3:
                            $tag_table = 'tag_details';
                            $tag_table_model = New TagDetail();
                            break;
                    }








                // check if tag section name exists
                // -----------------------------------------------------

                // check if tag group section name exists
                $tag_name_check = DB::table($tag_table)
                ->where('content', '=', $id2)
                ->get();

                // dd($tag_name_check[0]->id);

                // if name was found
                if (isset($tag_name_check[0])) {
                    // dd('+');

                    // dd($update_tag_db_data[$i][$i2]);


                    // dd($i2);

                    $tag[$i2] = New Tag();
                    $tag[$i2]->basic_id = $request->basicData['id'];
                    $tag[$i2]->section_table = 2;
                    $tag[$i2]->section_table_id = $request->statementData['statement']['id'];
                    $tag[$i2]->tag_table = $i2+1;
                    $tag[$i2]->tag_table_id = $tag_name_check[0]->id;
                    $tag[$i2]->tracking = $request->ip();
                    $tag[$i2]->save();

                    // dd($tag);
                    // dd($tag[0]['id']);


                    $tag[$i2]->tag_id = $tag[0]['id'];

                    // dd($tag);

                    $tag[$i2]->save();
                }

                // if name was not found
                else {

                    dd('ok');

                    // $test = new TagCategory();

                    $tag_category = $tag_table_model;
                    $tag_category->content = $id2;
                    $tag_category->tracking = $request->ip();
                    $tag_category->save();

                    $tag_id = DB::table('tags')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->limit(1)
                    ->get();

                    $tag = New Tag();
                    $tag->basic_id = $request->basicData['id'];
                    $tag->section_table = 2;
                    $tag->section_table_id = $request->statementData['statement']['id'];
                    $tag->tag_id = $tag_id[0]->id;
                    $tag->tag_table = $i2;
                    $tag->tag_table_id = $tag_category->id;
                    $tag->tracking = $request->ip();
                    $tag->save();
                }








                // set tags main entry









                }



            }

        }


        // delete tags


                // get tag table id by basic id
                $update_tag_db_data = DB::table('tags')
                ->where('basic_id', '=', $request->basicData['id'])
                ->where('status', '=', null)
                ->get()
                ->groupBy('tag_id')
                ->values();

                // dd($update_tag_db_data);

                foreach ($update_tag_db_data as $i => $id) {

                    if (!isset($request->statementData['tag'][0][$i])) {
                        // dd($i);
                        // dd($update_tag_db_data[$i]);
                        // dd($update_tag_db_data[$i-1][0]->tag_id);

                        $tag_collection_basic_id = DB::table('tags')
                        ->where('basic_id', '=', $request->basicData['id'])
                        ->where('tag_id', '=', $update_tag_db_data[$i][0]->tag_id)
                        ->update(['status' => 2]);

                        // dd($tag_collection_basic_id);

                    }
                }













        // dd($update_tag_db_data);

        // *****update parent reference data*****
        // $update_parent_reference_db_data = DB::table('refs')
        // ->where('basic_id', '=', $request->basicData['id'])
        // ->update(['statement' => $request->statementData['statement']]);

        // dd($update_basic_dbdata);

        // DB::table('section_basics')
        // ->updateOrInsert(
        //     ['id' => 3],
        //     ['title' => 'Test123']
        // );
        return Inertia::render('Create', []);
    }

    // old update code
    // public function update(Request $request) {

    //     foreach($request->all() as $key => $value) {

    //         if ($key != 'id'){
    //             $update = DB::table('ricoassistants')
    //             ->where('id', $request->id)
    //             ->update([$key => $value]);
    //         }

    //     }
    //     return redirect()->route('/')->with('message', 'Entry Successfully Updated');
    // }

    public function delete(Request $request) {

        DB::table('basics')->where('id', '=', $request->id)->delete();

        return redirect()->route('/')->with('message', 'Entry Successfully Deleted');
    }

    // reference
    // -------------------------------------------------------
    public function reference(Request $request) {

        function reference_inheritance_list($id, $i, $user) {

            // dd($id, $i, $user);

            $counter = 1;

            $parent_list = [];

            // check if there are children
            $parent_ref = DB::table('refs')
            ->where('status', '=', null)
            ->where('basic_id', '=', $id->id)
            ->first();

            // dd($parent_ref);

            if (isset($parent_ref->basic_ref)) {
                // dd($parent_ref->basic_ref);
                $parent_checker_next_value = $parent_ref->basic_ref;

                do  {
                    if ($parent_ref->basic_id != $parent_ref->basic_ref) {
                        // get corresponding basic db entry data
                        $parent_basic = DB::table('section_basics')
                        ->where('status', '=', null)
                        ->where('user_id', '=', $user->id)
                        ->where('id', '=', $parent_checker_next_value)
                        ->first();

                        // dd($parent_basic);
                        // dd($parent_checker_next_value);

                        // check next ref db entry
                        $parent_ref = DB::table('refs')
                        ->where('status', '=', null)
                        ->where('basic_id', '=', $parent_checker_next_value)
                        ->first();

                        // dd($parent_ref);

                        array_push($parent_list, $parent_basic);
                        if (isset($parent_ref->basic_ref)) {
                        $parent_checker_next_value = $parent_ref->basic_ref;

                        $parent_checker = 1;
                        $counter++;
                        } else $parent_checker = 0;
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

            // dd($referencedIds);

            foreach ($referencedIds as $i => $id) {

                $result['referencesResult'][$i]['title'] = $id->title;
                $result['referencesResult'][$i]['medium'] = $id->medium;
                $result['referencesResult'][$i]['medium_name'] = DB::table('index_mediums')->where('id', '=', $id->medium)->pluck('medium_name');
                $result['referencesResult'][$i]['id'] = $id->id;
                $result['referencesResult'][$i]['ref_date'] = $id->ref_date;
                $result['referencesResult'][$i]['updated_at'] = $id->updated_at;

                // add activity diagram color tag



                // set ActivityDiagramColor id
                $activitydiagramcolor_id = DB::table('tag_contexts')
                ->where('content', '=', 'ActivityDiagramColor')
                ->get();

                // dd($activitydiagramcolor_id);

                if (count($activitydiagramcolor_id) > 0) {
                    // find ActivityDiagramColor id
                    $tag_id = DB::table('tags')
                    ->where('basic_id', '=', $id->id)
                    ->where('tag_table', '=', 2)
                    ->where('tag_table_id', '=', $activitydiagramcolor_id[0]->id)
                    ->get();

                    // dd($tag_id);
                    // dd($tag_id[0]->tag_id);

                    if (isset($tag_id[0]->tag_id)) {
                        $tag_value_id = DB::table('tags')
                        ->where('tag_id', '=', $tag_id[0]->tag_id)
                        ->where('tag_table', '=', 3)
                        ->get();

                        // dd($tag_value_id);

                        $tag_value_content = DB::table('tag_values')
                        ->where('id', '=', $tag_value_id[0]->tag_table_id)
                        ->get();

                    } else $tag_value_content = '';


                        // dd($tag_value_content[0]->content);
                    } else $tag_value_content = '';

                    if (isset($tag_value_content[0]->content)) {
                        $result['referencesResult'][$i]['color'] = $tag_value_content[0]->content;
                        // dd($result);
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

                // dd($referencesResultCheck);

            if (count($referencesResultCheck)) {

                // dd($referencesResultCheck);

                foreach ($referencesResultCheck as $i=>$id) {

                    if (count($referencesResultCheck) == 0) {} else {
                        $result['referencesResult'][$i]['title'] = $id->title;

                        // ActivityDiagramColor
                        // --------------------------------

                        // dd($id);
                        // dd($id->id);

                        // set ActivityDiagramColor id
                        $activitydiagramcolor_id = DB::table('tag_contexts')
                        ->where('content', '=', 'ActivityDiagramColor')
                        ->get();

                        // dd($activitydiagramcolor_id);

                        if (count($activitydiagramcolor_id) > 0) {
                        // find ActivityDiagramColor id
                        $tag_id = DB::table('tags')
                        ->where('basic_id', '=', $id->id)
                        ->where('tag_table', '=', 2)
                        ->where('tag_table_id', '=', $activitydiagramcolor_id[0]->id)
                        ->get();

                        // dd($tag_id);


                            $tag_value_id = DB::table('tags')
                            ->where('tag_id', '=', $tag_id[0]->tag_id)
                            ->where('tag_table', '=', 3)
                            ->get();

                            // dd($tag_value_id);

                            $tag_value_content = DB::table('tag_values')
                            ->where('id', '=', $tag_value_id[0]->tag_table_id)
                            ->get();

                            // dd($tag_value_content[0]->content);
                        } else $tag_value_content = '';

                        // dd($tag_table_id_context);

                        // foreach ($tag_table_id_context as $index=>$item) {

                        //     $tag_context_name = DB::table('tag_contexts')
                        //     ->where('id', '=', $item)
                        //     ->pluck('content')[0];

                        //     if ($tag_context_name == ActivityDiagramColor) break;
                        // }

                        // dd($tag_context_name);

                        // $tag = DB::table('tags')
                        //     ->where('basic_id', '=', $id->id)
                        //     ->where('tag_context', '=', 'ActivityDiagramColor')
                        //     ->get();

                        if (isset($tag_value_content[0]->content)) {
                            $result['referencesResult'][$i]['color'] = $tag_value_content[0]->content;
                            // dd($result);
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

        $tag_preset_group = DB::table('tag_presets')
        ->where('status', '=', null)
        ->get()
        ->groupBy('group_id');

        // dd($tag_preset_group);

        $tag_preset_context = [];
        $tag_preset_name;
        $presetId = 0;

        foreach ($tag_preset_group as $key => $value) {
            // dd($key, $value);

            $tag_preset_name = DB::table('index_tag_presets')
            ->where('id', '=', $key)
            ->pluck('preset_name')[0];

            $tag_preset_context[$presetId] = [$tag_preset_name];

            // $tag_preset_context[$presetId] = [];


            foreach ($value as $key2 => $value2) {
                // dd($key2, $value2);

                $tag_preset_category_name = DB::table('tag_categories')
                ->where('id', '=', $value2->tag_category)
                // ->where('status', '=', null)
                ->pluck('content');

                $tag_preset_context_name = DB::table('tag_contexts')
                ->where('id', '=', $value2->tag_context)
                // ->where('status', '=', null)
                ->pluck('content');

                // dd($tag_preset_category_name[0]);

                // $tag_preset_context_name =

                $tag_preset_context[$presetId][1][$key2][0] = $tag_preset_category_name[0];
                $tag_preset_context[$presetId][1][$key2][1] = $tag_preset_context_name[0];
                // dd($tag_preset_name);



            }
            // dd($tag_preset_context);
            $presetId++;
        }

        // dd($tag_preset_context);

        // $tag_preset_
        // DB::table('')

        // $tag_collection_preset

        $tagCollectionSelection['tagCollection'] = $tag_collection_category_context;
        $tagCollectionSelection['tagPresetCollection'] = $tag_preset_context;
        $tagCollectionSelection['misc']['parentId']= $request->parentId;
        $tagCollectionSelection['misc']['parentIndex']= $request->parentIndex;

        // dd($tagCollectionSelection);

        return Inertia::render('Create', ['fromController' => $tagCollectionSelection]);
    }

    // get tag list for tag selection
    // -------------------------------------------------------
    public function preset_store(Request $request) {

        // dd($request);
        // dd($request->preset_group['preset_name']);

        // if (isset($request->preset_group)) {
        //     // dd($request);

        // }

        // preset name duplicate check
        if (isset($request->preset_group)) {

            // dd($request->preset_group['preset_name']);

            $presetNameCheck = DB::table('index_tag_presets')
            ->where('preset_name', '=', $request->preset_group['preset_name'])
            ->where('status', '=', null)
            ->get();

            // dd($presetNameCheck);
            // dd(count($presetNameCheck));

            if (count($presetNameCheck) == 0) {
                // dd('ok');
                $tag_preset = new IndexTagPreset();
                $tag_preset->preset_name = $request->preset_group['preset_name'];
                $tag_preset->tracking = $request->ip();
                $tag_preset->save();
            }

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

                // dd( $tags_context_id[0]);

                if(count($tags_context_id)) {
                    // dd($tags_context_id[0]);
                    $tag_preset->tag_context = $tags_context_id[0]->tag_table_id;
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
        // Route::post('/tag', [RicoAssistant::class, 'tag'])->name('tag');
        // return redirect()->route('tag')->with('message', 'Entry Successfully Created');
    }

    public function preset_update(Request $request) {

        // dd($request);
        // dd($request->tagPresetRenameOld);

        DB::table('index_tag_presets')
        ->where('preset_name', '=', $request->tagPresetRenameOld)
        ->update(['preset_name' => $request->tagPresetRenameNew]);

        return Inertia::render('Create');
    }

    public function preset_delete(Request $request) {

        // dd($request);
        // dd($request->tagPresetRenameOld);
        if (isset($request->tagPresetGroupDeleteIndex)) {

            $preset_name_id = DB::table('index_tag_presets')
            ->where('preset_name', '=', $request->tagPresetGroupDeleteIndex)
            ->where('status', '=', null)
            // ->update(['status' => 2]);
            ->get();

            // dd($preset_name_id);

            $preset_group_total = DB::table('tag_presets')
            ->where('group_id', '=', $preset_name_id[0]->id)
            ->where('status', '=', null)
            ->get();

            $preset_group_deletion = $preset_group_total[$request->tagPresetGroupDeleteSubindex]->id;
            // dd($preset_group_deletion);

            DB::table('tag_presets')
            ->where('id', '=', $preset_group_deletion)
            ->where('status', '=', null)
            ->update(['status' => 2]);

            $preset_group_remaining = DB::table('tag_presets')
            ->where('group_id', '=', $preset_name_id[0]->id)
            ->where('status', '=', null)
            ->get();

            // dd($preset_group_remaining);

            if(count($preset_group_remaining) <= 0) {
                DB::table('index_tag_presets')
                ->where('preset_name', '=', $request->tagPresetGroupDeleteIndex)
                ->where('status', '=', null)
                // ->update(['status' => 2]);
                ->update(['status' => 2]);
            }

            // dd($preset_group_remaining);

            // dd($preset_group_total);

        }

        // set status to 2 (delete) for preset name
        if (isset($request->tagPresetDelete)) {

        $preset_delete_id = DB::table('index_tag_presets')
        ->where('preset_name', '=', $request->tagPresetDelete)
        // ->update(['status' => 2]);
        ->get();

        DB::table('index_tag_presets')
        ->where('preset_name', '=', $request->tagPresetDelete)
        ->update(['status' => 2]);
        // ->get();

        // dd($preset_delete_id);
        // $preset_delete_id->update(['status' => 22]);

        // set status to 2 (delete) for preset name
        DB::table('tag_presets')
        ->where('group_id', '=', $preset_delete_id[0]->id)
        ->update(['status' => 2]);
    }

        // dd($preset_delete_id[0]->id);

        return Inertia::render('Create');
        // return redirect()->route('tag')->with('message', 'Entry Successfully Created');
    }

    public function edit(Request $request) {

        // dd($request);
        // $request_data = (object)[];

        // if (isset($request->statementData)) {
        //     $request_data->basicData = $request->basicData;
        //     $request_data = $request;
        // }

        // dd($request_data);
        // dd($request->statementData['tag']);
        // $request_data = $request->statementData['tag'];
        // dd($request_data);
        // dd(count($request->statementData));
        // return Inertia::render('Create', ['tag'=> $request['statementData']['tag']]);
        return Inertia::render('Create', ['edit' => $request]);
    }
}
