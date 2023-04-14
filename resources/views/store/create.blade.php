@extends('layouts.app')

@section('content')
    <h2 class="section-ttl">店舗の投稿</h2>
    <div>
        <a href="{{route('store.userindex')}}">&lt; 戻る</a>
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
    <form action="{{route('store.store')}}" method="post" class="w-75">
        @csrf
        <div>
            <label for="store_name" class="form-label">店舗名<span class="form-note">必須</span></label>
            <input type="text" name="store_name" class="form-control" value="{{ old('store_name') }}">
        </div>
        <div class="mt-4">
            <label for="store_address" class="form-label">住所<span class="form-note">必須</span></label>
            <input type="text" name="store_address" class="form-control" value="{{old('store_address')}}">
        </div>
        <div class="mt-4">
            <label for="business_hour" class="form-label">営業時間</label>
            <div class="d-flex align-items-center">
                <input type="time" name="start_time" class="form-control" value="{{old('start_time')}}">
                <span class="mx-2"> 〜 </span>
                <input type="time" name="end_time" class="form-control" value="{{old('end_time')}}">
            </div>
        </div>
        <div class="mt-4">
            <label for="regular_holiday" class="form-label">定休日</label>
            <input type="text" name="regular_holiday" class="form-control" value="{{old('regular_holiday')}}">
        </div>
        <div class="mt-4">
            <label for="store_phone" class="form-label">電話番号</label>
            <input type="text" name="store_phone" class="form-control" value="{{old('store_phone')}}">
        </div>
        <div class="mt-4">
            <label for="genre_id" class="form-label">ジャンル<span class="form-note">必須</span></label>
            <select name="genre_id" class="form-control">
                @foreach($genres as $genre)
                    <option value="{{$genre->id}}">{{$genre->genre_name}}</option>
                @endforeach
            </select>
        </div>
        <div class="mt-4">
            <label for="lunch_budget" class="form-label">ランチ予算</label>
            <div class="d-flex align-items-center">
                <input type="number" name="lunchprice_min" class="form-control" value="{{old('lunchprice_min')}}">
                <span class="mx-2"> 〜 </span>
                <input type="number" name="lunchprice_max" class="form-control" value="{{old('lunchprice_max')}}">
            </div>
        </div>
        <div class="mt-4">
            <label for="dinner_budget" class="form-label">ディナー予算</label>
            <div class="d-flex align-items-center">
                <input type="number" name="dinnerprice_min" class="form-control" value="{{old('dinnerprice_min')}}">
                <span class="mx-2"> 〜 </span>
                <input type="number" name="dinnerprice_max" class="form-control" value="{{old('dinnerprice_max')}}">
            </div>
        </div>
        <div class="mt-4">
            <label for="access" class="form-label">アクセス</label>
            <input type="text" name="access" class="form-control" value="{{old('access')}}">
        </div>
        <div class="mt-4">
            <label for="description_about" class="form-label">店舗説明(概要)</label>
            <textarea name="description_about" class="form-control">{{old('description_about')}}</textarea>
        </div>
        <div class="mt-4">
            <label for="description_detail" class="form-label">店舗説明(詳細)</label>
            <textarea name="description_detail" class="form-control">{{old('description_detail')}}</textarea>
        </div>
        <div class="mt-4">
            <label for="cash_way" class="form-label">お支払い方法</label>
            <input type="text" name="cash_way" class="form-control" value="{{old('cash_way')}}">
        </div>


        <button type="submit" class="btn btn-outline-primary mt-4">投稿</button>
    </form>
@endsection