@extends('layouts.app')
<!-- ⬆️layouts.appをエクステンド（引き継ぎ）している。 -->

@section('content')

<body>
    <!-- START HERE -->
    <!-- -------------- header --------------- -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="index.html">Portfolio</a>
      <button
        type="button"
        class="navbar-toggler"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="ナビゲーションの切替"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item active">
            <a class="nav-link" href="#"
              >ホーム <span class="sr-only">(現位置)</span></a
            >
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">リンク1</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#">リンク2</a>
          </li>
        </ul>
      </div>
    </nav>
    <!-- -------------- header --------------- -->

    <div class="container my-3">
      <div class="border rounded my-3">
        <form class="p-3" action="/post/edited/{{$tmdb_id}}" method="POST">
          <div class="form-group">
            <label for="title">タイトル</label>
            <input type="text" class="form-control" id="title" name="title" value="{{$post->title}}"/>
          </div>
          <!-- <div class="row">
            <div class="form-group col-sm-6">
              <label for="begin_at">開始期間</label>
              <input
                type="date"
                class="form-control"
                name="begin_at"
                id="begin_at"
              />
            </div>
            <div class="form-group col-sm-6">
              <label for="end_at">終了期間 </label>
              <input
                type="date"
                class="form-control"
                name="end_at"
                id="end_at"
              />
            </div>
          </div> -->
          <div class="form-group">
            <label for="content">内容</label>
            <textarea
              class="form-control"
              name="content"
              id="content"
              cols="30"
              rows="10"
            >{{$post->content}}</textarea>
          </div>
          {{ csrf_field() }}
          <button type="submit" class="btn btn-primary d-block mx-auto">
            投稿する
          </button>
        </form>
      </div>
    </div>

    <script
      src="http://code.jquery.com/jquery-3.3.1.min.js"
      integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
      crossorigin="anonymous"
    ></script>
    <script
      src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
      integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
      crossorigin="anonymous"
    ></script>
    <script
      src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
      integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
      crossorigin="anonymous"
    ></script>

    <script>
      // Get the current year for the copyright
      $('#year').text(new Date().getFullYear());
    </script>
  </body>

@endsection