@extends('layouts.app')

@section('content')
    <h2 class="section-ttl">写真投稿</h2>
    
    <div>
        <a href="{{route('store.show', $store)}}">&lt; 戻る</a>
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

    <form action="{{route('photo.store', $store)}}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image[]" multiple>
        <input type="hidden" name="store_id" value="{{$store->id}}">
        <button type="submit">アップロード</button>
    </form>
@endsection