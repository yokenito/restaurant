@extends('layouts.app')

@section('content')
    <h2 class="section-ttl">キーワードの追加</h2>
    <div>
        <a href="{{route('store.edit',$store)}}">&lt; 戻る</a>
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

    <form action="{{route('keywords.store')}}" method="post" class="w-75">
        @csrf
        <div class="mt-4">
            <div>
                <label for="keyword" class="form-label">キーワード<span class="form-note">必須</span></label>
            </div>
            <textarea name="keyword" lass="form-control"></textarea>
        </div>
        
        <input type="hidden" name="store_id" value="{{$store->id}}">
        <button type="submit" class="btn btn-outline-primary">キーワード追加</button>
    </form>
@endsection