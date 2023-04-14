@extends('layouts.app')
 
@section('content')
<div class="container mt-3">
    <div class="mypage-card">
        <h2>マイページ</h2>
        <ul class="mypage-list">
            <li class="mypage-list"><a href="{{route('store.niceindex')}}" class="mypage-list-item">お気に入り店舗一覧</a></li>
            <li class="mypage-list"><a href="{{route('store.userindex')}}" class="mypage-list-item">投稿店舗一覧</a></li>
            <li class="mypage-list"><a href="{{route('comments.index')}}" class="mypage-list-item">コメント店舗一覧</a></li>
            <li class="mypage-list"><a href="{{route('photo.index')}}" class="mypage-list-item">写真投稿店舗一覧</a></li>
            <li class="mypage-list">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="mypage-list-item logoutbtn">ログアウト</button>
            </form>
            </li>
        </ul>
    </div>
</div>
@endsection