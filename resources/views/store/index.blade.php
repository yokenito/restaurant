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
                        <input type="text" name="store_name" class="form-control" placeholder="店舗名">
                    </div>
                    <div class="ps-3 d-flex align-items-center">
                        <input type="text" name="budget" class="form-control" placeholder="予算">
                        <span class="fs-5">円</span>
                    </div>
                    <div class="ps-3">
                        <select name="genre_id" class="form-control">
                            <option value="">ジャンル</option>
                            @foreach($genres as $genre)
                                <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="ps-3">
                        <input type="text" name="keyword" class="form-control" placeholder="キーワード">
                    </div>
                    <div class="ps-3">
                        <select name="sort" class="form-control">
                            <option value="">並び替え</option>
                            <option value="recomend">おすすめ順</option>
                            <option value="low_lunch">昼料金(低)</option>
                            <option value="hight_lunch">昼料金(高)</option>
                            <option value="low_dinner">夜料金(低)</option>
                            <option value="hight_dinner">夜料金(高)</option>
                        </select>
                    </div>
                </div>

                <div class="ps-3 search-btn-box">
                    <button type="submit" class="btn btn-outline-primary search-btn">検索</button>
                </div>
            </div>
        </form>

        <!-- おすすめ飲食店一覧セクション -->
        <h2 class="section-ttl">オススメ飲食店</h2>
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