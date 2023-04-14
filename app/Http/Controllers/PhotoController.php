<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PhotoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $storeIds = Photo::select('store_id')->where('user_id', Auth::id())->distinct()->get();
        $stores = Store::whereIn('id', $storeIds)->get();

        return view('photo.index', compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store)
    {
        return view('photo.create', compact('store'));
    }

    public function nicecreate(Store $store)
    {
        return view('photo.nicecreate', compact('store'));
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
            'image' => 'required',
        ]);

        $dir = 'photo';


        $files = $request->file('image');

        foreach($files as $file){
            $file_name = $file->getClientOriginalName();
            $file->storeAs('public/' . $dir, $file_name);

            $photo = new Photo();
            $photo->name = $file_name;
            $photo->path = 'storage/' . $dir . '/' . $file_name;
            $photo->user_id = Auth::id();
            $photo->store_id = $request->input('store_id');
            $photo->save();
        }

        $store = $photo->store->id;
        return redirect()->route('store.show', ['store' => $store]);
        
    }

    public function nicestore(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);

        $dir = 'photo';


        $files = $request->file('image');

        foreach($files as $file){
            $file_name = $file->getClientOriginalName();
            $file->storeAs('public/' . $dir, $file_name);

            $photo = new Photo();
            $photo->name = $file_name;
            $photo->path = 'storage/' . $dir . '/' . $file_name;
            $photo->user_id = Auth::id();
            $photo->store_id = $request->input('store_id');
            $photo->save();
        }

        $store = $photo->store->id;
        return redirect()->route('store.niceshow', ['store' => $store]);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function show(Photo $photo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function edit(Photo $photo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Photo $photo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Photo  $photo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Photo $photo)
    {
        $photo->delete();
        return redirect()->route('photo.index');
    }
}
