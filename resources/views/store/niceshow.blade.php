@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
    <main>
        <h2 class="section-ttl">店舗詳細</h2>
        <div>
            <a href="{{route('store.niceindex')}}">&lt; 戻る</a>
        </div>
        
        <a href="{{route('comments.nicecreate', $store)}}">コメント投稿</a>
        <a href="{{route('photo.nicecreate', $store)}}">写真の投稿</a>
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
                <a href="{{ route('login') }}" class="unnicebtn unnicebtn-unlogin"><span id="unnice">☆</span>お気に入り</a>
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
                
                <!-- 写真 -->
                <div style="width: 100%;">
                    @if(count($photos)<=4)
                    <div class="d-flex allphotobox">
                    @else
                    <div class="d-flex allphotobox carousel autoplay">
                    @endif
                        @foreach($photos as $photo)
                            <div class="photobox">
                                <img class="carouselImg" src="{{asset($photo->path)}}">
                            </div>
                        @endforeach
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

                    <h5>●お支払い方法</h5>
                    <p>{{$store->cash_way}}</p>

                    <h5>●店舗詳細</h5>
                    <p>{{$store->description_detail}}</p>
                    
                </div>
            </div>
        </div>
    </main>
@endsection