@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
    <main>
    <h2 class="section-ttl">投稿店舗一覧</h2>
    <a href="{{route('store.create')}}" class="create-newstore">新規投稿</a>
        <div>
            @foreach($stores_user as $store)
            <div class="store-card">
                @if($user->isNice($store->id))
                    <button onclick="nice({{$store->id}}, this)" class="nicebtn active">
                        <span class="nice">★</span>お気に入り
                    </button>
                @else
                    <button onclick="nice({{$store->id}}, this)" class="nicebtn">
                        <span class="nice">★</span>お気に入り
                    </button>
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
                <div class="d-flex mt-2">
                    <div>
                        <a href="{{route('store.edit', $store)}}" class="btn btn-outline-primary me-3">編集</a>
                    </div>
                    <div>
                        <a href="{{route('store.keywordsedit', $store)}}" class="btn btn-outline-primary me-3">キーワード</a>
                    </div>
                    <form action="{{route('store.destroy', $store)}}" method="post">
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