@extends('layouts.app')
<!-- ⬆️layouts.appをエクステンド（引き継ぎ）している。 -->

@section('content')
<div class="container">
      <!-- -------------- 検索フォーム --------------- -->
      <div class="border rounded my-3">
        <form class="p-3" action="/post/search" method="GET">
          <div class="form-group">
            <input
              type="text"
              class="form-control"
              id="keyword"
              placeholder="映画名で検索できます"
              name="keyword"
            />
          </div>
          <button type="submit" class="btn btn-primary d-block mx-auto">
            検索する
          </button>
        </form>
      </div>

      <!-- 画像一覧 -->
      
      <div class="row">
        @foreach($movieArray as $movie)
        <div class="col-sm-2 mb-2">
          <a href="/post/detail/{{$movie->id}}" class="card">
            <img class="card-img" src='https://image.tmdb.org/t/p/w600_and_h900_bestv2/{{$movie->poster_path}}'/>
          </a>
        </div>
        @endforeach
      </div>

      <!-- ページング -->
      <nav aria-label="ページャー">
        <ul class="pagination justify-content-center">
          <li>
            <a class="btn page-link rounded-pill" href="#">&larr; 前</a>
          </li>
          <li class="mx-2">
            <a class="btn page-link rounded-pill" href="#">1ページ</a>
          </li>
          <li>
            <a class="btn page-link rounded-pill" href="#">次 &rarr;</a>
          </li>
        </ul>
      </nav>
    </div>
@endsection