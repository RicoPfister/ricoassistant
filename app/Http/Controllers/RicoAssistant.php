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

    public function mainNav(Request $request) {

        // dd($request->page_id);

        $user = Auth::user();

        if (isset($user)) {
            // dd('ok');
            $db_basic_category_rawData = DB::table('section_basics')
            ->where('user_id', '=', $user->id)
            ->where('restriction', '<', 2)
            ->select('medium')
            ->get()
            ->groupBy('medium');
        }

        else {
            // dd('ok');
            $db_basic_category_rawData = DB::table('section_basics')
            ->where('restriction', '=', 0)
            ->select('medium')
            ->get()
            ->groupBy('medium');
        }

        // dd($db_basic_category_rawData);

        if (count($db_basic_category_rawData) > 0) {

            // create story tag collection
            if (isset($db_basic_category_rawData[2])) {
                $db_basic_category_collection['story'][0] = count($db_basic_category_rawData[2]);
                $db_basic_category_collection['story'][1] = [2];
            }

            // create fact tag collection
            if (isset($db_basic_category_rawData[5])) {
                $db_basic_category_collection['fact'][0] = count($db_basic_category_rawData[5]);
                $db_basic_category_collection['fact'][1] = [5];
            }

            // create admin tag collection
            if (isset($db_basic_category_rawData[1]) || isset($db_basic_category_rawData[4])) {
                $db_basic_category_collection['admin'][0] = 0;
                if (isset($db_basic_category_rawData[1])) $db_basic_category_collection['admin'][0] += count($db_basic_category_rawData[1]);
                if (isset($db_basic_category_rawData[4])) $db_basic_category_collection['admin'][0] += count($db_basic_category_rawData[4]);
                $db_basic_category_collection['admin'][1] = [3, 4];
            }

            // create exchange tag collection
            if (isset($db_basic_category_rawData[8])) {
                $db_basic_category_collection['exchange'][0] = count($db_basic_category_rawData[8]);
                $db_basic_category_collection['exchange'][1] = [8];
            }

            // create education tag collection
            if (isset($db_basic_category_rawData[3]) || isset($db_basic_category_rawData[6]) || isset($db_basic_category_rawData[7]) || isset($db_basic_category_rawData[9])) {
                $db_basic_category_collection['education'][0] = 0;
                if (isset($db_basic_category_rawData[3])) $db_basic_category_collection['education'][0] += count($db_basic_category_rawData[3]);
                if (isset($db_basic_category_rawData[6])) $db_basic_category_collection['education'][0] += count($db_basic_category_rawData[6]);
                if (isset($db_basic_category_rawData[7])) $db_basic_category_collection['education'][0] += count($db_basic_category_rawData[7]);
                if (isset($db_basic_category_rawData[9])) $db_basic_category_collection['education'][0] += count($db_basic_category_rawData[9]);
                $db_basic_category_collection['education'][1] = [6, 7, 9];
            }
        }

        else {
            $db_basic_category_collection = '';
        }

        // dd($db_basic_category_collection);

        return Inertia::render($request->page_id, ['fromController' => $db_basic_category_collection]);
    }

    // show filter (show default list view)
    public function filter(Request $request) {

        $user = Auth::user();

        $where = [];
        $whereIn = [];
        $where_between = [];
        $where_tag_1 = [];
        $where_tag_2 = [];
        $where_tag_3 = [];
        $where_tag_operator = '';

        $where_tag_section_collection2 = [];

        $query_check = 0;
        // $query_check_tag = 0;

        // $db_tag_0 = '';
        // $db_tag_1 = '';
        // $db_tag_2 = '';
        // dd($request);
        // dd($request['category']['story']);
        // dd(isset($user));

        if (isset($request->category)) {

            // if tag category is story create collection
            if ($request->category == 'story') {
                if (isset($user)) {
                    $listAuth = DB::table('section_basics')
                    ->where('user_id', '=', $user->id)
                    ->where('medium', '=', 2)
                    ->where('restriction', '<', 2)
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }

                else {
                    $listAuth = DB::table('section_basics')
                    ->where('restriction', '=', 0)
                    ->where('medium', '=', 2)
                    ->select('id', 'medium', 'title', 'ref_date')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }
            }

            // if tag category is fact create collection
            else if ($request->category == 'fact') {
                if (isset($user)) {
                    $listAuth = DB::table('section_basics')
                    ->where('user_id', '=', $user->id)
                    ->where('medium', '=', 5)
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->where('restriction', '<', 2)
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }

                else {
                    $listAuth = DB::table('section_basics')
                    ->where('restriction', '=', 0)
                    ->where('medium', '=', 5)
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }
            }

            // if tag category is exchange create collection
            else if ($request->category == 'exchange') {
                if (isset($user)) {
                    $listAuth = DB::table('section_basics')
                    ->where('user_id', '=', $user->id)
                    ->where('medium', '=', 8)
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->where('restriction', '<', 2)
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }

                else {
                    $listAuth = DB::table('section_basics')
                    ->where('restriction', '=', 0)
                    ->where('medium', '=', 8)
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }
            }

            // if tag category is admin create collection
            else if ($request->category == 'admin') {
                if (isset($user)) {
                    $listAuth = DB::table('section_basics')

                    ->where('user_id', '=', $user->id)
                    ->where('restriction', '<', 2)
                    ->where('medium', '=', 1)
                    ->orWhere(function($query) use ($user) {
                        $query
                            ->where('user_id', '=', $user->id)
                            ->where('restriction', '<', 2)
                            ->where('medium', '=', 4);
                    })
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }

                else {
                    $listAuth = DB::table('section_basics')
                    ->where('restriction', '=', 0)
                    ->where('medium', '=', 1)
                    ->orWhere(function($query) use ($user) {
                        $query
                        ->where('restriction', '=', 0)
                            ->where('medium', '=', 4);
                    })
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }
            }

            // if tag category is education create collection
            else if ($request->category == 'education') {
                if (isset($user)) {
                    // dd($request);
                    $listAuth = DB::table('section_basics')
                    ->where('user_id', '=', $user->id)
                    ->where('restriction', '<', 2)
                    ->where('medium', '=', 3)
                    ->orWhere(function($query) use ($user) {
                        $query
                            ->where('user_id', '=', $user->id)
                            ->where('restriction', '<', 2)
                            ->where('medium', '=', 6);
                    })
                    ->orWhere(function($query) use ($user) {
                        $query
                            ->where('user_id', '=', $user->id)
                            ->where('restriction', '<', 2)
                            ->where('medium', '=', 7);
                    })
                    ->orWhere(function($query) use ($user) {
                        $query
                            ->where('user_id', '=', $user->id)
                            ->where('restriction', '<', 2)
                            ->where('medium', '=', 9);
                    })
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }

                else {
                    // dd($request);
                    $listAuth = DB::table('section_basics')
                    ->where('restriction', '=', 0)
                    ->where('medium', '=', 3)
                    ->orWhere(function($query) use ($user) {
                        $query
                        ->where('restriction', '=', 0)
                        ->where('medium', '=', 6);
                    })
                    ->orWhere(function($query) use ($user) {
                        $query
                        ->where('restriction', '=', 0)
                        ->where('medium', '=', 7);
                    })
                    ->orWhere(function($query) use ($user) {
                        $query
                        ->where('restriction', '=', 0)
                        ->where('medium', '=', 9);
                    })
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->latest('updated_at')
                    ->paginate(20)->withQueryString();;
                }
            }
        }

        else if ($request->user == 'all_user_entries') {
            $listAuth = DB::table('section_basics')
            ->where('user_id', '=', $user->id)
            ->select('id', 'medium', 'title', 'ref_date', 'view_count')
            ->latest('updated_at')
            ->paginate(20)->withQueryString();;
        }

        // search with openssl_get_cert_locations
        // ************

        else if (isset($request->searchData)) {

            // dd($request->searchData);

            if (preg_match('/^[!@]|\s[!@]/', $request->searchData)) {

                // dd('ok0');

                $split_search_data = explode(' ', $request->searchData);

                // dd($split_search_data);

                // title

                function search_title($value, &$where) {

                    array_push($where, ['title', 'LIKE', '%' . $value . '%']);
                }

                // tag

                function search_tag_category($value, &$where_tag_1) {

                    // dd('ok');

                    array_push($where_tag_1, ['content', '=' , substr($value, 1)]);
                }

                function search_tag_category_context($tag_sections, &$where_tag_1, &$where_tag_2) {

                    array_push($where_tag_1, ['content', '=' , $tag_sections[0]]);
                    array_push($where_tag_2, ['content', '=' , $tag_sections[1]]);
                }

                function search_tag_category_context_value($tag_sections, &$where_tag_1, &$where_tag_2, &$where_tag_3, $where_tag_operator) {

                    array_push($where_tag_1, ['content', '=' , $tag_sections[0]]);
                    array_push($where_tag_2, ['content', '=' , $tag_sections[1]]);

                    if ($where_tag_operator == '+') array_push($where_tag_3, ['content', '>=' , $tag_sections[2]]);
                    if ($where_tag_operator == '-') array_push($where_tag_3, ['content', '<=' , $tag_sections[2]]);
                    else array_push($where_tag_3, ['content', '=' , $tag_sections[2]]);
                }

                // 1 date/today

                function search_year($value, &$where) {

                    array_push($where, ['ref_date', 'LIKE', '%' . substr($value, 1) . '%']);
                }

                function search_year_month($value, &$where) {

                    array_push($where, ['ref_date', 'LIKE', '%' . substr($value, 1) . '%']);
                }

                function search_year_month_day($value, &$where) {

                    array_push($where, ['ref_date', '=', substr($value, 1)]);
                }

                function search_today(&$where) {

                    array_push($where, ['ref_date', '=', date('Y-m-d')]);
                }

                // check search sections

                foreach ($split_search_data as $key => $value) {

                    // dd($value);

                    // title
                    if (preg_match('/^[^!@]{3,}/', $value)) {
                        search_title($value, $where);
                    }

                    // tag

                    // category only
                    else if (preg_match('/^@[^:]{1,}$/', $value)) {

                        // $query_check_tag = 1;
                        search_tag_category($value, $where_tag_1);
                    }

                    else if (preg_match('/^@[^:]*:[^:]*$/', $value)) {

                        // $query_check_tag = 2;
                        $tag_sections = explode(':', $value);
                        $tag_sections[0] = substr($tag_sections[0], 1);
                        // dd($tag_sections);
                        search_tag_category_context($tag_sections, $where_tag_1, $where_tag_2);
                    }

                    else if (preg_match('/^@[^:]*:[^:]*:[^:]*$/', $value)) {

                        // $query_check_tag = 3;
                        $tag_sections = explode(':', $value);
                        $tag_sections[0] = substr($tag_sections[0], 1);

                        // dd($tag_sections);

                        if (preg_match('/.*\+$/', $tag_sections[2])) {
                            $tag_sections[2] = substr($tag_sections[2], 0, -1);
                            $where_tag_operator = '+';
                        }

                        // dd($tag_sections, $where_tag_operator);
                        search_tag_category_context_value($tag_sections, $where_tag_1, $where_tag_2, $where_tag_3, $where_tag_operator);
                    }

                    // 1 date/today

                    else if (preg_match('/^!\d{3,}$/', $value)) {

                        search_year($value, $where);
                    }

                    else if (preg_match('/^!\d{4}-\d{2}$/', $value)) {

                        search_year_month($value, $where);
                    }

                    else if (preg_match('/^!\d{4}-\d{2}-\d{2}$/', $value)) {

                        search_year_month_day($value, $where);
                    }

                    else if (preg_match('/!today/', $value)) {

                        search_today($where);
                    }

                    // 2 dates

                    else if (preg_match('/!\d{4}_\d{4}/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1) . '-01-01';
                        $where_between[1] = $where_between[1] . '-12-31';
                        $query_check = 'between';
                    }

                    else if (preg_match('/!\d{4}_\d{4}-\d{2}-\d{2}/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1) . '-01-01';
                        $query_check = 'between';
                    }

                    else if (preg_match('/!\d{4}-\d{2}_\d{4}-\d{2}-\d{2}/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1) . '-01';
                        $query_check = 'between';
                    }

                    else if (preg_match('/!\d{4}-\d{2}-\d{2}_\d{4}-\d{2}-\d{2}/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1);
                        $query_check = 'between';
                    }

                    // 2 dates/today

                    // year-today
                    else if (preg_match('/!\d{4}_today/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1).'-01-01';
                        $where_between[1] = date('Y-m-d');
                        $query_check = 'between';
                    }

                    // year/mont-today
                    else if (preg_match('/!\d{4}-\d{2}_today/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1).'-01';
                        $where_between[1] = date('Y-m-d');
                        $query_check = 'between';
                    }

                    // year/month/day-today
                    else if (preg_match('/!\d{4}-\d{2}-\d{2}_today/', $value, $result_term)) {

                        $where_between = explode('_', $result_term[0]);
                        $where_between[0] = substr($where_between[0], 1);
                        $where_between[1] = date('Y-m-d');
                        $query_check = 'between';
                    }
                }
            }

            else {

                $where = [['title', 'LIKE', '%' . $request->searchData . '%']];
            }

            if (isset($where) || isset($where_between) && count($where) > 0 || count(isset($where_between) > 0)) {

                if (isset($user)) {
                    array_push($where, ['restriction', '<', '2'], ['user_id', '=', $user->id]);
                }

                else {
                    array_push($where, ['restriction', '=', '0']);
                }

                // dd($where, $where_between, $where_tag_1, $where_tag_2);

                if (count($where_tag_1) > 0) {

                    // dd('ok');

                    $where_tag_section_collection = [];

                    // search for tag section id
                    // *************************

                    $db_tag_0 = DB::table('tag_0s')
                    ->where($where_tag_1)
                    ->select('id')
                    ->get();

                    // dd($db_tag_0);

                    if (count($db_tag_0) > 0) array_push($where_tag_section_collection, ['tag_0_id', '=', $db_tag_0[0]->id]);

                    if (count($where_tag_2) > 0) {
                        $db_tag_1 = DB::table('tag_1s')
                        ->where($where_tag_2)
                        ->select('id')
                        ->get();

                        // dd($db_tag_1);

                        if (count($db_tag_1) > 0) array_push($where_tag_section_collection, ['tag_1_id', '=', $db_tag_1[0]->id]);
                        else $db_tag_0 = [];
                    }

                    if (count($where_tag_3) > 0) {
                        $db_tag_2 = DB::table('tag_2s')
                        ->where($where_tag_3)
                        ->pluck('id');

                        // dd($db_tag_2);

                        if (count($db_tag_2) > 0 && $where_tag_operator == '+') {
                            array_push($where_tag_section_collection2, $db_tag_2);
                            // dd($where_tag_section_collection2);
                        }
                        else if (count($db_tag_2) > 0) array_push($where_tag_section_collection, ['tag_2_id', '=', $db_tag_2[0]]);
                        else $db_tag_0 = [];
                    }

                    // dd($where_tag_section_collection, $where_tag_section_collection2);
                    // dd($db_tag_0, $db_tag_1, $db_tag_2, $where_tag_section_collection2);

                    // get basic id out of tag ids

                    if (count($db_tag_0) > 0) {

                        if (count($where_tag_section_collection2) > 0) {

                            $db_basic_data = DB::table('tags')
                            ->where($where_tag_section_collection)
                            ->whereIn('tag_2_id', $where_tag_section_collection2[0])
                            ->get()
                            ->pluck('basic_id');
                        }

                        else {
                            // dd('ok');

                            $db_basic_data = DB::table('tags')
                            ->where($where_tag_section_collection)
                            ->get()
                            ->pluck('basic_id');
                        }

                        // dd($db_basic_data);

                        if (count($db_basic_data) > 0) {
                            array_push($whereIn, $db_basic_data);
                        }

                        else {
                            $query_check = 'tag_category_not_found';
                        }
                    }

                    else {
                        $query_check = 'tag_category_not_found';
                    }
                }

                // dd($where, $whereIn, $where_between, $query_check);

                if (count($whereIn) == 0) {
                    $db_basic_data = DB::table('section_basics')
                    ->where($where)
                    // ->whereIn('id', $whereIn[0])
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->orderByDesc('title')
                    ->paginate(20)->withQueryString();
                }

                else if ($query_check == 0) {
                    $db_basic_data = DB::table('section_basics')
                    // ->where($where)
                    ->whereIn('id', $whereIn[0])
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->orderByDesc('title')
                    ->paginate(20)->withQueryString();
                }

                else if ($query_check == 'between') {
                    $db_basic_data = DB::table('section_basics')
                    ->where($where)
                    ->whereBetween('ref_date', [$where_between[0], $where_between[1]])
                    ->select('id', 'medium', 'title', 'ref_date', 'view_count')
                    ->orderByDesc('title')
                    ->paginate(20)->withQueryString();
                }

                // dd($db_basic_data);

                // check if entry contains searched tags
                // if ($db_tag_0 != '') {

                // }

                if (isset($db_basic_data) && count($db_basic_data) > 0) {
                    $listAuth = $db_basic_data;
                }

                else $listAuth = ['result' => 0, 'search_string' => $request->searchData];
            }

            else $listAuth = ['result' => 0, 'search_string' => $request->searchData];

        }

        else $listAuth = '0_result';

        return Inertia::render('TabManager/TabManager', ['filter' => $listAuth, 'search_term' => $request->searchData]);
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
            ->where('restriction', '<', 2)
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
            ->where('restriction', '<', 2)
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
                        ->where('restriction', '<', 2)
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
                            ->where('restriction', '<', 2)
                            ->get();

                            // dd($_tag_color_id);

                            if (isset($_tag_color_id[0]->tag_2_id)) {

                                $_tag_color_name = DB::table('tag_2s')
                                ->where('id', '=', $_tag_color_id[0]->tag_2_id)
                                // ->where('restriction', '<', 2)
                                ->get();

                                // dd($_tag_color_name);

                                $detail['reference_parents'][$key][$i]->color = $_tag_color_name[0]->content;
                            }

                        // dd($detail);
                        $i++;

                        // dd($basic_ref);

                        $next_value = DB::table('refs')
                        ->where('basic_id', '=', $value->basic_ref)
                        ->where('restriction', '<', 2)
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

        // dd($detail['basicData']['user_id']);

        $basic_medium_data = DB::table('index_mediums')
        ->get();

        $detail['basicData']['medium_name'] = $basic_medium_data[$detail['basicData']->medium-1]->medium_name;
        $detail['basicData']['user_name'] = DB::table('users')
        ->find($detail['basicData']['user_id'])
        ->name;
        // ->pluck('name');

        // dd($detail);

        // increment view count
        DB::table('section_basics')
        ->where('id', '=', $request->basic_id)
        ->increment('view_count');

        // create statement collection
        // ++++++++++++++++++++++++++++++++++++

        $detail_statement = DB::table('section_statements')
        ->where('restriction', '<', 2)
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
        ->where('restriction', '<', 2)
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
        ->where('restriction', '<', 2)
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

        //! check if a Document is available (duplicated code. See function 'Document')
        // ********************

        $category_id = DB::table('tag_0s')
        ->where('content', '=', 'Chapter')
        ->get();

        $value_id = DB::table('tag_2s')
        ->where('content', '=', $request->basic_id)
        ->get();

        // dd($category_id, $value_id);

        $entry_collection = [];

        if (count($category_id) > 0 && count($value_id) > 0) {
            $entry_collection = DB::table('tags')
            ->where('restriction', '<', 2)
            ->where('tag_0_id', '=', $category_id[0]->id)
            ->where('tag_2_id', '=',  $value_id[0]->id)
            ->get();
        }

        // dd($entry_collection);

        if (count($entry_collection) > 0) $detail['basicData']['document'] = 1;
        else $detail['basicData']['document'] = 0;

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

        // validation is a duplicate from 'function update'
        // title uniqueness is not tested again

        $validation_collection = [
            'basicData.ref_date' => 'required|filled',
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

        if (array_search(5, $request->componentCollection)) $validation_collection['activityData.reference_parents'] = 'required';
        if (array_search(5, $request->componentCollection)) $validation_collection['activityData.activityTo'] = 'required';

        if (array_search(5, $request->componentCollection)) {

            if (isset($request->activityData['tag'])) {
                foreach ($request->activityData['tag'] as $key => $value) {
                    foreach ($value as $key2 => $value2) {
                        $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.0'] = 'required|filled';
                        $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.1'] = 'required|filled';
                        $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.2'] = 'required|filled';
                    }
                }
            }
        }

        if (isset($request->activityData['activityTo'])) {
            for ($a = 0; $a < count($request->activityData['activityTo']); $a++) {
                $validation_collection['activityData.reference_parents.'.$a] = 'required|filled';
            }

            $validation_collection['activityData.activityTo.*'] = 'filled|between:0,2400';
            $validation_collection['activityData.activityTo.' . count($request->activityData['activityTo'])-1] = 'in:2400';
        }

         $validated = $request->validate($validation_collection);


        // create tag function
        function tagData($request, $index, $basics, $id2, $db_section_id, $db_name) {

            $user = Auth::user();

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
                            $tag_group_section_name[$value_index]->user_id = $user->id;
                            $tag_group_section_name[$value_index]->content = $value_item;
                            $tag_group_section_name[$value_index]->tracking = $request->ip();
                            $tag_group_section_name[$value_index]->save();
                        }
                    }

                    $tag_group = new Tag();
                    $tag_group->user_id = $user->id;
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

        if ($request->basicData['public'] == true) {
            // dd('ok');
            $basics->restriction =  0;
            $basics->save();
        }

        else {
            // dd('ok');
            $basics->restriction =  1;
            $basics->save();
        }

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

        if (!isset($request->delete)) {

            // validation is a duplicate from store

            $validation_collection = [
                'basicData.ref_date' => 'required|filled',
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

            if (array_search(6, $request->componentCollection) && isset($request->sourceData['delete'])) $validation_collection['sourceData.filelist'] = 'required';
            if (array_search(6, $request->componentCollection)) $validation_collection['sourceData.filelist.*.type'] = 'filled';

            // dd($request->sourceData['tag']);

            if (isset($request->sourceData['tag'])) {
                foreach ($request->sourceData['tag'] as $key => $value) {

                    // dd($value != '');

                    if ($value != '') {
                        foreach ($value as $key2 => $value2) {
                            $validation_collection['sourceData.tag.' . $key . '.' . $key2 . '.0'] = 'required|filled';
                            $validation_collection['sourceData.tag.' . $key . '.' . $key2 . '.1'] = 'required|filled';
                            $validation_collection['sourceData.tag.' . $key . '.' . $key2 . '.2'] = 'required|filled';
                        }
                    }
                }
            }

            if (array_search(5, $request->componentCollection)) $validation_collection['activityData.reference_parents'] = 'required';
            if (array_search(5, $request->componentCollection)) $validation_collection['activityData.activityTo'] = 'required';

            if (array_search(5, $request->componentCollection)) {

                if (isset($request->activityData['tag'])) {
                    foreach ($request->activityData['tag'] as $key => $value) {
                        foreach ($value as $key2 => $value2) {
                            $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.0'] = 'required|filled';
                            $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.1'] = 'required|filled';
                            $validation_collection['activityData.tag.' . $key . '.' . $key2 . '.2'] = 'required|filled';
                        }
                    }
                }
            }

            if (isset($request->activityData['activityTo'])) {
                for ($a = 0; $a < count($request->activityData['activityTo']); $a++) {
                    $validation_collection['activityData.reference_parents.'.$a] = 'required|filled';
                }

                $validation_collection['activityData.activityTo.*'] = 'filled|between:0,2400';
                $validation_collection['activityData.activityTo.' . count($request->activityData['activityTo'])-1] = 'in:2400';
            }

            $validated = $request->validate($validation_collection);
        }

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

                // get form section data
                $rererence_db_section_data = DB::table($tag_section)
                ->where('restriction', '<', 2)
                ->where('basic_id', '=', $request->basicData['id'])
                // ->wehre('ref_db_index', '=', )
                // ->limit(1)
                ->get();

                // dd($rererence_db_section_data);

                $rererence_db_data = DB::table('refs')
                ->where('restriction', '<', 2)
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
                        ->update(['restriction' => 2]);
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
                    ->update(['restriction' => 2]);
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

            $user = Auth::user();

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
            $tag->user_id = $user->id;
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

            $user = Auth::user();

            //  dd($item);

            // check if client tag group exists if not set the group to 2 (delete)
            if (isset($item)) {

                // get client tag section tag groups
                foreach($item as $index2 => $item2) {

                    // get client tag section group section
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
                            $tag_category->user_id = $user->id;
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

                    // if tag group is missing create it
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
                        // ->where('restriction', '<', 2)
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
                    ->update(['restriction' => 2]);
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

            // get db tag section data
            $db_table_section_data = DB::table($tag_section)
            ->where('basic_id', '=', $request->basicData['id'])
            ->get()
            ->groupBy('id');

            // dd($db_table_section_data);

            $update_tag_db_data_indexed =  $db_table_section_data->values();
            // dd($update_tag_db_data_indexed);

            // get db tag section groups
            $update_tag_db_data = DB::table('tags')
            ->where('basic_id', '=', $request->basicData['id'])
            ->where('section', '=', $section_id)
            ->where('restriction', '<', 2)
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
                    // set restriction of all empty client tag groups to 2 (delete)
                    foreach($update_tag_db_group as $db_tag_group_index => $db_tag_group_item) {

                        // dd($db_tag_group_index, $db_tag_group_item);

                        // delete tag if there is no tag client update found
                        foreach($db_tag_group_item[0] as $db_tag_group_section_index => $db_tag_group_section_item) {

                            // dd('ok');

                            // dd($db_tag_group_section_index, $db_tag_group_section_item);
                            // dd($request->$db_name['tag'][1][3]);

                            // if client tag equivalence not exists
                            if (!isset($request->$db_name['tag'][$db_tag_group_index][$db_tag_group_section_index])) {

                                // dd($db_tag_group_index, $db_tag_group_section_index);

                                // dd($update_tag_db_group[$db_tag_group_index][0][$db_tag_group_section_index]);

                                DB::table('tags')
                                ->where('id', '=', $update_tag_db_group[$db_tag_group_index][0][$db_tag_group_section_index]->id)
                                ->update(['restriction' => 2]);
                            };
                        }
                    }
                }
            }

            // step 2.1: delete groups with no content
            else {

                // delete all entry tags (set to restriction 2)
                if (count($update_tag_db_data) > 0) {
                    DB::table('tags')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->update(['restriction' => 2]);
                }
            }
        }

        function delete_entry() {

            // tag: set restriction 2 (deleted)
            // get tag table id by basic id
            $update_tag_db_data = DB::table('tags')
            ->where('basic_id', '=', $request->basicData['id'])
            ->where('restriction', '<', 2)
            ->get()
            ->groupBy('tag_id')
            ->values();

            foreach ($update_tag_db_data as $i => $id) {

                if (!isset($request->statementData['tag'][0][$i])) {
                    $tag_collection_basic_id = DB::table('tags')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->where('tag_id', '=', $update_tag_db_data[$i][0]->tag_id)
                    ->update(['restriction' => 2]);
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
                        ->update(['restriction' => 2]);

                        DB::table('refs')
                        ->where('id', '=', $client_activityto_data_item->ref_id)
                        ->update(['restriction' => 2]);

                        DB::table('tags')
                        ->where('section_table_id', '=', $client_activityto_data_item->id)
                        ->update(['restriction' => 2]);

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

                    // get all related files
                    $files_collection = DB::table('section_sources')
                    ->where('restriction', '<', 2)
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->get();

                    // dd('ok');
                    // dd($files_collection);
                    // dd($request->sourceData);
                    // dd($request->sourceData['filelist']);

                    // update files

                    // dd($request->sourceData['delete']);

                    if (isset($request->sourceData['delete']) && $request->sourceData['delete'] == 'entries') {
                        foreach ($files_collection as $files_index => $files_item) {

                            // dd($files_collection[$files_index]->path);

                            // delete old file
                            DB::table('section_sources')
                            // ->where('basic_id', '=', $request->basicData['id'])
                            ->where('id', '=', $files_collection[$files_index]->id)
                            ->update(['restriction' => 2]);

                            Storage::disk('local')->delete('public/images/inventory/' . $files_collection[$files_index]->path);

                            // dd($files_index, $files_item);
                            // dd($request->$db_name['filelist'][$files_index]);
                            // dd($request->sourceData['filelist'][$files_index]['filename']);

                            // link existing file
                            // if (isset($request->sourceData['files'][$files_index])) {

                            //     DB::table('section_sources')
                            //     ->where('id', '=', $request->sourceData['files'][$files_index]['id'])
                            //     ->update(['path' => $request->sourceData['filelist'][$files_index]['filename']]);
                            // }

                            // create new file

                                // dd('file', $files_index);

                                //! !! every file will be stored again in the given order !!
                        }
                    }

                    // dd($request->sourceData['filelist']);

                    foreach ($request->sourceData['filelist'] as $files_index => $files_item) {

                        if (isset($request->sourceData['filelist'][$files_index]['file'])) {

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
                    ->where('restriction', '<', '2')
                    ->get();

                    if (count($db_file_collection) > 0) {

                        // dd( $db_file_collection);

                        foreach($db_file_collection as $db_file_index => $db_file_item) {

                            // dd($db_file_index, $db_file_item);

                            if (!isset($request->sourceData['filelist'][$db_file_index])) {

                                // dd('ok');

                                DB::table('section_sources')
                                ->where('id', '=', $db_file_item->id)
                                ->update(['restriction' => 2]);
                            }
                        }
                    }
                }

                else {

                    // dd($request->basicData['id']);

                    // delete entry in section sources
                    DB::table('section_sources')
                    ->where('basic_id', '=', $request->basicData['id'])
                    ->update(['restriction' => 2]);

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

        $delete_basic_tag_ref = 0;

        function delete_basic_tag_ref() {

            DB::table('section_basics')
            ->where('id', '=', $request->basicData['id'])
            ->update(['restriction' => 2]);

            DB::table('refs')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['restriction' => 2]);

            DB::table('tags')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['restriction' => 2]);

        }

        if (isset($request->sourceData['filelist']) && $request->sourceData['filelist'] == []) {

            DB::table('section_statements')
            ->where('basic_id', '=', $request->basicData['id'])
            ->update(['restriction' => 2]);

            if ($delete_basic_tag_ref == 0) {
                $delete_basic_tag_ref = 1;
                delete_basic_tag_ref();
            }
        };

        if (isset($request->activityData['activityTo']) && $request->activityData['activityTo'][0] == '') {

            DB::table('section_basics')
            ->where('id', '=', $request->basicData['id'])
            ->update(['restriction' => 2]);

            if ($delete_basic_tag_ref == 0) {
                $delete_basic_tag_ref = 1;
                delete_basic_tag_ref();
            }
        }
        if (isset($request->statementData['statement']) && $request->statementData['statement']['statement'] == []) {

            DB::table('section_basics')
            ->where('id', '=', $request->basicData['id'])
            ->update(['restriction' => 2]);

            if ($delete_basic_tag_ref == 0) {
                $delete_basic_tag_ref = 1;
                delete_basic_tag_ref();
            }
        }



        else {
                // *****update basic data*****
                $update_basic_db_data = DB::table('section_basics')
                ->where('id', '=', $request->basicData['id'])
                ->update(['title' => $request->basicData['title'], 'ref_date' => $request->basicData['ref_date'],
                'medium' => $request->basicData['medium']]);
        }

        return Inertia::render('Home', []);
    }

    public function delete(Request $request) {

        // dd($request->id);

        // !! only sets basic restriction to 2 !!
        // ****************************************

        DB::table('section_basics')
        ->where('id', '=', $request->id)
        ->update(['restriction' => 2]);

        // DB::table('basics')->where('id', '=', $request->id)->delete();
        // return redirect()->route('/')->with('message', 'Entry Successfully Deleted');

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
            ->where('restriction', '<', 2)
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
                        ->where('restriction', '<', 2)
                        ->where('user_id', '=', $user->id)
                        ->where('id', '=', $parent_checker_next_value)
                        ->first();

                        // dd($parent_basic);
                        // dd($parent_checker_next_value);

                        // check next ref db entry
                        $parent_ref = DB::table('refs')
                        ->where('restriction', '<', 2)
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
                ->where('restriction', '<', 2)
                ->where('user_id', '=', $user->id)
                ->orderByDesc('updated_at')
                ->limit(10)
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
                        ->where('restriction', '<', 2)
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
                ->where('restriction', '<', 2)
                ->where('user_id', '=', $user->id)
                ->where('title', 'LIKE', '%'.$request->reference.'%')
                ->orderBy('updated_at', 'desc')
                ->limit(10)
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
                        $activitydiagramcolor_id = DB::table('tag_1s')
                        ->where('content', '=', 'ActivityDiagramColor')
                        ->get();

                        // dd($id->id, $activitydiagramcolor_id);

                        if (count($activitydiagramcolor_id) > 0) {
                        // find ActivityDiagramColor id
                        $tag_id = DB::table('tags')
                        ->where('basic_id', '=', $id->id)
                        ->where('tag_1_id', '=', $activitydiagramcolor_id[0]->id)
                        ->get();

                        // dd($tag_id);

                            // $tag_value_id = DB::table('tags')
                            // ->where('tag_id', '=', $tag_id[0]->tag_id)
                            // ->where('tag_table', '=', 3)
                            // ->get();

                            // dd($tag_value_id);

                            if (count($tag_id)) {

                                $tag_value_content = DB::table('tag_2s')
                                ->where('id', '=', $tag_id[0]->tag_2_id)
                                ->get();
                            }

                            else $tag_value_content = '';

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

                $referencesResultCheckExact = DB::table('section_basics')
                ->where('restriction', '<', 2)
                ->where('user_id', '=', $user->id)
                ->where('title', '=', $request->reference)
                ->get();

                // dd(array_search($referencesResultCheckExact[0]->title, array_column($result['referencesResult'],  'title')), $referencesResultCheckExact[0]->title, array_column($result['referencesResult'], 'title'));

                if (count($referencesResultCheckExact) > 0) {

                    $array_shifting = array_search($referencesResultCheckExact[0]->title, array_column($result['referencesResult'], 'title'));

                    if ($array_shifting !== false) {

                        // dd($array_shifting);
                        array_splice($result['referencesResult'], $array_shifting, $array_shifting);
                        array_unshift($result['referencesResult'], $referencesResultCheckExact[0]);
                        array_pop($result['referencesResult']);
                    }

                    else {
                        array_unshift($result['referencesResult'], $referencesResultCheckExact[0]);
                        array_pop($result['referencesResult']);
                    }
                }
            }

            else {
                $result['misc']['row'] = 0;
            }
        }

        $result['misc']['parentId'] = $request->parentId;

        // dd($result);

        // $request->session()->put('fromController', $result);

        // dd($result);

        // return redirect()->back()->with([
        //     'testabc' => 'foobar',
        // ]);

        // return back()->with('success','Item created successfully!');
        // with(['error => 'message here'])
        // return Inertia::render('Create', ['fromController' => $result]);
        // return Inertia::render('Create')->with(['myVariable' => 'message here']);
        return to_route('test123')->with('fromController', $result);
        // return redirect()->back()->with('fromController', 999);
    }

    public function titlecheck(Request $request) {

        // dd($request);

        // user auth
        $user = Auth::user();
        $result = [];

        // create instant search results
        $basicTitleResultCheck = DB::table('section_basics')
            ->where('user_id', '=', $user->id)
            ->where('restriction', '<', 2)
            ->where('title', '=', $request->basicTitle)
            ->get();

        $basic_medium_data = DB::table('index_mediums')
        ->get();

        // dd($basic_medium_data);

        // dd($basicTitleResultCheck);

            // isolate collection title and duplicated dates
            if (count($basicTitleResultCheck)) {

                foreach ($basicTitleResultCheck as $i => $id) {
                    if ($id->ref_date == $request->basicRefDate && $id->medium == $request->basicMedium && $id->title == $request->basicTitle && $id->id != $request->id) {
                        // dd('ok');
                        $basicResult['basicResult'][0]['title'] = $id->title;
                        $basicResult['basicResult'][0]['refDate'] = $id->ref_date;
                        $basicResult['basicResult'][0]['medium'] = $basic_medium_data[$id->medium-1]->medium_name;
                        $basicResult['basicResult'][0]['warning'] = '2';
                    }
                }
            }

            if (!isset($basicResult)) $basicResult['basicResult'][0]['title'] = '';

        // dd($basicResult);

        // request()->fullUrlWithQuery(['token ' => null]);
        // url('foo', [333, 'bar', 444, 'show']);

        // return Inertia::render('Create', ['fromController' => ['misc' => ['parentId' => $request->parentId], $basicResult]]);
        // return to_route('test123', ['fromController' => ['misc' => ['parentId' => $request->parentId], $basicResult]]);
        return to_route('test123')->with('fromController', ['misc' => ['parentId' => $request->parentId], $basicResult]);;
    }

    public function tag(Request $request) {

        $user = Auth::user();

        $tags_collection_all = DB::table('tags')
        ->where('user_id', '=', $user->id)
        ->pluck('tag_0_id');

        // dd($tags_collection_all);

        // foreach ($tags_collection_all as $key2 => $value2) {

        // }

        // select all unique categories
        $tag_category_distinct_id = DB::table('tag_0s')
        ->whereIn('id', $tags_collection_all)
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
            ->where('user_id', '=', $user->id)
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
        ->where('restriction', '<', 2)
        ->get()
        ->groupBy('group_id');

        // dd($tag_preset_group);

        $tag_preset_context = [];
        $tag_preset_name;
        $presetId = 0;

        foreach ($tag_preset_group as $key => $value) {

            // dd($key, $value);

            $tag_preset_name = DB::table('index_tag_presets')
            ->where('user_id', '=', $user->id)
            ->where('id', '=', $key)
            ->where('restriction', '<', 2)
            ->pluck('preset_name');

            // dd($tag_preset_name);

            if (count($tag_preset_name) > 0) {

                // dd($key, $value, $tag_preset_name);

                $tag_preset_context[$presetId] = [$tag_preset_name[0]];

                // $tag_preset_context[$presetId] = [];

                foreach ($value as $key2 => $value2) {
                    // dd($key2, $value2);

                    $tag_preset_category_name = DB::table('tag_0s')
                    ->where('id', '=', $value2->tag_category)
                    // ->where('restriction', '<', 2)
                    ->pluck('content');

                    $tag_preset_context_name = DB::table('tag_1s')
                    ->where('id', '=', $value2->tag_context)
                    // ->where('restriction', '<', 2)
                    ->pluck('content');

                    // dd($tag_preset_category_name[0]);

                    // dd($tag_preset_context_name);

                    $tag_preset_context[$presetId][1][$key2][0] = $tag_preset_category_name[0];
                    $tag_preset_context[$presetId][1][$key2][1] = $tag_preset_context_name[0];
                    // dd($tag_preset_name);
                }
                $presetId++;
            }
                // dd($tag_preset_context);

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

        // return Inertia::render('Create', ['fromController' => $tagCollectionSelection]);
        return to_route('test123')->with('fromController', $tagCollectionSelection);
    }

    public function preset_store(Request $request) {

        $user = Auth::user();

        // dd($request);
        // dd($request->preset_group['preset_name']);

        // if (isset($request->preset_group)) {
        //     // dd($request);

        // }

        // preset name duplicate check
        if (isset($request->preset_group)) {

            // dd($request->preset_group['preset_name']);

            $presetNameCheck = DB::table('index_tag_presets')
            ->where('user_id', '=', $user->id)
            ->where('preset_name', '=', $request->preset_group['preset_name'])
            ->where('restriction', '<', 2)
            ->get();

            // dd($presetNameCheck);
            // dd(count($presetNameCheck));

            if (count($presetNameCheck) == 0) {
                // dd('ok');
                $tag_preset1 = new IndexTagPreset();
                $tag_preset1->user_id = $user->id;
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
            ->where('group_id', '=',  $tag_preset1->id)
            ->where('tag_category', '=',  $request->preset_group['tag_category'])
            ->where('tag_context', '=',  $request->preset_group['tag_context'])
            ->get();

            // dd($tag_preset1->id);

            // dd(count($tag_preset_duplicate_check) > 0);

            if (count($tag_preset_duplicate_check) == 0) {

                $tag_preset = new TagPreset();

                $tag_preset->group_id = $tag_preset1->id;

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
            ->where('restriction', '<', 2)
            // ->update(['restriction' => 2]);
            ->get();

            // dd($preset_name_id[0]->id);

            $preset_group_total = DB::table('tag_presets')
            ->where('group_id', '=', $preset_name_id[0]->id)
            ->where('restriction', '<', 2)
            ->get();

            // dd($preset_group_total);

            $preset_group_deletion = $preset_group_total[$request->tagPresetGroupDeleteSubindex]->id;
            // dd($preset_group_deletion);

            DB::table('tag_presets')
            ->where('id', '=', $preset_group_deletion)
            ->where('restriction', '<', 2)
            ->update(['restriction' => 2]);

            $preset_group_remaining = DB::table('tag_presets')
            ->where('group_id', '=', $preset_name_id[0]->id)
            ->where('restriction', '<', 2)
            ->get();

            // dd($preset_group_remaining);

            if(count($preset_group_remaining) <= 0) {
                DB::table('index_tag_presets')
                ->where('preset_name', '=', $request->tagPresetGroupDeleteIndex)
                ->where('restriction', '<', 2)
                // ->update(['restriction' => 2]);
                ->update(['restriction' => 2]);
            }

            // dd($preset_group_remaining);

            // dd($preset_group_total);

        }

        // dd($request->tagPresetDelete);

        // set restriction to 2 (delete) for preset name
        if (isset($request->tagPresetDelete)) {

            // $preset_delete_id = DB::table('index_tag_presets')
            // ->where('preset_name', '=', $request->tagPresetDelete)
            // ->get();

            // dd($preset_delete_id);

            DB::table('index_tag_presets')
            ->where('preset_name', '=', $request->tagPresetDelete)
            ->update(['restriction' => 2]);
            // ->get();

            // dd($preset_delete_id);
            // $preset_delete_id->update(['restriction' => 22]);

            // set restriction to 2 (delete) for preset name
            // DB::table('tag_presets')
            // ->where('group_id', '=', $preset_delete_id[0]->id)
            // ->update(['restriction' => 2]);
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

    public function statistic(Request $request) {

        // dd('ok');

        $user = Auth::user();

        $tag_db_rawdata = DB::table('tags')
        ->get();

        // dd($tag_db_rawdata);

        $tag_db_tag_collection = collect([]);

        foreach ($tag_db_rawdata as $index => $item) {

            $tag_db_category_name = DB::table('tag_0s')
            ->where('id', '=', $item->tag_0_id)
            ->get();

            $tag_db_context_name = DB::table('tag_1s')
            ->where('id', '=', $item->tag_1_id)
            ->get();

            // dd($tag_db_category_name);

            $tag_db_tag_collection->push(['category'=> $tag_db_category_name[0]->content, 'context'=> $tag_db_context_name[0]->content]);
        }

        // dd($tag_db_category);

        // $tag_db_rawdata->only('tag_0_id');

        $grouped = $tag_db_tag_collection->groupBy('category');

        $grouped_tags = collect([]);

        foreach ($grouped as $key => $value) {
            // dd($value);
            $grouped_tags[$key] = $value->groupBy('context');
        }
        // $grouped->all();

        // dd($grouped_tags);

        $group_tags_count = collect([]);

        foreach ($grouped_tags as $key => $value) {

            // dd($value);

            foreach ($value as $key2 => $value2) {

                // dd($value2);

                $group_tags_count->push(['count' => $value2->count(), 'category' => $value2[0]['category'], 'context' => $value2[0]['context']]);
            }
        }

        $group_tags_count_sorted = $group_tags_count->sortByDesc('count')->values();

        // dd($group_tags_count_sorted);

        // dd($group_tags_count->sortByDesc('count'));

        $user_entries_all = DB::table('section_basics')
        ->where('user_id', '=', $user->id)
        ->get()
        ->count();

        $user_entries_category = [];

        for ($a = 1; $a < 10; $a++) {

            $user_entries_category[$a][0] = DB::table('index_mediums')
            ->where('id', '=', $a)
            ->pluck('medium_name')[0];

            $user_entries_category[$a][1] = DB::table('section_basics')
            ->where('user_id', '=', $user->id)
            ->where('medium', '=', $a)
            ->get()
            ->count();
        }

        // dd($user_entries_category);

        return Inertia::render('Dashboard', ['statistic' => ['tags' => $group_tags_count_sorted, 'user_entries' => ['all' => $user_entries_all, 'category' => $user_entries_category]]]);
    }

    public function tag_value_validation(Request $request) {

        // dd($request);

        $user = Auth::user();

        $tag_category_id = DB::table('tag_0s')
        ->where('user_id', '=', $user->id)
        ->where('content', '=', $request->value[0])
        ->pluck('id');

        $tag_context_id = DB::table('tag_1s')
        ->where('user_id', '=', $user->id)
        ->where('content', '=', $request->value[1])
        ->pluck('id');

        // dd($tag_category_id, $tag_context_id);

        if (count($tag_category_id) > 0 && count($tag_context_id) > 0) {

            $tag_value_id = DB::table('tags')
            ->where('tag_0_id', '=', $tag_category_id[0])
            ->where('tag_1_id', '=', $tag_context_id[0])
            ->pluck('tag_2_id');

            // dd($tag_value_id);

            $tag_value_collection = DB::table('tag_2s')
            ->where('user_id', '=', $user->id)
            ->whereIn('id', $tag_value_id)
            ->where('content', 'LIKE', '%' . $request->value[2] . '%')
            ->orderBy('updated_at', 'desc')
            ->take(1)
            ->pluck('content');

        }

        else  $tag_value_collection = '';

        // dd($tag_value_collection);

        // return Inertia::render('Create', ['fromController' => ['tag_value_collection' => $tag_value_collection, 'parentId' => $request->parentId, 'parentIndex' => $request->parentIndex]]);
        return to_route('test123')->with(['fromController_validation' => ['tag_value_collection' => $tag_value_collection, 'parentId' => $request->parentId, 'parentIndex' => $request->parentIndex]]);
    }

    public function document(Request $request) {

        // dd($request);

        $value_detail_content_collection = [];
        $heading_collection = [];

        function document_date_check($request, $chapter_id, $entry_id, $detail_date_id, &$value_detail_content_collection, &$heading_collection) {

            $user = Auth::user();

            // dd($request, $chapter_id, $entry_id, $detail_date_id, $value_detail_content_collection);

            $date_correlation = DB::table('tags')
            ->where('user_id', '=', $user->id)
            ->where('restriction', '<', 2)
            ->where('tag_0_id', '=', $chapter_id[0])
            ->where('tag_2_id', '=', $entry_id[0])
            ->where('tag_3_id', '=', $detail_date_id[0])
            ->select('basic_id')
            ->get()
            ->toArray();

            // dd($date_correlation);

            if (count($date_correlation) > 0) document_date_found($request, $value_detail_content_collection, $heading_collection);
            else document_custom_check($chapter_id, $entry_id, $value_detail_content_collection, $heading_collection);
        }

        function document_date_found($request, &$value_detail_content_collection, &$heading_collection) {

            // dd($request);

            $user = Auth::user();

            // dd($request, $value_detail_content_collection);

            $title_collection = DB::table('section_basics')
            ->where('user_id', '=', $user->id)
            ->where('restriction', '<', 2)
            ->where('title', 'LIKE', $request->title . '-%')
            ->get();

            $title_collection = DB::table('section_basics')
            ->where('user_id', '=', $user->id)
            ->where('restriction', '<', 2)
            ->where('title', 'LIKE', $request->title . '-%')
            ->orderByDesc('ref_date')
            ->get();

            // dd($title_collection);

            $heading_collection_raw = [];

            $statement = '';

            foreach ($title_collection as $key => $value) {

                // dd($key, $value);

                // fill in entry content
                $statement_get = DB::table('section_statements')
                ->where('restriction', '<', 2)
                ->where('id', '=', $value->id)
                ->get();

                // dd($statement_get);
                if (count($statement_get) > 0) $statement = $statement_get[0]->statement;

                $substr_year = substr($value->ref_date, 0, 4);
                $substr_month = intval(substr($value->ref_date, 5, 2));
                $substr_day = intval(substr($value->ref_date, 9, 2));

                if (!isset($heading_collection_raw[0])) $heading_collection_raw[0] = [];

                // fill in year - main chapter
                if (!array_key_exists($substr_year, $heading_collection_raw[0])) $heading_collection_raw[0][$substr_year] = [];
                $heading_collection_raw[0][$substr_year] = [count($heading_collection_raw[0]), $request->title, $statement];
                // array_push($heading_collection_raw[0][$substr_year], [$count_year+1, $request->title, $statement]);
                // array_push($heading_collection_raw[0][$substr_year], [$count_year+1, $request->title, $statement]);
                // $count_year++;

                // create month index
                if (!isset($heading_collection_raw[$substr_year])) $heading_collection_raw[$substr_year] = [];

                // fill in month - main chapter
                if (!array_key_exists($substr_month, $heading_collection_raw[$substr_year])) {
                    $heading_collection_raw[$substr_year][$substr_month] = [];
                    $heading_collection_raw[$substr_year][$substr_month][0] = [count($heading_collection_raw)-1 . '.' . count($heading_collection_raw[$substr_year]), $substr_year . '-' . $substr_month, ''];

                    // array_push($heading_collection_raw[$substr_year], [month+1, $request->title, $statement]);
                    // $count_month++;
                }

                // dd($heading_collection_raw);

                // fill in day - main chapter
                if (!isset($heading_collection_raw[$substr_year][$substr_month][1])) $heading_collection_raw[$substr_year][$substr_month][1] = [];
                if (!array_key_exists($substr_day, $heading_collection_raw[$substr_year][$substr_month][1])) {
                    // $heading_collection_raw[$substr_year][$substr_month][1] = [];
                    array_push($heading_collection_raw[$substr_year][$substr_month][1], [count($heading_collection_raw)-1 . '.' . count($heading_collection_raw[$substr_year]) . '.' . count($heading_collection_raw[$substr_year][$substr_month][1])+1, $substr_year . '-' . $substr_month . '-' . $substr_day, $statement_get[0]->statement]);
                    // $count_chapter_level_1++;
                    // $count_day++;
                }

                // dd($heading_collection);

                // dd($substr_year, $substr_month);

                // if (!isset($month_group[$substr_year])) $month_group[$substr_year] = [];
                // if (!isset($month_group[$substr_year][$substr_month])) $month_group[$substr_year][$substr_month] = [];

                // $statement_content = null;

                // if (count($statement_get) > 0) $statement_content = $statement_get[0]->statement;

                // array_push($month_group[$substr_year][$substr_month], [$substr_day, $value->title, $statement_content]);

                // $date_collection = $month_group->sortKeys();

                // dd($month_group);

                // dd(substr($value->ref_date, 0, 7));

                // create month array if not found
                // if (!isset($month_group[0][1])) $month_group[0][1] = [];
                // if (!isset($month_group[0][1][substr($value->ref_date, 0, 7)])) $month_group[0][1][substr($value->ref_date, 0, 7)] = [];

                // dd($month_group);
                // dd($month_group[0][1][intval(substr($value->ref_date, 5, 2))]);

                // $month_group[intval(substr($value->ref_date, 0, 4))] [intval(substr($value->ref_date, 5, 2)) => $value->title];
                // array_push($month_group[0][1][substr($value->ref_date, 0, 7)], $value->title);
                // $month_group[intval(substr($value->ref_date, 0, 4))][intval(substr($value->ref_date, 5, 2))] = $value->title;
                // dd($month_group);
                // dd($value);

                // $date_slice = [];
                // $date_slice[0] = intval(substr($value->ref_date, 0, 4));
                // $date_slice[1] = intval(substr($value->ref_date, 5, 2));
                // dd($date_slice);
                // dd($month_group);
                // $count_chapter_level_1++;
            }



            // dd($heading_collection_raw);

            $count_year = 0;

            // form main chapter
            foreach ($heading_collection_raw as $key => $value) {

                // dd($key, $value);
                if (!isset($heading_collection[$count_year])) $heading_collection[$count_year] = [];
                // array_push($heading_collection[0], $value);

                // form chapter level 1

                $count_month = 0;

                foreach ($value as $key2 => $value2) {

                    // dd($key2, $value2);

                    if (!is_array($value2[0])) array_push($heading_collection[$count_year], $value2);
                    else {
                        array_push($heading_collection[$count_year], []);


                        $count_day = 0;

                        // form chapter level 2
                        foreach ($value2 as $key3 => $value3) {

                            // dd($key3, $value3);

                            if (is_array($value3)) {

                                if (!isset($heading_collection[$count_year][$count_month])) $heading_collection[$count_year][$count_month] = [];
                                array_push($heading_collection[$count_year][$count_month], $value3);
                                $count_day++;
                            }

                        }
                        $count_month++;
                    }


                }
                // dd($heading_collection_raw, $heading_collection);
                $count_year++;
            }

            // dd($heading_collection_raw, $heading_collection);
            // dd('ok');

            // dd($heading_collection);

            // dd(array_values($heading_collection));

            // date collecton sorting
            // krsort($month_group);

            // $date_collection = [];
            // dd($month_group);
            // $index_year = 0;

            // create month
            // foreach ($month_group as $key => $value) {

            //     create year
            //     if(!isset($date_collection[0][$index_year])) $date_collection[0] = [];
            //     $date_collection[$index_year] = [$index_year+1, 123, $key];
            //     array_key_exists($date_collection[0)]
            //     $index_year++;

            //     krsort($value);

            //     foreach ($value as $key2 => $value2) {

            //     }
            // }

            // dd($array);
            // dd($title_collection, $month_group, $date_collection);
        }

        function document_custom_check($chapter_id, $entry_id, &$value_detail_content_collection, &$heading_collection) {

            $user = Auth::user();

            // dd($value_detail_content_collection);

            // global $value_detail_content_collection;

            // dd($chapter_id, $entry_id, $value_detail_content_collection);

            // search for custom detail correlation
            $value_detail = DB::table('tags')
            ->where('user_id', '=', $user->id)
            ->where('restriction', '<', 2)
            ->where('tag_2_id', '=', $chapter_id[0])
            ->whereIn('tag_0_id', [$entry_id])
            ->select('basic_id', 'tag_3_id')
            ->get()
            ->toArray();

            // dd($chapter_id, $entry_id, $value_detail);

            $value_detail_id = array_column($value_detail, 'tag_3_id');

            foreach ($value_detail as $key => $value) {
                $value_detail_content = DB::table('tag_3s')
                ->where('id', '=', $value->tag_3_id)
                ->pluck('content');

                $title = DB::table('section_basics')
                ->where('restriction', '<', 2)
                ->where('id', '=', $value->basic_id)
                ->pluck('title');

                $statement = DB::table('section_statements')
                ->where('restriction', '<', 2)
                ->where('basic_id', '=', $value->basic_id)
                ->pluck('statement');

                if (count($value_detail_content) > 0) $value_detail_content_collection[$key] = [$value_detail_content[0], $title[0], $statement[0]];
                else $value_detail_content_collection[$key] = '';
            }

            // dd($value_detail_content_collection);

            $chapter_extraction = array_column($value_detail_content_collection, 0);

            // dd($chapter_extraction);

            // valdiate chapter duplicates
            if(count($chapter_extraction) != count(array_unique($chapter_extraction))) dd('ok');

            // build chapter structure
            foreach ($chapter_extraction as $key => $value) {

                $chapter_split = explode('.', $value);

                // dd($chapter_group_collection);

                switch (count($chapter_split)) {
                    case 1:
                        // dd('ok1');
                        if (!isset($chapter_group_collection[0])) $chapter_group_collection[0] = [];
                        array_push($chapter_group_collection[0], $chapter_split[0]);

                        if (!isset($heading_collection[0])) $heading_collection[0] = [];
                        array_push($heading_collection[0], $value_detail_content_collection[$key]);
                        break;

                    case 2:
                        if (!isset(($chapter_group_collection[$chapter_split[0]][$chapter_split[1]-1]))) {
                            $chapter_group_collection[$chapter_split[0]][$chapter_split[1]-1] = [];
                        }
                        array_push($chapter_group_collection[$chapter_split[0]][$chapter_split[1]-1], $chapter_split[1]);

                        if (!isset(($heading_collection[$chapter_split[0]][$chapter_split[1]-1]))) {
                            $heading_collection[$chapter_split[0]][$chapter_split[1]-1] = [];
                        }
                        array_push($heading_collection[$chapter_split[0]][$chapter_split[1]-1], $value_detail_content_collection[$key]);

                        break;

                    case 3:

                        if (!isset(($chapter_group_collection[$chapter_split[0]][$chapter_split[1]-1][1][$chapter_split[2]-1]))) {
                            $chapter_group_collection[$chapter_split[0]][$chapter_split[1]-1][1][$chapter_split[2]-1] = [];
                        }
                        $chapter_group_collection[$chapter_split[0]][$chapter_split[1]-1][1][$chapter_split[2]-1] = $chapter_split[2];

                        if (!isset(($heading_collection[$chapter_split[0]][$chapter_split[1]-1][1][$chapter_split[2]-1]))) {
                            $heading_collection[$chapter_split[0]][$chapter_split[1]-1][1][$chapter_split[2]-1] = [];
                        }
                        $heading_collection[$chapter_split[0]][$chapter_split[1]-1][1][$chapter_split[2]-1] =  $value_detail_content_collection[$key];

                        break;
                }
            }

            // dd($chapter_group_collection);

            // validate continous order
            for ($i=1; $i <= count($chapter_group_collection[0]); $i++) {
                if (array_search($i, $chapter_group_collection[0]) === false) dd('false');
            }

            // dd($chapter_group_collection);

            // separate into main chapters
            for ($i=1; $i < count($chapter_group_collection); $i++) {

                // dd($chapter_group_collection[$i]);

                // separate into level 1 chapters
                foreach ($chapter_group_collection[$i] as $chapterLevel1_index => $chapterLevel1_item) {

                    // dd($chapter_group_collection, $chapterLevel1_item, $i);

                    // dd($chapter_group_collection, $chapterLevel1_item, $chapterLevel1_item[1], count($chapterLevel1_item[1]));

                    // if (isset($chapterLevel1_item))

                    // dd($chapterLevel1_item);

                    // if (!isset($chapterLevel1_item[1])) dd($i, $chapterLevel1_item);

                    // separate into level 2 chapters
                    if(isset($chapterLevel1_item[1])) {

                        for ($ii=1; $ii <= count($chapterLevel1_item[1]); $ii++) {

                            // dd('ok');

                            // if (isset($chapterLevel1_item[1][$ii])) {

                            //     for ($iii=1; $iii <= count($chapterLevel1_item[1][$ii]); $iii++) {
                            //         if (array_search($iii, $chapterLevel1_item[$ii-1]) === false) dd('false', $chapterLevel1_item);
                            //     }
                            // }

                            // if (array_search($ii, $chapterLevel1_item) === false) dd('false', $chapterLevel1_item);
                        }
                    }

                    // dd('ok');
                }
            }

            // foreach ($value_detail_content_collection as $key => $value) {

            //     $heading_level = explode('.', $value[0]);

            //     switch (count($heading_level)) {
            //         case 1:
            //             $heading_collection[$heading_level[0]-1][0] = [$value[0], $value[1], $value[2]];
            //             break;

            //         case 2:
            //             if (!isset($heading_collection[$heading_level[0]-1][1])) $heading_collection[$heading_level[0]-1][1] = [];
            //             array_push($heading_collection[$heading_level[0]-1][1], [$value[0], $value[1], $value[2]]);
            //             break;
            //     }
            // }

            // dd($heading_collection);
            // dd($value_detail_content_collection);
            // return $value_detail_content_collection;
        }

        // get chapter id
        $chapter_id = DB::table('tag_0s')
        ->where('content', '=', 'Chapter')
        ->pluck('id');

        // get value tag id
        $entry_id = DB::table('tag_2s')
        ->where('content', '=', $request->id)
        ->pluck('id');

        // check for detail date correlation
        $detail_date_id = DB::table('tag_3s')
        ->where('content', '=', 'date')
        ->pluck('id');

        // dd($detail_date_id);
        // dd($value_detail_content_collection);

        // $value_detail_content_collection = [1];

        if (count($detail_date_id) > 0) document_date_check($request, $chapter_id, $entry_id, $detail_date_id, $value_detail_content_collection, $heading_collection);

        array_values($heading_collection);

        // dd($value_detail_content_collection, $heading_collection);

        return Inertia::render('DocManager/Document', ['fromController' => $heading_collection]);
    }
}
