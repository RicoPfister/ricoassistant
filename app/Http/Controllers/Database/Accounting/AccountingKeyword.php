<?php

namespace App\Http\Controllers\Database\Accounting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Inventory;
use App\Models\Document;
use App\Models\Keyword;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Illuminate\Support\Facades\DB;

class AccountingKeyword extends Controller
{
    public function filter (Request $request) {

        // dd($request);

        // $keyword = Keyword::sortByDesc('updated_at')->get()->pluck('keyword')->distinct()->take(20);
        // $keyword = DB::table('keywords')->orderByDesc('updated_at')->select('keyword')->distinct()->get()->take(10);

        if($request->searchString){

            $keyword = DB::table('keywords')->where('keywords.keyword', 'LIKE', '%'.$request->searchString.'%')->get();

            // dd($keyword);

            if(isset($keyword[0])){
            $keyword[0]->{"searchString"} = $request->searchString;
            } else {
                $keyword[0] = ['searchString' => $request->searchString];
            }

        } else{

            $keyword = DB::table('keywords')->orderByDesc('updated_at')->select('keyword')->distinct()->get()->take(10);
            $keyword[0]->{"searchString"} = '';

        }

        // dd($keyword);

        // dd($keyword);

        return Inertia::render('Database/Accounting/Create', ['keyword' => $keyword]);
    }

    public function updatefilter (Request $request) {

        $keyword = Keyword::pluck('keyword')->sortByDesc('updated_at')->take(10);

        // dd($keyword);

        return Inertia::render('Database/Accounting/Detail', ['keyword' => $keyword]);
    }

    // public function updateentry (Request $request) {

    //     // dd($request);

    //     // $keyword = Keyword::pluck('keyword')->sortByDesc('updated_at')->take(5);

    //     // dd($keyword);

    //     return Inertia::render('Database/Accounting/Detail');
    // }

    public function keywordfilter (Request $request) {

        // dd($request);


            $keyword = DB::table('keywords')->orderByDesc('updated_at')->select('keyword')->distinct()->get()->take(10);





        // dd($request);

        // $keyword = Keyword::pluck('keyword')->sortByDesc('updated_at')->take(5);

        // dd($keyword);

        return Inertia::render('Database/Accounting/Detail', ['keyword' => $keyword]);
    }

    public function keywordupdate (Request $request) {

        // dd($request);

        $keywords = array_values(array_filter(array_map('trim', explode(";", $request->keywords))));


        // dd($keywords);
        // dd($keywords);

        $delete = Keyword::where('item_id', '=', $request->id)->delete();

        foreach($keywords as $key => $value){
            $keywordStore = new Keyword();
            $keywordStore->keyword = $value;
            $keywordStore->item_id = $request->id;
            $keywordStore->save();
            // }
        }



        return Inertia::render('Database/Accounting/Detail');
    }

    public function keywordsearch (Request $request) {

        // dd($request->searchString);

        $keywordSearch = DB::table('keywords')->where('keywords.keyword', 'LIKE', '%'.$request->searchString.'%')->get();
        // dd($keywordSearch);

        // $keywords = array_values(array_filter(array_map('trim', explode(";", $request->keywords))));


        // dd($keywords);



        // return Inertia::render('../Components/Database/Accounting/Detail/Documents.vue');
        return Inertia::render('Database/Accounting/Create', ['keywordSearch' => $keywordSearch]);
    }

}
