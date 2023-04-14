@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
<main>
    <h2 class="section-ttl">コメント一覧</h2>
        <div>
            @foreach($comments as $comment)
            <div class="store-card">
                @if($user->isNice($comment->store->id))
                    <button onclick="nice({{$comment->store->id}}, this)" class="nicebtn active">
                        <span class="nice">★</span>お気に入り
                    </button>
                @else
                    <button onclick="nice({{$comment->store->id}}, this)" class="nicebtn">
                        <span class="nice">★</span>お気に入り
                    </button>
                @endif

                <div>
                    <div>
                        <h5 class="genre-name">{{$comment->store->genre->genre_name}}</h5>
                        <h3 class="store-ttl">{{$comment->store->store_name}}</h3>
                    </div>
                    <div>
                        <span>評価</span>
                        @for($i = 0; $i < $comment->store->average_star; $i++)
                            <span class="star">★</span>
                        @endfor
                    </div>
                </div>
                <div>
                    <!-- 写真が入る -->
                    <div style="width: 100%;">
                        @if(count($comment->store->photos()->get())<=4)
                        <div class="d-flex allphotobox">
                        @else
                        <div class="d-flex allphotobox carousel autoplay">
                        @endif
                            @foreach($comment->store->photos()->get() as $photo)
                                <div class="photobox">
                                    <img class="carouselImg" src="{{asset($photo->path)}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="d-flex">
                        <h5 class="me-1">・投稿評価:</h5>
                        <p class="y-fz-searchresult">{{$comment->star_count}}</p>
                    </div>
                    <div>
                        <h5 class="me-1">・投稿コメント:</h5>
                        <p class="y-fz-searchresult">{{$comment->comment}}</p>
                    </div>
                </div>

                <div class="d-flex mt-2">
                    <div>
                        <a href="{{route('comments.edit', $comment)}}" class="btn btn-outline-primary me-3">編集</a>
                    </div>
                    <form action="{{route('comments.destroy',$comment)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-danger">削除</button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </main>
@endsection