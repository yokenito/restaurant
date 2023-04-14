<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Photo;
use App\Models\Genre;
use App\Models\Keyword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $stores = Store::orderBy('average_star', 'desc')->get();
        $genres = Genre::all();
        return view('store.index',compact('stores','genres','user'));
    }

    public function userindex(){
        $user = Auth::user();
        $stores_user = Auth::user()->stores;
        return view('store.userindex', compact('stores_user','user'));
    }

    public function niceindex(){
        $user = Auth::user();
        $stores_nice = Auth::user()->nices()->get();
        return view('store.niceindex', compact('stores_nice','user'));
    }

    public function searchindex(Request $request)
    {
        $user = Auth::user();
        if($request->keyword !=null){
            $storeIds = Keyword::select('store_id')->where('keyword','like', '%'.$request->keyword.'%')->distinct()->get();
            $stores = Store::where('store_name','like','%'.$request->store_name.'%')
                        ->whereIn('id', $storeIds);
        }else{
            $stores = Store::where('store_name','like','%'.$request->store_name.'%');
        }
        
        if($request->budget != null){
            $budget = $request->budget;
            $stores = $stores
                ->where(function($query) use($budget){
                    $query->where([['lunchprice_min','<=',$budget],['lunchprice_max','>=',$budget]])
                    ->orWhere([['dinnerprice_min','<=',$budget],['dinnerprice_max','>=',$budget]]);
                });
        }
        
        if($request->genre_id != null){
            $stores = $stores->where('genre_id',$request->genre_id);
        } 

        if($request->sort == "recomend"){
            $stores = $stores->orderBy('average_star', 'desc');
        } elseif($request->sort == "low_lunch"){
            $stores = $stores->orderBy('lunchprice_min', 'asc');
        } elseif($request->sort == "low_dinner"){
            $stores = $stores->orderBy('dinnerprice_min', 'asc');
        } elseif($request->sort == "hight_lunch"){
            $stores = $stores->orderBy('lunchprice_max', 'desc');
        } elseif($request->sort == "hight_dinner"){
            $stores = $stores->orderBy('dinnerprice_max', 'desc');
        } else{
            $stores = $stores;
        }
        
        $stores = $stores->get();
        $genre_name = Genre::where('id',$request->genre_id)->first();
        $genres = Genre::all();
        return view('store.searchindex',compact('stores','genres','request','genre_name','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $genres = Genre::all();
        return view('store.create', compact('genres'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required',
            'store_address' => 'required',
            'genre_id' => 'required',
            'access' => 'required',
            'lunchprice_min' => 'numeric',
            'lunchprice_max' => 'numeric',
            'dinnerprice_min' => 'numeric',
            'dinnerprice_max' => 'numeric',
        ]);

        $store = new Store();
        $store->store_name = $request->input('store_name');
        $store->store_address = $request->input('store_address');
        $store->start_time = $request->input('start_time');
        $store->end_time = $request->input('end_time');
        $store->regular_holiday = $request->input('regular_holiday');
        $store->store_phone = $request->input('store_phone');
        $store->genre_id = $request->input('genre_id');
        $store->lunchprice_min = $request->input('lunchprice_min');
        $store->lunchprice_max = $request->input('lunchprice_max');
        $store->dinnerprice_min = $request->input('dinnerprice_min');
        $store->dinnerprice_max = $request->input('dinnerprice_max');
        $store->access = $request->input('access');
        $store->description_about = $request->input('description_about');
        $store->description_detail = $request->input('description_detail');
        $store->cash_way = $request->input('cash_way');
        $store->user_id = Auth::id();
        $store->save();

        return redirect()->route('store.userindex');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function show(Store $store)
    {
        $user = Auth::user();
        $photos = Photo::where('store_id',$store->id)->latest('updated_at')->get();
        return view('store.show',compact('store','user','photos'));
    }
    public function niceshow(Store $store)
    {
        $user = Auth::user();
        $photos = Photo::where('store_id',$store->id)->latest('updated_at')->get();
        return view('store.niceshow',compact('store','user','photos'));
    }

    public function commentshow(Store $store)
    {
        $user = Auth::user();
        $comments = $store->comments()->get();
        return view('store.commentshow', compact('store', 'comments', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function edit(Store $store)
    {
        $genres = Genre::all();
        return view('store.edit', compact('store','genres'));
    }


    public function keywordsedit(Store $store)
    {
        $keywords = $store->keywords()->get();
        return view('store.keywordsedit', compact('keywords', 'store'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'store_name' => 'required',
            'store_address' => 'required',
            'genre_id' => 'required',
            'access' => 'required',
            'lunchprice_min' => 'numeric',
            'lunchprice_max' => 'numeric',
            'dinnerprice_min' => 'numeric',
            'dinnerprice_max' => 'numeric',
        ]);

        $store->store_name = $request->input('store_name');
        $store->store_address = $request->input('store_address');
        $store->start_time = $request->input('start_time');
        $store->end_time = $request->input('end_time');
        $store->regular_holiday = $request->input('regular_holiday');
        $store->store_phone = $request->input('store_phone');
        $store->genre_id = $request->input('genre_id');
        $store->lunchprice_min = $request->input('lunchprice_min');
        $store->lunchprice_max = $request->input('lunchprice_max');
        $store->dinnerprice_min = $request->input('dinnerprice_min');
        $store->dinnerprice_max = $request->input('dinnerprice_max');
        $store->access = $request->input('access');
        $store->description_about = $request->input('description_about');
        $store->description_detail = $request->input('description_detail');
        $store->cash_way = $request->input('cash_way');
        $store->save();

        return redirect()->route('store.userindex');
    }

    public function keywordsupdate(Request $request, Keyword $keyword)
    {
        $request->validate([
            'keyword' => 'required'
        ]);

        $keyword->keyword = $request->input('keyword');
        $keyword->save();

        return redirect()->route('store.userindex');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Store  $store
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $store->delete();

        return redirect()->route('store.userindex');
    }

    public function keywordsdestroy(Keyword $keyword, Store $store)
    {
        $keyword->delete();
        $store_id = $keyword->store_id;
        return redirect()->route('store.keywordsedit', ['store' => $store_id]);
    }

    // いいねメソッドを作る　返すものはレスポンスjson
    public function nicestore($store_id){
        Auth::user()->nice($store_id);
        return ;
    }
    public function nicedelete($store_id){
        Auth::user()->deletenice($store_id);
        return ;
    }

}
