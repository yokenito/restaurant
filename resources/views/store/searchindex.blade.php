@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
    <main>
        <!-- 検索条件セクション -->
        <h2 class="section-ttl">検索条件</h2>
        <form action="{{route('store.searchindex')}}" method="post" class="search-form">
            @csrf
            <div>
                <div class="my-2 d-flex w-75">
                    <div class="ps-3">
                        <input type="text" name="store_name" class="form-control" value="{{$request->store_name}}" placeholder="店舗名">
                    </div>
                    <div class="ps-3 d-flex align-items-center">
                        <input type="text" name="budget" class="form-control" value="{{$request->budget}}" placeholder="予算">
                        <span class="fs-5">円</span>
                    </div>
                    <div class="ps-3">
                        <select name="genre_id" class="form-control">
                            <option value="">ジャンル</option>
                            @foreach($genres as $genre)
                                @if($genre->id == $request->genre_id)
                                    <option value="{{$genre->id}}" selected>{{$genre->genre_name}}</option>
                                @else
                                    <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="ps-3">
                        <input type="text" name="keyword" class="form-control" value="{{$request->keyword}}" placeholder="キーワード">
                    </div>
                    <div class="ps-3">
                        <select name="sort" class="form-control">
                            @if($request->sort == "")
                                <option value="" selected>並び替え</option>
                            @else
                                <option value="">並び替え</option>
                            @endif

                            @if($request->sort == "recomend")
                                <option value="recomend" selected>おすすめ順</option>
                            @else
                                <option value="recomend">おすすめ順</option>
                            @endif

                            @if($request->sort == "low_lunch")
                                <option value="low_lunch" selected>昼料金(低)</option>
                            @else
                                <option value="low_lunch">昼料金(低)</option>
                            @endif

                            @if($request->sort == "hight_lunch")
                                <option value="hight_lunch" selected>昼料金(高)</option>
                            @else
                                <option value="hight_lunch">昼料金(高)</option>
                            @endif

                            @if($request->sort == "low_dinner")
                                <option value="low_dinner" selected>夜料金(低)</option>
                            @else
                                <option value="low_dinner">夜料金(低)</option>
                            @endif

                            @if($request->sort == "hight_dinner")
                                <option value="hight_dinner" selected>夜料金(高)</option>
                            @else
                                <option value="hight_dinner">夜料金(高)</option>
                            @endif
                        </select>
                    </div>
                </div>

                <div class="ps-3 search-btn-box">
                    <button type="submit" class="btn btn-outline-primary search-btn">検索</button>
                </div>
            </div>
        </form>

        <!-- 検索結果 -->
        <h2 class="section-ttl">検索結果</h2>
        <div class="d-flex">
            <div class="d-flex">
                <h5 class="me-1">・店舗名:</h5>
                <p class="y-fz-searchresult">{{$request->store_name}}</p>
            </div>

            <div class="d-flex ms-3">
                <h5 class="me-1">・予算:</h5>
                <p class="y-fz-searchresult">{{$request->budget}}円</p>
            </div>

            <div class="d-flex ms-3">
                <h5 class="me-1">・ジャンル:</h5>
                @if($genre_name != null)
                <p class="y-fz-searchresult">{{$genre_name->genre_name}}</p>
                @endif
            </div>

            <div class="d-flex ms-3">
                <h5 class="me-1">・キーワード:</h5>
                <p class="y-fz-searchresult">{{$request->keyword}}</p>
            </div>
        </div>

        <!-- おすすめ飲食店一覧セクション -->
        <h2 class="section-ttl">検索店舗一覧</h2>
        <div>
            @foreach($stores as $store)
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

                <div class="store-inf">
                    <h5>●営業時間</h5>
                    <p>{{substr($store->start_time,0,5)}} ~ {{substr($store->end_time,0,5)}}</p>

                    <h5>●定休日</h5>
                    <p>{{$store->regular_holiday}}曜日</p>

                    <h5>●予算</h5>
                    <span>（ランチ）</span>
                    <p>{{$store->lunchprice_min}}円 ~ {{$store->lunchprice_max}}円</p> 
                    <span>（ディナー）</span>
                    <p>{{$store->dinnerprice_min}}円 ~ {{$store->dinnerprice_max}}円</p>

                    <h5>●店舗概要</h5>
                    <p>{{$store->description_about}}</p>

                    <h5>●アクセス</h5>
                    <p>{{$store->access}}</p>

                    <h5>●住所</h5>
                    <p>{{$store->store_address}}</p>

                    <h5>●連絡先</h5>
                    <p>{{$store->store_phone}}</p>

                    <a href="{{route('store.show', $store)}}">詳細</a>
                    <a href="{{route('store.commentshow', $store)}}" class="ms-3">コメント一覧</a>
                </div>
            </div>
            @endforeach
        </div>
    </main>
@endsection