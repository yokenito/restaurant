@extends('layouts.app')

@section('content')
    <h2 class="section-ttl">コメント投稿</h2>
    <div>
        <a href="{{route('store.niceshow', $store)}}">&lt; 戻る</a>
    </div>

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        <h5 class="genre-name">{{$store->genre->genre_name}}</h5>
        <h3 class="store-ttl">{{$store->store_name}}</h3>
    </div>

    <form action="{{route('comments.nicestore',$store)}}" method="post" class="mt-4 w-75">
        @csrf
        <div>
            <label for="star_count" class="form-label">評価(1~5)<span class="form-note">必須</span></label>
            <input type="number" name="star_count" class="form-control" value="{{ old('star_count') }}">
        </div>
        <div class="mt-2">
            <label for="comment" class="form-label">コメント</label>
            <textarea name="comment" class="form-control" value="{{ old('comment') }}"></textarea>
        </div>

        <input type="hidden" name="store_id" value="{{$store->id}}">

        <button type="submit" class="btn btn-outline-primary mt-4">投稿</button>
    </form>

@endsection