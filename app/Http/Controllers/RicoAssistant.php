<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Post;
use App\Models\Tag;
use App\Models\Basic;
use App\Models\Rating;
use App\Models\Reference;
use App\Models\Statement;
use App\Models\Accounting;
use App\Models\User;
use App\Models\Contact;
use App\Models\Document;
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

        if(isset($user)) {$userAuth = Basic::all()->where('user_id', '=', $user->id)->take(1); $listAuth = $publicAuth->merge($userAuth);}
        else {$listAuth = $publicAuth;};

        return Inertia::render('TabManager/TabManager', ['list' => $listAuth]);
    }

    public function detail(Request $request) {

        dd($request);

        // dd($request->basic_id);

        $user = Auth::user();

            $basic = Basic::find($request->basic_id);
            // $statement = Statement::find($request->id);
            // $activity = Activity::find($request->id);
            // $reference = Reference::find($request->id);
            // $tag = Tag::find($request->id);
            // $accounting = Accounting::find($request->id);
            // $documents = DB::table('documents')->where('documents.basic_id', '=', $request->id)->get();
            // $rating = Rating::find($request->id);

            // return Inertia::render('TabManager', ['basic' => $basic, 'statement' => $statement, 'accounting' => $accounting, 'activity' => $activity, 'reference' => $reference, 'tag' => $tag, 'rating' => $rating, 'documents' => $documents]);
            // dd($basic->title);

            return Inertia::render('TabManager/TabManager', ['detail' => $basic]);
    }

    public function store(Request $request) {

        // dd($request->filelist);

        $user = Auth::user();

        $validated = $request->validate([
            'basicRefDate' => 'required',
            'basicMedium' => 'required',
            'basicTitle' => 'required',
        ]);

        // dd($request);

        $rating = 0;
        $activity = 0;
        $accounting = 0;

        foreach($request->all() as $key => $value) {

            if(strpos($key, 'rating') !== false){
                $rating = 1;
            }

            if(strpos($key, 'activity') !== false){
                $activity = 1;
            }

            if(strpos($key, 'accounting') !== false){
                $accounting = 1;
            }
        }

        $basic = new Basic();
        $basic->ref_date = $request->basicRefDate;
        $basic->title = $request->basicTitle;
        $basic->medium = $request->basicMedium;
        // $basic->status = $request->basic['status'];
        $basic->user_id = $user->id;
        $basic->tracking = $request->ip();
        $basic->save();

        if(isset($request->statement)){

            $statement = new Statement();
            $statement->basic_id = $basic->id;
            $statement->statement = $request->statement;
            $statement->tracking = $request->ip();
            $statement->save();
        }

        // dd($request);

        if($rating == 1){

            $rating = new Rating();

            $rating->basic_id = $basic->id;
            if(isset($request->rating_comparison)) {$rating->rating_comparison = $request->rating_comparison;};
            if(isset($request->rating_happiness)) {$rating->rating_happiness = $request->rating_happiness;};
            if(isset($request->rating_sadness)) {$rating->rating_sadness = $request->rating_sadness;};
            if(isset($request->rating_quality)) $rating->rating_quality= $request->rating_quality;
            if(isset($request->rating_ingenuity)) $rating->rating_ingenuity = $request->rating_ingenuity;
            if(isset($request->rating_originality)) $rating->rating_originality= $request->rating_originality;
            if(isset($request->rating_complexity)) $rating->rating_complexity = $request->rating_complexity;
            if(isset($request->rating_simplicity)) $rating->rating_simplicity = $request->rating_simplicity;
            if(isset($request->rating_usability)) $rating->rating_usability = $request->rating_usability;
            if(isset($request->rating_versatility)) $rating->rating_versatility = $request->rating_versatility;
            if(isset($request->rating_developement)) $rating->rating_developement = $request->rating_developement;
            if(isset($request->rating_sustainability)) $rating->rating_sustainability = $request->rating_sustainability;
            $rating->tracking = $request->ip();
            $rating->save();

        }

        if($request->activityTo){

            // dd($request->activityTo[0]);

            foreach ($request->activityTo as $i=>$activity) {

                if (is_numeric($request->activityTo[$i])) {

                    $activities[$i] = [
                        'basic_id' => $basic->id,
                        'activityTo' => $request->activityTo[$i],
                        'activityReference' => $request->activityReference[$i],
                        'tracking' => $request->ip(),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                }

            };

            DB::table('activities')->insert($activities);

        }

        if($request->reference){

            $activity = new Reference();

            $activity->basic_id = $basic->id;
            $activity->reference = $request->reference;
            $activity->tracking = $request->ip();
            $activity->save();

        }

        if($request->tag){

            $tag = new Tag();

            $tag->basic_id = $basic->id;
            $tag->tag = $request->tag;
            $tag->tracking = $request->ip();
            $tag->save();

        }

        if($accounting == 1){

            $accounting = new Accounting();

            $accounting->basic_id = $basic->id;
            $accounting->accounting_producer = $request->accounting_producer;
            $accounting->accounting_trader = $request->accounting_trader;
            $accounting->accounting_price = $request->accounting_price;
            $accounting->accounting_currency = $request->accounting_currency;
            $accounting->accounting_price_default_currency = $request->accounting_price_default_currency;
            $accounting->tracking = $request->ip();
            $accounting->save();

        }

        // dd($request);

        if(isset($request->filelist)) {
            foreach($request->file('filelist') as $dataString) {

                // dd($dataString['file']->hashName());

                $document = new Document();
                $document->basic_id = $basic->id;
                $document->path = $dataString['file']->hashName();
                $document->extension = $dataString['file']->extension();
                $document->size = $dataString['file']->getSize();
                $document->tracking = $request->ip();
                $document->save();
            }

            foreach($request->file('filelist') as $dataString2) {
                Storage::disk('local')->put('public/images/inventory/', $dataString2['file']);
            }
        }

        if(isset($request->documentJPG)) {
            foreach($request->file('filelist') as $dataString) {

                $document = new Document();
                $document->basic_id = $basic->id;
                $document->path = $dataString->hashName();
                $document->extension = $dataString->extension();
                $document->size = $dataString->getSize();
                $document->tracking = $request->ip();
                $document->save();
            }

            foreach($request->file('documentJPG') as $dataString2) {
                Storage::disk('local')->put('public/images/inventory/', $dataString2);
            }
        }

        if(isset($request->document_link)) {

                $document = new Document();
                $document->basic_id = $basic->id;
                $document->path = $request->document_link;
                $document->extension = 'www';
                $document->size = 0;
                $document->tracking = $request->ip();
                $document->save();
        }

        // dd($request);

        return redirect()->route('/')->with('message', 'Entry Successfully Created');
    }

    public function update(Request $request) {

        foreach($request->all() as $key => $value) {

            if($key != 'id'){

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
    // **************************************************

    public function reference(Request $request) {

        // dd($request);

        $user = Auth::user();
        $result = [];

        if ($request->activityReference == 'lastUsed') {

            $referencedIds = DB::table('basics')
                ->where('status', '=', null)
                ->where('user_id', '=', $user->id)
                ->orderByDesc('updated_at')
                ->take(10)
                ->get();

            foreach ($referencedIds as $i=>$id) {

                $result['referencesResult'][$i]['title'] = $id->title;
                $result['referencesResult'][$i]['medium'] = $id->medium;
                $result['referencesResult'][$i]['id'] = $id->id;

                $tag = DB::table('tags')
                ->where('basic_id', '=', $id->id)
                ->where('tagcontext', '=', 'ActivityDiagramColor')
                ->get();

                if (count($tag)) {
                    $result['referencesResult'][$i]['color'] = $tag[0]->tagcontent;
                } else {};

            };

            $result['misc']['row'] = $request->row;

        }

        else {

            $referencesResultCheck = DB::table('basics')
                ->where('status', '=', null)
                ->where('user_id', '=', $user->id)
                ->where('title', 'LIKE', '%'.$request->activityReference.'%')
                ->get();

            if (count($referencesResultCheck)) {

                foreach ($referencesResultCheck as $i=>$id) {

                    if (count($referencesResultCheck) == 0) {} else {
                        $result['referencesResult'][$i]['title'] = $id->title;

                        $tag = DB::table('tags')
                            ->where('basic_id', '=', $id->id)
                            ->where('tagcontext', '=', 'ActivityDiagramColor')
                            ->get();

                        // dd($tag);

                        if (count($tag)) {
                            $result['referencesResult'][$i]['color'] = $tag[0]->tagcontent;
                        } else {};

                        $result['referencesResult'][$i]['medium'] = $id->medium;
                        $result['referencesResult'][$i]['id'] = $id->id;
                    }
                }

                $result['misc']['row'] = $request->row;
            } else {
                $result['misc']['row'] = 0;
            };
        }

        // dd($result);

        return Inertia::render('Create', $result);
    }

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

        return Inertia::render('Create', $basicResult);
    }
}
