@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
<main>
    <h2 class="section-ttl">コメント一覧</h2>
    <div>
        <a href="{{route('store.index')}}">&lt; 戻る</a>
    </div>
        <div>
            <div class="store-card">
                @if($user != null)
                    @if($user->isNice($store->id))
                        <button onclick="nice({{$store->id}}, this)" class="nicebtn active">
                            <span class="nice">★</span>お気に入り
                        </button>
                    @else
                        <button onclick="nice({{$store->id}}, this)" class="nicebtn">
                            <span class="nice">★</span>お気に入り
                        </button>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="nicebtn unnicebtn-unlogin"><span class="nice">★</span>お気に入り</a>
                @endif

                <div>
                    <div>
                        <h5 class="genre-name">{{$store->genre->genre_name}}</h5>
                        <h3 class="store-ttl">{{$store->store_name}}</h3>
                    </div>
                    <div>
                        <span>評価</span>
                        @for($i = 0; $i < $store->average_star; $i++)
                            <span class="star">★</span>
                        @endfor
                    </div>
                </div>
                <div>
                    <!-- 写真が入る -->
                    <div style="width: 100%;">
                        @if(count($store->photos()->get())<=4)
                        <div class="d-flex allphotobox">
                        @else
                        <div class="d-flex allphotobox carousel autoplay">
                        @endif
                            @foreach($store->photos()->get() as $photo)
                                <div class="photobox">
                                    <img class="carouselImg" src="{{asset($photo->path)}}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @foreach($comments as $comment)
                    <div class="mt-5 comment-box">
                        <div class="d-flex">
                            <h4>{{$comment->user->name}}さんからの投稿</h4>
                            <p class="ms-3 mt-1">{{substr($comment->updated_at,0,10)}} 投稿</p>
                        </div>
                        <div class="d-flex">
                            <h5 class="me-1">評価:</h5>
                            <p class="y-fz-searchresult">
                                @for($i = 0; $i < $store->average_star; $i++)
                                    <span class="star">★</span>
                                @endfor
                            </p>
                        </div>
                        <div>
                            <h5 class="me-1">＜コメント＞</h5>
                            <p class="y-fz-searchresult">{{$comment->comment}}</p>
                        </div>
                    </div>
                @endforeach
            </div>
          
        </div>
    </main>
@endsection