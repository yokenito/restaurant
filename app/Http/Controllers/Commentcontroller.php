<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Commentcontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $comments = Auth::user()->comments;
        return view('comments.index', compact('comments','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Store $store)
    {
        return view('comments.create', compact('store'));
    }

    public function nicecreate(Store $store)
    {
        return view('comments.nicecreate', compact('store'));
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
            'star_count' => 'required|numeric|max:5'
        ]);

        $comment = new Comment();
        $comment->store_id = $request->input('store_id');
        $comment->user_id = Auth::id();
        $comment->star_count = $request->input('star_count');
        $comment->comment = $request->input('comment');
        $comment->save();

        // コメントの評価計算して保存
        $store = Store::where('id',$request->input('store_id'))->first();
        $stars = Comment::where('store_id', $request->input('store_id'))->get();
        $stars_sum = 0;
        $count = 0;
        foreach($stars as $star){
            $stars_sum += $star->star_count;
            $count++;
        }
        $store->average_star = $stars_sum/$count;
        $store->save();


        return redirect()->route('store.show', ['store' => $store->id]);
    }

    public function nicestore(Request $request)
    {
        $request->validate([
            'star_count' => 'required|numeric|max:5'
        ]);

        $comment = new Comment();
        $comment->store_id = $request->input('store_id');
        $comment->user_id = Auth::id();
        $comment->star_count = $request->input('star_count');
        $comment->comment = $request->input('comment');
        $comment->save();

        // コメントの評価計算して保存
        $store = Store::where('id',$request->input('store_id'))->first();
        $stars = Comment::where('store_id', $request->input('store_id'))->get();
        $stars_sum = 0;
        $count = 0;
        foreach($stars as $star){
            $stars_sum += $star->star_count;
            $count++;
        }
        $store->average_star = $stars_sum/$count;
        $store->save();


        return redirect()->route('store.niceshow', ['store' => $store->id]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        return view('comments.edit', compact('comment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $request->validate([
            'star_count' => 'required|numeric|max:5'
        ]);

        $comment->star_count = $request->input('star_count');
        $comment->comment = $request->input('comment');
        $comment->save();

        // コメントの評価計算して保存
        $store = Store::where('id',$request->input('store_id'))->first();
        // $stars = Comment::select('star_count')->where('store_id', $request->input('store_id'))->get();
        $stars = Comment::where('store_id', $request->input('store_id'))->get();
        // $stars_sum = array_sum($stars); 
        $stars_sum = 0;
        $count = 0;
        foreach($stars as $star){
            $stars_sum += $star->star_count;
            $count++;
        }
        // Store::where('id',$request->input('store_id'))->update(['average_star' => $stars_sum]);

        $store->average_star = $stars_sum/$count;
        $store->save();

        return redirect()->route('comments.index');
    }	

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        
        return redirect()->route('comments.index');
    }
}
