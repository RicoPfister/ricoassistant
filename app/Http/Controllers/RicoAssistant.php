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
use App\Models\Tag_0;
use App\Models\Tag_1;
use App\Models\Tag_2;
use App\Models\Tag_3;

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

        if (isset($user)) {$userAuth = SectionBasic::all()
            ->where('user_id', '=', $user->id)
            ->where('status', '=', null)
            ->take(20)->sortByDesc('updated_at');

            $listAuth = $publicAuth->merge($userAuth);}
        else {$listAuth = $publicAuth;};

        // dd($listAuth);

        return Inertia::render('TabManager/TabManager', ['list' => $listAuth]);
    }

    public function detail(Request $request) {

        // dd($request);

        $user = Auth::user();

        // get detail tags
        function detail_tag($basic_id, $section_id) {

            // dd($basic_id, $section_id);

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');
            $db_name = $form_section_name[0].'Data';

            switch($db_name) {
                case 'statementData':
                    $tag_section = 'section_statements';
                    $tag_section_request = 'statement';
                    break;

                case 'activityData':
                    $tag_section = 'section_activities';
                    $tag_section_request = 'activityTo';
                    break;

                case 'sourceData':
                    $tag_section = 'section_sources';
                    $tag_section_request = 'filelist';
                    break;
            }

            // tag section group collection
            $tag_section_id_collection = DB::table($tag_section)
            ->where('basic_id', '=', $basic_id)
            ->get();

            // dd($tag_section_id_collection);

            // get tag section section
            $tag_rawdata = DB::table('tags')
            ->where('basic_id', '=', $basic_id)
            ->where('section', '=', $section_id)
            ->where('status', '=', null)
            ->get()
            ->groupBy(['section_id']);

            // dd($tag_rawdata);

            // foreach tag section section
            foreach ($tag_section_id_collection as $section_index => $section_item) {

                // dd($section_index, $section_item);

                // check if tag section section contains any tags
                if ($tag_rawdata->has($section_item->id)) {

                    foreach ($tag_rawdata[$section_item->id] as $rawgroup_index => $rawgroup_item) {

                        // dd($rawgroup_index, $rawgroup_item);

                        $detail[$db_name]['tag'][$section_index][$rawgroup_index] = [];

                        for ($ii = 0; $ii < 4; $ii++) {

                            // dd('ok');

                            // table name and table column name object
                            $tag_group_section = ['tag_0s', 'tag_1s', 'tag_2s','tag_3s'];
                            $tag_group_section_id = ['tag_0_id', 'tag_1_id', 'tag_2_id','tag_3_id'];

                            // convert to string
                            $tag_group_section_id_string = strval($tag_group_section_id[$ii]);

                            // get tag group section tag name
                            $tag_group_content = DB::table($tag_group_section[$ii])
                            ->where('id', '=',$rawgroup_item->$tag_group_section_id_string)
                            ->pluck('content');

                            // dd($tag_group_content);

                            // set tag name to tag group section name array
                            if (count($tag_group_content) > 0) {
                                // if ($key2 == 1) dd($e, $key2, count($tag_group_content));
                                // dd('ok');
                                array_push($detail[$db_name]['tag'][$section_index][$rawgroup_index], $tag_group_content);

                            }
                        }
                    }
                } else $detail[$db_name]['tag'][$section_index] = [];
            }

            // dd($detail[$db_name]['tag']);
            return $detail[$db_name]['tag'];
        }

        function detail_reference_parents($detail, $request, $section_id) {

            // dd('ok');

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');
            $db_name = $form_section_name [0].'Data';

            $i = 0;
            $basic_ref = $detail['basicData']['id'];

            // dd($basic_ref);

            // get reference id
            $reference_id = DB::table('refs')
            ->where('status', '=', null)
            ->where('basic_id', '=', $basic_ref)
            ->where('ref_db_id', '=', $section_id)
            // ->join('section_basic', 'section_basic.id', '=', )
            ->get();

            // dd($reference_id);

            // if (count(reference_id) > 0) {

                foreach ($reference_id as $key => $value) {

                    // dd($reference_id, $key, $value);

                    $basic_ref = $value->basic_ref;

                    $i = 0;
                    do {
                        $_reference_parents_id = DB::table('section_basics')
                        ->where('id', '=', $value->basic_ref)
                        ->where('status', '=', null)
                        ->get();

                        // dd($value->basic_ref);
                        // dd($_reference_parents_id);

                        // if ($i == 99) dd($_reference_parents_id);

                        if (count($_reference_parents_id) < 1) {
                            break;
                        }

                        $detail['reference_parents'][$key][$i] = $_reference_parents_id[0];

                        // add color if exist


                            $_tag_color_id = DB::table('tags')
                            ->where('basic_id', '=', $value->basic_ref)
                            ->where('status', '=', null)
                            ->get();

                            // dd($_tag_color_id);

                            if (isset($_tag_color_id[0]->tag_2_id)) {

                                $_tag_color_name = DB::table('tag_2s')
                                ->where('id', '=', $_tag_color_id[0]->tag_2_id)
                                // ->where('status', '=', null)
                                ->get();

                                // dd($_tag_color_name);

                                $detail['reference_parents'][$key][$i]->color = $_tag_color_name[0]->content;
                            }

                        // dd($detail);
                        $i++;

                        // dd($basic_ref);

                        $next_value = DB::table('refs')
                        ->where('basic_id', '=', $value->basic_ref)
                        ->where('status', '=', null)
                        // ->join('section_basic', 'section_basic.id', '=', )
                        ->get();

                        // dd($reference_id);
                        // dd($next_value);

                        // if ref was not found (parent entry deleted?) set blank parent reference value
                        // if (count($next_value) < 1) {
                        //     break;
                        // }

                        if (count($next_value) > 0 && $next_value[0]->basic_ref != $basic_ref)  {
                            $value = $next_value[0];
                        } else $next_value = [];

                        // dd($value);
                        // dd(count($value) > 0);

                    } while (count($next_value) > 0);
                }
            // }
            // dd('ok');
            if (isset($detail['reference_parents'])) return $detail['reference_parents'];
        }

        function detail_reference_children($detail, $request, $section_id) {

            // dd('ok');

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->where('status', '=', null)
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

        // increment view count
        DB::table('section_basics')
        ->where('id', '=', $request->basic_id)
        ->increment('view_count');

        // create statement collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_statement = DB::table('section_statements')
        ->where('status', '=', null)
        ->where('basic_id', '=', $request->basic_id)
        ->get();

        // dd($detail_statement);

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

            // dd($detail);

            $detail_reference_children_collection = detail_reference_children($detail, $request,  $db_section_id);
            // dd($detail_reference_children_collection);
            if (isset($detail_reference_children_collection)) {
                $detail['statementData']['reference_children'] = $detail_reference_children_collection;
            }
        }

        // create activity collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_activity = DB::table('section_activities')
        ->where('status', '=', null)
        ->where('basic_id', '=', $request->basic_id)
        ->get();

        // dd($detail_activity);

        if (count($detail_activity) > 0) {
            $detail['activityData']['activityTo'] = $detail_activity;

            // dd($detail);

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
            if (isset($detail_tag_collection)) {
                $detail['activityData']['tag'] = $detail_tag_collection;
            }

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

        // dd($detail);

        // create source collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_source = DB::table('section_sources')
        ->where('status', '=', null)
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

            // if (isset($detail_tag_collection)) {

            //     foreach ($detail_source as $key => $value) {
            //         dd($key, $value);

            //         if (array_key_exists($value->id, $detail_tag_collection)) {
            //             $detail['sourceData']['tag'][$key] = $detail_tag_collection[$value->id];
            //         }
            //     }
            // }

            // dd($detail_tag_collection);

            if (isset($detail_tag_collection)) {
                $detail['sourceData']['tag'] = $detail_tag_collection;
            }

            // if (isset($detail_tag_collection)) {
            //
            // }
            // dd('ok');

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
    }

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

            // dd($request->$db_name['tag']);

            // check if there are any client tag update
            if (isset($request->$db_name['tag'][$index])) {

                // dd($request, $index, $basics, $id2, $db_section_id, $db_name);

                // dd($request->$db_name['tag']);

                // split in tag group
                foreach ($request->$db_name['tag'][$index] as $key => $value) {

                    // dd($value, $key);
                    // dd($content_check);

                    // check data availability. db uniqueness and store tag category

                    $content_check = [];
                    $tag_group_section_name = [];

                    foreach ($value as $value_index => $value_item) {

                        // dd($value_index, $value_item);

                        $content_check[$value_index] = DB::table('tag_'.$value_index.'s')
                        ->where('content', '=', $value_item)
                        ->get();

                        // dd($content_check);

                        if (count($content_check[$value_index]) > 0) $tag_group_section_name[$value_index] = $content_check[$value_index][0];
                        else {
                            $tag_group_section_name_collection = [New Tag_0(), New Tag_1(), New Tag_2(), New Tag_3()];

                            $tag_group_section_name[$value_index] = $tag_group_section_name_collection[$value_index];
                            $tag_group_section_name[$value_index]->content = $value_item;
                            $tag_group_section_name[$value_index]->tracking = $request->ip();
                            $tag_group_section_name[$value_index]->save();
                        }
                    }

                    $tag_group = new Tag();
                    $tag_group->basic_id = $basics->id;
                    $tag_group->section = $db_section_id;
                    $tag_group->section_id = $id2;
                    $tag_group->tag_0_id =  $tag_group_section_name[0]->id;
                    $tag_group->tag_1_id =  $tag_group_section_name[1]->id;
                    $tag_group->tag_2_id =  $tag_group_section_name[2]->id;
                    $tag_group->tracking = $request->ip();
                    $tag_group->save();

                    if (isset($content_check[3])) {
                        $tag_group->tag_3_id = $tag_group_section_name[3]->id;
                        $tag_group->save();
                    }
                }

                // dd( $tag_group_section_name);
                // dd( $content_check);


            }
        };

        // create reference function
        function reference($db_id, $db_name, $request, $basics, $section_data, $i) {

            // dd($db_id, $db_name, $request, $basics, $section_data, $i);

            // dd($request->$db_name['reference'][$i][0]['basic_id']);

            // foreach ($request->$db_name['reference_parents'] as $key => $value) {
                $ref = new Ref();
                $ref->basic_id = $basics->id;
                $ref->basic_ref = $request->$db_name['reference_parents'][$i][0]['basic_id'];
                $ref->ref_db_id = $db_id;
                $ref->ref_db_index = $section_data->id;
                $ref->tracking = $request->ip();
                $ref->save();
            // }

            // dd(['ref_id' => $ref->id]);

            // dd($ref);
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

            // dd('ok');

            $statement = new SectionStatement();
            $statement->basic_id = $basics->id;
            $statement->statement = $request->statementData['statement']['statement'];
            $statement->tracking = $request->ip();
            $statement->save();

            // set section id
            $db_section_id = 2;
            $activities = 0;

            // get database name based on section id
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $db_section_id)
            ->pluck('db_name');
            $db_name = $form_section_name[0].'Data';

            // fire reference function
            if (isset($request->statementData['reference_parents'])) {
                // dd('ok');
                reference($db_section_id, $db_name, $request, $basics, $statement, 0);
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

            foreach ($request->activityData['activityTime'] as $i => $activity) {

                // dd($i);
                // dd($activity);

                if (is_numeric($request->activityData['activityTime'][$i])) {

                    // store activity index data
                    $activites = new SectionActivity();
                    $activites->basic_id = $basics->id;
                    $activites->activityTime = $request->activityData['activityTime'][$i];
                    $activites->tracking = $request->ip();
                    $activites->created_at = now();
                    $activites->updated_at = now();
                    $activites->save();

                    $activites->ref_id = reference($db_section_id, $db_name, $request, $basics, $activites, $i);
                    $activites->save();

                    // fire tag function
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

                // dd($dataString->type);

                $sources = new SectionSource();
                $sources->basic_id = $basics->id;
                $sources->path = $dataString['file']->hashName();
                $sources->extension = $dataString['type'];
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
            if (isset($request->sourceData['reference_parents'])) {
                reference($db_section_id, $db_name, $request, $basics, $sources, 0);
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

    public function update(Request $request) {

        // dd($request);

        // update parent reference data
        function update_reference($request, $section_id) {

            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');

            $db_name = $form_section_name[0].'Data';

            // get section data
            switch($db_name) {
                case 'statementData':
                    $tag_section = 'section_statements';
                    $tag_section_request = 'statement';
                    break;

                case 'activityData':
                    $tag_section = 'section_activities';
                    $tag_section_request = 'activityTo';
                    break;

                case 'sourceData':
                    $tag_section = 'section_sources';
                    $tag_section_request = 'filelist';
                    break;
            }

            // check if client reference is found if not delete reference
            if (isset($request->$db_name['reference_parents'])) {

                // dd($request, $section_id, $index);

                // ref section data
                $rererence_db_section_data = DB::table($tag_section)
                ->where('status', '=', null)
                ->where('basic_id', '=', $request->basicData['id'])
                // ->wehre('ref_db_index', '=', )
                // ->limit(1)
                ->get();

                // dd($rererence_db_section_data);

                $rererence_db_data = DB::table('refs')
                ->where('status', '=', null)
                ->where('basic_id', '=', $request->basicData['id'])
                ->where('ref_db_id', '=', $section_id)
                // ->wehre('ref_db_index', '=', )
                ->get();

                // dd($rererence_db_data);

                // create ref if no one was found
                if (count($rererence_db_data) < 1) {

                    $ref = New Ref();
                    $ref->basic_id = $request->basicData['id'];
                    $ref->basic_ref = $request->$db_name['reference_parents'][0][0]['basic_id'];
                    $ref->ref_db_id = $section_id;
                    $ref->ref_db_index = $rererence_db_section_data[0]->id;
                    $ref->tracking = $request->ip();
                    $ref->save();
                }

                //
                foreach($rererence_db_data as $index => $item) {

                    // dd($index, $item);

                    $reference_basic_db_data = DB::table('section_basics')
                    ->where('id', '=', $rererence_db_data[$index]->basic_ref)
                    ->get();

                    // dd('ok');

                    if ($reference_basic_db_data[0]->title !== $request->$db_name['reference_parents'][$index][0]['title']) {

                        // dd('ok');

                        $basic_ref = DB::table('section_basics')
                        ->where('title', '=', $request->$db_name['reference_parents'][$index][0]['title'])
                        ->get();

                        // dd($basic_ref[0]->id);
                        // dd($request->$db_name);

                        if (isset($request['sourceData'])) {
                            // dd('ok');
                            $ref = DB::table('refs')
                            ->where('basic_id', '=', $request->basicData['id'])
                            ->where('ref_db_id', '=', $section_id)
                            ->update(['basic_ref' => $basic_ref[0]->id]);
                        }

                        else {
                            // dd('ok');
                            $ref = DB::table('refs')
                            ->where('basic_id', '=', $request->basicData['id'])
                            ->where('ref_db_id', '=', $section_id)
                            ->where('ref_db_index', '=', $rererence_db_section_data[$index]->id)
                            ->update(['basic_ref' => $basic_ref[0]->id]);

                        }
                        // ->get();

                        // dd($ref);
                    }

                    // dd($request->$db_name['reference_parents'][$index]);

                    // delete obsolete refs
                    if (!isset($request->$db_name['reference_parents'][$index])) {
                        $ref = DB::table('refs')
                        ->where('basic_id', '=', $request->basicData['id'])
                        ->where('ref_db_id', '=', $section_id)
                        ->where('ref_db_index', '=', $request->$db_name[$tag_section_request]['id'])
                        ->update(['status' => 2]);
                    }
                }
            }

            else if (isset($request->$db_name['reference_parents']) && $request->$db_name['reference_parents'] == '') {
                // delete obsolete ref

                    // dd($tag_section_request);
                    // dd($request->$db_name[]);

                    $ref = DB::table('refs')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->where('ref_db_id', '=', $section_id)
                    ->where('ref_db_index', '=',  $request->$db_name[$tag_section_request]['id'])
                    ->update(['status' => 2]);
            }
        }

        // step 3.1: update tag group section name
        function update_tag_ref2($update_tag_db_group, $tag_name_check_array, $index, $index2, $index3, $tag_group_section_id_string) {

            // dd($update_tag_db_group, $tag_name_check_array, $index, $index2, $index3, $tag_group_section_id_string);
            // dd($update_tag_db_group[$index][0][$index2]);

            $tag_name_check = DB::table('tags')
            ->where('id', '=', $update_tag_db_group[$index][0][$index2]->id)
            // ->where('section', '=', $update_tag_db_group[$index][0][$index2]->section)
            // ->where('section_id', '=', $update_tag_db_group[$index][0][$index2]->section_id)
            ->update([$tag_group_section_id_string => $tag_name_check_array]);

            // dd($tag_name_check);
        };

        // step 3.2: create tag group section name
        function create_tag_ref2($request, $section_id, $index, $index2, $item, $item2, $tag_name_check_array, $tag_group_section_id_string, $tag_table, $update_tag_db_group, $update_tag_db_data_indexed) {

            // dd($request, $section_id, $index, $index2, $item, $item2, $tag_name_check_array, $tag_group_section_id_string, $tag_table, $update_tag_db_group, $update_tag_db_data_indexed);

            $tag_name_check = [];

            for ($aa = 0; $aa < 3; $aa++) {

                $tag_group_section_id = ['tag_0s', 'tag_1s', 'tag_2s','tag_3s'];

                $tag_name_check[$aa] = DB::table($tag_group_section_id[$aa])
                ->where('content', '=', $item2[$aa])
                ->get()
                ->all()[0];

                if (isset($item2[3])) {
                    $tag_name_check[3] = DB::table($tag_group_section_id[3])
                    ->where('content', '=', $item2[3])
                    ->get()
                    ->all()[0];
                }
            }

            $tag = New Tag();
            $tag->basic_id = $request->basicData['id'];
            $tag->section = $section_id;
            $tag->section_id =$update_tag_db_data_indexed[$index][0]->id;
            $tag->tag_0_id = $tag_name_check[0]->id;
            $tag->tag_1_id = $tag_name_check[1]->id;
            $tag->tag_2_id = $tag_name_check[2]->id;
            $tag->tracking = $request->ip();
            $tag->save();

            if (isset($tag_name_check[3])) {
                $tag->tag_3_id = $tag_name_check[3]->id;
                $tag->save();
            }
        };

        // step 3: check if client tag group section names must be updated or created
        function update_tag_group_sections($request, $index, $item, $update_tag_db_data, $update_tag_db_group, $section_id, $tag_section, $update_tag_db_section, $tag_id, $update_tag_db_data_indexed) {

            //  dd($item);

            // check if client tag group exists if not set the group to 2 (deleted)
            if (isset($item)) {

                // get tag section tag groups
                foreach($item as $index2 => $item2) {

                    // get tag section group section
                    foreach($item2 as $index3 => $item3) {

                        // dd($request, $index, $item, $index2, $item2, $index3, $item3);

                        // set tag section name table
                        switch ($index3) {
                            case 0:
                                $tag_table = 'tag_0s';
                                $tag_table_model = New Tag_0();
                                break;

                            case 1:
                                $tag_table = 'tag_1s';
                                $tag_table_model = New Tag_1();
                                break;

                            case 2:
                                $tag_table = 'tag_2s';
                                $tag_table_model = New Tag_2();
                                break;

                            case 3:
                                $tag_table = 'tag_3s';
                                $tag_table_model = New Tag_3();
                                break;
                        }

                        // check if tag group section name exists
                        $tag_name_check = DB::table($tag_table)
                        ->where('content', '=', $item3)
                        ->get()
                        ->all();

                        // dd($tag_name_check);

                        // update tag group section name reference (tag_table_id)
                        // ----------------------------------------

                        // if tag name was not found create it
                        if (!isset($tag_name_check[0])) {
                            $tag_category = $tag_table_model;
                            $tag_category->content = $item3;
                            $tag_category->tracking = $request->ip();
                            $tag_category->save();

                            $tag_name_check_array = '';
                            $tag_name_check_array = $tag_category->id;

                        } else {
                            $tag_name_check_array = '';
                            $tag_name_check_array = $tag_name_check[0]->id;
                        }

                        // client update tag data process
                        // dd($request->activityData['tag'], $index, $item, $index2, $item2, $index3, $item3, $update_tag_db_group);
                        // dd($update_tag_db_group[$index][$index2]);

                        $tag_group_section_id = ['tag_0_id', 'tag_1_id', 'tag_2_id','tag_3_id'];
                        $tag_group_section_id_string = strval($tag_group_section_id[$index3]);

                        // dd($update_tag_db_group[$index][0][$index2]->$tag_group_section_id_string);
                        // dd($tag_group_section_id_string);
                        // dd($update_tag_db_group);

                        // if tag ref was found
                        if (isset($update_tag_db_group[$index][0][$index2]->$tag_group_section_id_string)) {
                            // dd('update', $index, $index2, $index3);
                            update_tag_ref2($update_tag_db_group, $tag_name_check_array, $index, $index2, $index3, $tag_group_section_id_string);
                        }
                    }

                    // dd($update_tag_db_group, $item2);
                    // dd(isset($update_tag_db_group[0][0][4]->tag_3_id));
                    // if ($index2 == 1) dd($update_tag_db_group, $item2, !isset($item2[3]));

                    // check and create tag reference id
                    // if ($index == 0 && $index2 == 4) dd($update_tag_db_group[$index][0]);
                    if (!isset($update_tag_db_group[$index][0][$index2]->tag_0_id)) {
                        // dd($index2, $item2, $update_tag_db_group[$index]);
                        // dd('create', $index, $index2, $index3, $item, $item2, $item3);
                        // dd($update_tag_db_group);
                        create_tag_ref2($request, $section_id, $index, $index2, $item, $item2, $tag_name_check_array, $tag_group_section_id_string, $tag_table, $update_tag_db_group, $update_tag_db_data_indexed);
                    }

                    // dd($item2, $update_tag_db_group[$index][0][$index2]->tag_3_id);

                    // check and delete detail in db
                    if (!isset($item2[3]) && isset($update_tag_db_group[$index][0][$index2]->tag_3_id)) {
                        // dd($update_tag_db_group[$index][0][$index2]->id);

                        DB::table('tags')
                        ->where('id', '=', $update_tag_db_group[$index][0][$index2]->id)
                        ->update(['tag_3_id' => null]);
                    }

                    // ckeck and update detail in db
                    if (isset($item2[3]) && !isset($update_tag_db_group[$index][0][$index2]->tag_3_id) && isset($update_tag_db_group[$index][0][$index2]->id)) {
                        // dd($update_tag_db_group, $item2[3]);
                        // dd($update_tag_db_group[$index][0][$index2]);

                        $db_table_section_data_collection = DB::table('tag_3s')
                        ->where('content', '=', $item2[3])
                        ->get();

                        // dd($update_tag_db_group[$index][0][0]->id, $db_table_section_data_collection[0]->id);

                        // dd($db_table_section_data_collection);
                        // dd($update_tag_db_group[$index][0][0]);

                        DB::table('tags')
                        ->where('id', '=', $update_tag_db_group[$index][0][$index2]->id)
                        // ->where('status', '=', null)
                        ->update(['tag_3_id' => $db_table_section_data_collection[0]->id]);
                    }
                }

            }

            else if (isset($update_tag_db_section[$index])) {

                foreach ($update_tag_db_section[$index] as $index2 => $item2) {

                    // dd($item2);

                    // deletee db tags collection
                    DB::table('tags')
                    ->where('id', '=', $item2->id)
                    ->update(['status' => 2]);
                }
            }
        }

        // update, create or delete tag group section names
        function update_tag2($request, $section_id) {

            $tag_id = '';

            // dd($request, $section_id);

            // step 1: defining basic meta data

            // get client update section name
            $form_section_name  = DB::table('index_databases')
            ->where('id', '=', $section_id)
            ->pluck('db_name');

            $db_name = $form_section_name[0].'Data';

            // get db section table name
            switch($db_name) {
                case 'statementData':
                    $tag_section = 'section_statements';
                    $tag_section_request = 'statement';
                    break;

                case 'activityData':
                    $tag_section = 'section_activities';
                    $tag_section_request = 'activityTo';
                    break;

                case 'sourceData':
                    $tag_section = 'section_sources';
                    $tag_section_request = 'placeholder';
                    break;
            }

            // get table section data
            $db_table_section_data = DB::table($tag_section)
            ->where('basic_id', '=', $request->basicData['id'])
            ->get()
            ->groupBy('id');

            // dd($db_table_section_data);

            $update_tag_db_data_indexed =  $db_table_section_data->values();
            // dd($update_tag_db_data_indexed);

            // get db tags collection
            $update_tag_db_data = DB::table('tags')
            ->where('basic_id', '=', $request->basicData['id'])
            ->where('section', '=', $section_id)
            ->where('status', '=', null)
            ->get()
            ->groupBy(['section_id']);
            // ->groupBy('tag_id');

            // dd($update_tag_db_data);

            // create db tag table index collection
            $a = 0;

            $update_tag_db_section = collect([]);
            foreach($db_table_section_data as $section_index => $section_item) {
                if (isset($update_tag_db_data[$section_index])) $update_tag_db_section[$a] = $update_tag_db_data[$section_index];
                $a++;
            }

            // dd($update_tag_db_section);

            foreach($update_tag_db_section as $group_index => $group_item) {

                $group_collection = collect($group_item);
                $update_tag_db_group[$group_index] =  $group_collection->groupBy('tag_id')->values();
            }

            if (!isset($update_tag_db_group)) {
                $update_tag_db_group = '';
            }

            // dd($update_tag_db_group);




            // step 2: check if there are any tags from client to be updated if not delete all basic_id related tags
            if (isset($request->$db_name['tag']) && $request->$db_name['tag'] != null) {

                //  dd('OK');

                // for each form section
                foreach($request->$db_name['tag'] as $index => $item) {

                    update_tag_group_sections($request, $index, $item, $update_tag_db_data, $update_tag_db_group, $section_id, $tag_section, $update_tag_db_section, $tag_id, $update_tag_db_data_indexed);
                }

                if ($update_tag_db_group != '') {

                    // dd($update_tag_db_group);
                    // set status of all empty client tag groups to 2 (delete)
                    foreach($update_tag_db_group as $db_tag_group_index => $db_tag_group_item) {

                        // dd($db_tag_group_index, $db_tag_group_item);

                        // delete tag if there is no tag client update found
                        foreach($db_tag_group_item[0] as $db_tag_group_section_index => $db_tag_group_section_item) {

                            // dd('ok');

                            // dd($db_tag_group_section_index, $db_tag_group_section_item);
                            // dd($request->$db_name['tag'][1][3]);

                            if (!isset($request->$db_name['tag'][$db_tag_group_index][$db_tag_group_section_index])) {

                                // dd($db_tag_group_index, $db_tag_group_section_index);

                                // dd($update_tag_db_group[$db_tag_group_index][0][$db_tag_group_section_index]);

                                DB::table('tags')
                                ->where('id', '=', $update_tag_db_group[$db_tag_group_index][0][$db_tag_group_section_index]->id)
                                ->update(['status' => 2]);
                            };
                        }
                    }
                }
            }

            // step 2.1: delete groups with no content
            else {

                // delete all entry tags (set to status 2)
                if (count($update_tag_db_data) > 0) {
                    DB::table('tags')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->update(['status' => 2]);
                }
            }
        }

        function delete_entry() {

            // tag: set status 2 (deleted)
            // get tag table id by basic id
            $update_tag_db_data = DB::table('tags')
            ->where('basic_id', '=', $request->basicData['id'])
            ->where('status', '=', null)
            ->get()
            ->groupBy('tag_id')
            ->values();

            foreach ($update_tag_db_data as $i => $id) {

                if (!isset($request->statementData['tag'][0][$i])) {
                    $tag_collection_basic_id = DB::table('tags')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->where('tag_id', '=', $update_tag_db_data[$i][0]->tag_id)
                    ->update(['status' => 2]);
                }
            }
        }

        // section update

        // update statement
        if (isset($request->statementData['statement']['statement'])) {

            if ($request->statementData['statement']['statement'] != []) {

            $section_id = 2;

            $update_statement_db_data = DB::table('section_statements')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['statement' => $request->statementData['statement']['statement']]);
            update_tag2($request, $section_id);
            update_reference($request, $section_id);

            }

            // else {
            //     $delete_basic_check2 = 1;
            // }
        }

        // update activity data

        if (isset($request->activityData)) {
            // dd($request->activityData['activityTo'][0] == '');

            // check if time index 0 was found
            if ($request->activityData['activityTo'][0] != '') {

                $update_activity_db_data = DB::table('section_activities')
                ->where('basic_id', '=', $request->basicData['id'])
                ->get();

                // dd($update_activity_db_data);
                // dd($request->activityData['activityTime']);

                function reference($index, $section_activity, $request) {

                    // dd($db_id, $db_name, $request, $basics, $section_data, $i);

                    // dd($request->$db_name['reference'][$i][0]['basic_id']);

                    // duplicated command

                        $ref = new Ref();
                        $ref->basic_id = $request->basicData['id'];
                        $ref->basic_ref = $request->activityData['reference_parents'][$index][0]['basic_id'];
                        $ref->ref_db_id = 4;
                        $ref->ref_db_index =$section_activity->id;
                        $ref->tracking = $request->ip();
                        $ref->save();


                    // dd(['ref_id' => $ref->id]);

                    return $ref->id;
                }

                foreach ($request->activityData['activityTime'] as $index => $item) {

                    // dd($index, $item);

                    if (isset($update_activity_db_data[$index])) {

                        DB::table('section_activities')
                        ->where('id', '=', $update_activity_db_data[$index]->id)
                        ->update(['activityTime' => $item]);
                    }

                    // create missing activity entry
                    else {

                        // dd('activity not found. code under construction');


                        // create reference function


                        $section_activity = new SectionActivity();
                        $section_activity->basic_id = $request->basicData['id'];
                        $section_activity->activityTime = $request->activityData['activityTime'][$index];
                        $section_activity->tracking = $request->ip();
                        $section_activity->created_at = now();
                        $section_activity->updated_at = now();
                        $section_activity->save();

                        // dd($section_activity);

                        $section_activity->ref_id = reference($index, $section_activity, $request);
                        $section_activity->save();





                    }
                }

                // delete obsolete group

                // data from db
                $update_activity_db_data = DB::table('section_activities')
                ->where('basic_id', '=', $request->basicData['id'])
                ->get();

                // data from client
                $update_activity_db_tag_data = DB::table('tags')
                ->where('basic_id', '=', $request->basicData['id'])
                ->get()
                ->groupBy('section_table_id');

                // dd($request->activityData['activityTo'], $update_activity_db_data, $update_activity_db_tag_data);

                foreach ($update_activity_db_data as $client_activityto_data_index => $client_activityto_data_item) {
                    if (!isset($request->activityData['activityTo'][$client_activityto_data_index])) {
                        // dd($client_activityto_data_index);

                        // dd($client_activityto_data_item->ref_id);

                        $update_activity_db_data = DB::table('section_activities')
                        ->where('id', '=', $client_activityto_data_item->id)
                        ->update(['status' => 2]);

                        DB::table('refs')
                        ->where('id', '=', $client_activityto_data_item->ref_id)
                        ->update(['status' => 2]);

                        DB::table('tags')
                        ->where('section_table_id', '=', $client_activityto_data_item->id)
                        ->update(['status' => 2]);

                    }
                }
                // dd('negativ');

                // update tag and ref

                $section_id = 4;

                update_tag2($request, $section_id);
                update_reference($request, $section_id);

            }

            // else {
            //     $delete_basic_check = 1;
            // }
        };

        // update source data

        if (isset($request->sourceData)) {

            $section_id = 3;

            // empty entry: filelist = []; no file changes: filelist is missing
            if (isset($request->sourceData['filelist']) && $request->sourceData['filelist'] != []) {

                // dd($request->sourceData['filelist']);

                if ($request->sourceData['filelist'] != []) {

                    // dd('ok');
                    // dd($request->sourceData);

                    // update files
                    foreach ($request->sourceData['filelist'] as $files_index => $files_item) {

                        // dd($files_index, $files_item);
                        // dd($request->$db_name['filelist'][$files_index]);
                        // dd($request->sourceData['filelist'][$files_index]['filename']);

                        // link existing file
                        if (isset($request->sourceData['files'][$files_index])) {

                            DB::table('section_sources')
                            ->where('id', '=', $request->sourceData['files'][$files_index]['id'])
                            ->update(['path' => $request->sourceData['filelist'][$files_index]['filename']]);
                        }

                        // create new file
                        else {
                            // dd('file', $files_index);

                            // store file meta data
                            $sources = new SectionSource();
                            $sources->basic_id = $request->basicData['id'];
                            $sources->path = $request->sourceData['filelist'][$files_index]['file']->hashName();
                            $sources->extension = $request->sourceData['filelist'][$files_index]['type'];
                            $sources->size = $request->sourceData['filelist'][$files_index]['file']->getSize();
                            $sources->tracking = $request->ip();
                            $sources->save();

                            // store file data
                            Storage::disk('local')->put('public/images/inventory/', $request->sourceData['filelist'][$files_index]['file']);
                        }
                    }

                    // delete obsolete file data
                    $db_file_collection = DB::table('section_sources')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->get();

                    if (count($db_file_collection) > 0) {

                        // dd( $db_file_collection);

                        foreach($db_file_collection as $db_file_index => $db_file_item) {

                            // dd($db_file_index, $db_file_item);

                            if (!isset($request->sourceData['filelist'][$db_file_index])) {

                                DB::table('section_sources')
                                ->where('id', '=', $db_file_item->id)
                                ->update(['status' => 2]);
                            }
                        }
                    }
                }

                else {

                    // dd($request->basicData['id']);

                    // delete entry in section sources
                    DB::table('section_sources')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->update(['status' => 2]);

                }

                // update_tag($request, $section_id);
                // update_reference($request, $section_id);

                // $delete_basic_check = 1;
            }

            // else if (isset($request->sourceData['filelist']) && $request->sourceData['filelist'] == []) {
            //     $delete_basic_check = 1;
            // }

            // if (isset($request->sourceData['filelist']) && $request->sourceData['filelist'] == []) {
            update_tag2($request, $section_id);
            update_reference($request, $section_id);
            // }
            // else if (isset($request->sourceData)) {
                // dd($request->sourceData['files']);

            // }

        }

        $delete_check = 0;
        if (isset($request->sourceData['filelist']) && $request->sourceData['filelist'] == []) $delete_check = 1;
        if (isset($request->activityData['activityTo']) && $request->activityData['activityTo'][0] == '') $delete_check = 1;
        if (isset($request->statementData['statement']) && $request->statementData['statement']['statement'] == []) $delete_check = 1;

        // delete entry or update basic
        if ($delete_check == 1) {
            // dd('delete basic');
            // delete entry in section basics
            DB::table('section_basics')
            ->where('id', '=', $request->basicData['id'])
            ->update(['status' => 2]);

            DB::table('section_statements')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['status' => 2]);

            DB::table('section_activities')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['status' => 2]);

            DB::table('section_sources')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['status' => 2]);

            DB::table('refs')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['status' => 2]);

            DB::table('tags')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['status' => 2]);
        }

        else {
                // *****update basic data*****
                $update_basic_db_data = DB::table('section_basics')
                ->where('id', '=', $request->basicData['id'])
                ->update(['title' => $request->basicData['title'], 'ref_date' => $request->basicData['ref_date'],
                'medium' => $request->basicData['medium']]);
        }

        return Inertia::render('Create', []);
    }

    public function delete(Request $request) {

        DB::table('basics')->where('id', '=', $request->id)->delete();

        return redirect()->route('/')->with('message', 'Entry Successfully Deleted');
    }

    public function reference(Request $request) {

        // dd($request);

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

                // dd($i, $id);

                // add activity diagram color tag

                // find ActivityDiagramColor id
                $activitydiagramcolor_id = DB::table('tag_1s')
                ->where('content', '=', 'ActivityDiagramColor')
                ->get();

                // dd($activitydiagramcolor_id);

                if (count($activitydiagramcolor_id) > 0) {

                        // find tag_2s id
                        $tag_value_id = DB::table('tags')
                        ->where('status', '=', null)
                        ->where('basic_id', '=', $id->id)
                        ->where('tag_1_id', '=',  $activitydiagramcolor_id[0]->id)
                        ->get();

                        // dd($tag_value_id);

                        if (count($tag_value_id) > 0) {
                            // get ActivityDiagramColor color name
                            $tag_value_content = DB::table('tag_2s')
                            ->where('id', '=', $tag_value_id[0]->tag_2_id)
                            ->get();
                        }

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

    public function tag(Request $request) {

        // select all unique categories
        $tag_category_distinct_id = DB::table('tag_0s')
        ->select('id', 'content')
        ->get();

        // dd($tag_category_distinct_id);

        $tag_collection_category_context = [];
        $tag_context_distinct = [];

        foreach ($tag_category_distinct_id as $key => $tag_single_category) {

            // dd($key, $tag_single_category);

            array_push($tag_context_distinct, $tag_single_category->content);

            // step 2.1: collection db ids from a single category
            $tag_category_id = DB::table('tags')
            ->where('tag_0_id', '=', $tag_single_category->id)
            ->select('tag_1_id')
            ->distinct()
            ->get();

            // dd($tag_category_id);

            // step 2.2: check if preset exists and save data in array
            // $tag_preset_id_single = DB::table('tag_presets')
            // ->where('id', '=', $tag_single_id)
            // ->select('id', 'content')
            // ->get();

            // if () {

            // }

            // step 2.2: collection context ids from a single category



                // keep only unique tag context ids
                // $tag_context_distinct_unique = array_unique($tag_context_distinct);

                // dd($tag_context_distinct_unique);

                // step 2.3: collect all tag context contents from a single category
                $tag_context_id_single_collection = [];
                foreach ($tag_category_id as $tag_id => $tag_single_id) {

                    // dd($tag_id, $tag_single_id);

                    $tag_context_id_single = DB::table('tag_1s')
                    ->where('id', '=', $tag_single_id->tag_1_id)
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
        ->groupBy('tag_group');

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

                $tag_preset_category_name = DB::table('tag_0s')
                ->where('id', '=', $value2->tag_category)
                // ->where('status', '=', null)
                ->pluck('content');

                $tag_preset_context_name = DB::table('tag_1s')
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
                $tag_preset1 = new IndexTagPreset();
                $tag_preset1->preset_name = $request->preset_group['preset_name'];
                $tag_preset1->tracking = $request->ip();
                $tag_preset1->save();
            } else {
                // dd('preset name exists');
                $tag_preset1 = $presetNameCheck[0];
            }

            // dd($tag_preset->id);

            // dd($request);
            // dd($request->preset_group);

            // $group_id = DB::table('index_tag_presets')

            // $preset_id = ;

            // dd($request->preset_group['tag_category']);

            // check if preset already exists
            $tag_preset_duplicate_check = DB::table('tag_presets')
            ->where('tag_group', '=',  $tag_preset1->id)
            ->where('tag_category', '=',  $request->preset_group['tag_category'])
            ->where('tag_context', '=',  $request->preset_group['tag_context'])
            ->get();

            // dd($tag_preset1->id);

            // dd(count($tag_preset_duplicate_check) > 0);

            if (count($tag_preset_duplicate_check) == 0) {

                $tag_preset = new TagPreset();

                $tag_preset->tag_group = $tag_preset1->id;

                // dd($tag_preset);

                $tag_preset->tag_category = DB::table('tag_0s')
                ->where('content', '=', $request->preset_group['tag_category'])
                ->pluck('id')[0];

                $tag_preset->tag_context = DB::table('tag_1s')
                ->where('content', '=', $request->preset_group['tag_context'])
                ->pluck('id')[0];

                $tag_preset->tracking = $request->ip();
                $tag_preset->save();
            }
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
            ->where('tag_group', '=', $preset_name_id[0]->id)
            ->where('status', '=', null)
            ->get();

            $preset_group_deletion = $preset_group_total[$request->tagPresetGroupDeleteSubindex]->id;
            // dd($preset_group_deletion);

            DB::table('tag_presets')
            ->where('id', '=', $preset_group_deletion)
            ->where('status', '=', null)
            ->update(['status' => 2]);

            $preset_group_remaining = DB::table('tag_presets')
            ->where('tag_group', '=', $preset_name_id[0]->id)
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
            ->where('tag_group', '=', $preset_delete_id[0]->id)
            ->update(['status' => 2]);
        }

        // dd($preset_delete_id[0]->id);

        return Inertia::render('Create');
        // return redirect()->route('tag')->with('message', 'Entry Successfully Created');
    }

    public function edit(Request $request) {
        // dd($request);
        return Inertia::render('Create', ['edit' => $request]);
    }

    public function backup(Request $request) {

        // dd('ok');

        // Directory
        $directory = $_SERVER['DOCUMENT_ROOT'].'/../storage/app/backup';
        // Returns an array of files
        $files = scandir($directory);

        // Count the number of files and store them inside the variable..
        // Removing 2 because we do not count '.' and '..'.
        $num_files = count($files)-2;

        // dd($files[count($files)-1]);

        // filectime($files[count($files)-1]

        $backup_date = date("F d Y H:i:s", filectime($directory . '/' . $files[count($files)-1]));

        // dd($num_files, $files, date("F d Y H:i:s.", filectime($directory . '/' . $files[count($files)-1])));

        return Inertia::render('Backup', ['backup' => ['date' => $backup_date, 'count' => $num_files]]);
    }
}
