@extends('layouts.app')

@push('scripts')
    <script src="{{asset('/js/script.js')}}"></script>
@endpush

@section('content')
<main>
    <h2 class="section-ttl">投稿店舗の編集</h2>
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

    <div>
        <a href="{{route('keywords.create', $store)}}">新規キーワ-ドの追加</a>
    </div>

    @foreach($keywords as $keyword)
        <form action="{{route('store.keywordsupdate', $keyword)}}" method="post" class="w-75">
            @csrf
            @method('patch')
            <div class="mt-4">
                <div>
                    <label for="keyword" class="form-label">キーワード<span class="form-note">必須</span></label>
                </div>
                <textarea name="keyword" lass="form-control">{{$keyword->keyword}}</textarea>
            </div>
            
            <button type="submit" class="btn btn-outline-primary">編集</button>
        </form>
        <form action="{{route('store.keywordsdestroy',$keyword )}}" method="post">
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-outline-danger mt-2">削除</button>
        </form>
    @endforeach

    </main>
@endsection