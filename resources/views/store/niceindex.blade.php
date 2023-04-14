@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
    <main>
    <h2 class="section-ttl">お気に入り店舗一覧</h2>
        <div>
            @foreach($stores_nice as $store)
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
                            <span>★</span>
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

                    <a href="{{route('store.niceshow', $store)}}">詳細</a>
                </div>
            </div>
            @endforeach
        </div>
    </main>
@endsection