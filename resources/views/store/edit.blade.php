@extends('layouts.app')

@section('content')
    <h2 class="section-ttl">投稿店舗の編集</h2>
    <div>
        <a href="{{route('store.userindex')}}">&lt; 戻る</a>
    </div>
    <div>
        <a href="{{route('keywords.create', $store)}}">キーワ-ドの追加</a>
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

    <form action="{{route('store.update', $store)}}" method="post" class="w-75">
        @csrf
        @method('patch')
        <div>
            <label for="store_name" class="form-label">店舗名<span class="form-note">必須</span></label>
            <input type="text" name="store_name" class="form-control" value="{{old('store_name',$store->store_name)}}">
        </div>
        <div class="mt-4">
            <label for="store_address" class="form-label">住所<span class="form-note">必須</span></label>
            <input type="text" name="store_address" class="form-control" value="{{old('store_address',$store->store_address)}}">
        </div>
        <div class="mt-4">
            <label for="business_hour" class="form-label">営業時間</label>
            <div class="d-flex align-items-center">
                <input type="time" name="start_time" class="form-control" value="{{old('start_time',$store->start_time)}}">
                <span> 〜 </span>
                <input type="time" name="end_time" class="form-control" value="{{old('end_time',$store->end_time)}}">
            </div>
        </div>
        <div class="mt-4">
            <label for="regular_holiday" class="form-label">定休日</label>
            <input type="text" name="regular_holiday" class="form-control" value="{{old('regular_holiday',$store->regular_holiday)}}">
        </div>
        <div class="mt-4">
            <label for="store_phone" class="form-label">電話番号</label>
            <input type="text" name="store_phone" class="form-control" value="{{old('store_phone',$store->store_phone)}}">
        </div>
        <div class="mt-4">
            <label for="genre_id" class="form-label">ジャンル<span class="form-note">必須</span></label>
            <select name="genre_id" class="form-control">
                @foreach($genres as $genre)
                    @if($genre->id == $store->genre_id)
                        <option value="{{$genre->id}}" selected>{{$genre->genre_name}}</option>
                    @else
                        <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <label for="lunch_budget" class="form-label">ランチ予算</label>
            <div class="d-flex align-items-center">
                <input type="number" name="lunchprice_min" class="form-control" value="{{old('lunchprice_min',$store->lunchprice_min)}}">
                <span> 〜 </span>
                <input type="number" name="lunchprice_max" class="form-control" value="{{old('lunchprice_max',$store->lunchprice_max)}}">
            </div>
        </div>
        <div class="mt-4">
            <label for="dinner_budget" class="form-label">ディナー予算</label>
            <div class="d-flex align-items-center">
                <input type="number" name="dinnerprice_min" class="form-control" value="{{old('dinnerprice_min',$store->dinnerprice_min)}}">
                <span> ~ </span>
                <input type="number" name="dinnerprice_max" class="form-control" value="{{old('dinnerprice_max',$store->dinnerprice_max)}}">
            </div>
        </div>
        <div class="mt-4">
            <label for="access" class="form-label">アクセス</label>
            <input type="text" name="access" class="form-control" value="{{old('access',$store->access)}}">
        </div>
        <div class="mt-4">
            <label for="description_about" class="form-label">店舗説明(概要)</label>
            <textarea name="description_about" class="form-control">{{old('description_about',$store->description_about)}}</textarea>
        </div>
        <div class="mt-4">
            <label for="description_detail" class="form-label">店舗説明(詳細)</label>
            <textarea name="description_detail" class="form-control">{{old('description_detail',$store->description_detail)}}</textarea>
        </div>
        <div class="mt-4">
            <label for="cash_way" class="form-label">お支払い方法</label>
            <input type="text" name="cash_way" class="form-control" value="{{old('cash_way',$store->cash_way)}}">
        </div>

        <div class="d-flex mt-4">
            <button type="submit" class="btn btn-outline-primary">編集</button>
        </div>
    </form>
    <form action="{{route('store.destroy', $store)}}" method="post">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-outline-danger mt-2">削除</button>
    </form>
@endsection