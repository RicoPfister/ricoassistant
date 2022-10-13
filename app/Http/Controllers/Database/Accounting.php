<?php

namespace App\Http\Controllers\Database;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Post;
use App\Models\Inventory;
use App\Models\Document;
use App\Models\ricoassistant;
use App\Models\Contact;
use App\Models\Keyword;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;
use Redirect;
use Illuminate\Support\Facades\DB;

class Accounting extends Controller {

    public function filter(Request $request) {

        $list = ricoassistant::all();

        return Inertia::render('Search', ['list' => $list]);
    }

    public function detail(Request $request) {

        $detail = ricoassistant::find($request->id);
        $documents = DB::table('documents')->where('documents.entry_id', '=', $request->id)->get();

        return Inertia::render('Detail', ['detail' => $detail, 'documents' => $documents]);
    }

    public function store(Request $request) {

        // dd($request);

        $validated = $request->validate([
            'ref_date' => 'required',
            'author' => 'required',
            'category' => 'required',
            'title' => 'required',
        ]);

        $store = new ricoassistant();
        $store->ref_date = $request->ref_date;
        // $store->category = $request->category;
        $store->author = $request->author;
        $store->title = $request->title;

        $store->statement = $request->statement;

        $store->timeTrackingFrom = $request->timeTrackingFrom;
        $store->timeTrackingTo = $request->timeTrackingTo;
        $store->timeTrackingSubCategory = $request->timeTrackingSubCategory;
        $store->timeTrackingActivity = $request->timeTrackingActivity;

        $store->reference = $request->reference;

        $store->tag = $request->tag;

        $store->producer = $request->producer;
        $store->trader = $request->trader;
        $store->price = $request->price;
        $store->currency = $request->currency;
        $store->price_default_currency = $request->price_default_currency;

        $store->rating_quality = $request->rating_quality;
        $store->rating_happyness = $request->rating_happyness;
        $store->rating_usability = $request->rating_usability;
        $store->rating_developement = $request->rating_developement;
        $store->rating_sustainability = $request->rating_sustainability;

        $store->save();

        if(isset($request->documentJPG)) {
            foreach($request->file('documentJPG') as $dataString) {

                // dd($store->id);

                $entry2 = new Document();
                $entry2->path = $dataString->hashName();
                $entry2->extension = $dataString->extension();
                $entry2->size = $dataString->getSize();
                $entry2->entry_id = $store->id;
                $entry2->save();
            }

            foreach($request->file('documentJPG') as $dataString2) {
                Storage::disk('local')->put('public/images/inventory/', $dataString2);
            }
        }

        return redirect()->route('/')->with('message', 'Entry Successfully Created');
    }

    public function update(Request $request) {

        // dd($request->id);

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

        DB::table('ricoassistants')->where('id', '=', $request->id)->delete();

        return redirect()->route('/')->with('message', 'Entry Successfully Deleted');
    }


}
