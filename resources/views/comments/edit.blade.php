@extends('layouts.app')

@section('content')
    <h2 class="section-ttl">コメントの編集</h2>
    <div>
        <a href="{{route('comments.index')}}">&lt; 戻る</a>
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
        <h5 class="genre-name">{{$comment->store->genre->genre_name}}</h5>
        <h3 class="store-ttl">{{$comment->store->store_name}}</h3>
    </div>

    <form action="{{route('comments.update', $comment)}}" method="post" class="mt-4 w-75">
        @csrf
        @method('patch')
        <div>
            <label for="star_count" class="form-label">評価(1~5)<span class="form-note">必須</span></label>
            <input type="number" name="star_count" class="form-control" value="{{old('star_count',$comment->star_count)}}">
        </div>
        <div>
            <label for="comment" class="form-label">コメント</label>
            <textarea name="comment" class="form-control">{{old('comment',$comment->comment)}}</textarea>
        </div>

        <input type="hidden" name="store_id" value="{{$comment->store_id}}">

        <div class="d-flex mt-4">
            <button type="submit" class="btn btn-outline-primary">編集</button>
        </div>
    </form>
    <form action="{{route('comments.destroy', $comment)}}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-outline-danger mt-4">削除</button>
    </form>
@endsection