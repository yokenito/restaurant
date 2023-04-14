@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
    <main>
    <h2 class="section-ttl">写真投稿店舗一覧</h2>
        <div>
            @foreach($stores as $store)
            <div class="store-card">
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
                                    <form action="{{route('photo.destroy', $photo)}}" method="post">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-outline-danger">削除</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="d-flex mt-2">
                </div>
            </div>
            @endforeach
        </div>
    </main>
@endsection('content')