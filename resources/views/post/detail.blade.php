@extends('layouts.app')
<!-- ⬆️layouts.appをエクステンド（引き継ぎ）している。 -->

@section('content')
    <div class="py-3">
      <div class="container my-3">
        <div class="row">
          <div class="col-sm-3">
            <div class="card">
              <img
                class="card-img"
                src="https://image.tmdb.org/t/p/w600_and_h900_bestv2/{{$movie->poster_path}}"
              />
            </div>
          </div>
          <div class="col-sm-9">
            <h2 class="my-3">{{$movie->title}}</h2>
            <h3>概要</h3>
            <p>
              {{$movie->overview}}
            </p>
            <a class="navbar-brand">

            </a>
            <!-- <a href="register.html"> -->
            <a href="/post/create/{{$movie->id}}">
              <button class="btn btn-primary">
                裏話を投稿する
              </button>
            </a>
          </div>
        </div>
      </div>
    </div>
    <ul class="nav nav-pills nav-justified border-top border-bottom">
      <li class="nav-item"><a href="#" class="nav-link active">新着</a></li>
      <li class="nav-item"><a href="#" class="nav-link">人気</a></li>
    </ul>

  <div class="container py-3">
    <div class="row">
      @foreach($posts as $post)
        <div class="col-sm-4 mb-3">
          <div class="card">
            <h6 class="card-header">
              {{$post->name}}さんの投稿<br>
              {{$post->title}}
            </h6>
            <div class="card-body">{{$post->content}}</div>
            <div class="card-footer">

                @if ($post->is_favorite == true)
                  <!-- いいね取り消しフォーム -->
                  <form type="hidden" name="post_id" value="{{$post->id}}" action="/post/release/{{$movie->id}}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-outline-success" type="submit">
                    <i class="fas fa-check"></i> いいね済 {{$post->count}}
                    </button>
                  </form>
                @else
                  <!-- いいねフォーム -->
                  <form type="hidden" name="post_id" value="{{$post->id}}" action="/post/like/{{$movie->id}}" method="POST">
                    {{ csrf_field() }}
                    <button class="btn btn-outline-success" type="submit">
                      <i class="fas fa-thumbs-up"></i> いいね {{$post->count}}
                    </button>
                  </form>
                @endif
                @if($post->loginuser_id == true)
                  <div class="float-right">
                    <a href="/post/edit/{{$tmdb_id}}/{{$post->id}}">
                      <button class="btn btn-outline-primary">
                        <i class="fas fa-edit"></i>
                      </button>
                    </a>
                    <a href="/post/delete/{{$tmdb_id}}/{{$post->id}}">
                      <button class="btn btn-outline-danger">
                        <i class="fas fa-trash-alt"></i>
                      </button>
                    </a>
                  </div>
                @endif

            </div>
          </div>
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