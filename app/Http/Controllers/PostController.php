<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Favorite;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index()
    {
        $date = date("Y-m-d");//date("Y-m-d")により現在の年月日を取得しそれを$dateに代入
        $apikey = env('TMDB_API_KEY', null); //TMDbのAPIキー
        $url_Contents = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=$apikey&language=en-US&sort_by=release_date.desc&include_adult=false&include_video=false&page=1&release_date.lte=$date");
        // laravel(php)では''(シングルクォーテーション)で囲むと文字列、""(ダブルクォーテーション)で囲むと変数展開(文字列の中に変数の値を組み込むこと)ができる
        $movieArray = json_decode($url_Contents);
        $movieArray = $movieArray->results;

        return view('post.index', ['movieArray' => $movieArray,]);
    }


    public function search(Request $request)
    {
        $apikey = env('TMDB_API_KEY', null); //TMDbのAPIキー
        $date = date("Y-m-d");
        if(empty($request->keyword)){
            $url_Contents = file_get_contents("https://api.themoviedb.org/3/discover/movie?api_key=$apikey&language=en-US&sort_by=release_date.desc&include_adult=false&include_video=false&page=1&release_date.lte=$date");
        }else{
            $url_Contents = file_get_contents("https://api.themoviedb.org/3/search/movie?api_key=$apikey&language=ja-JA&query=$request->keyword&page=1&include_adult=false");
        }
        $movieArray = json_decode($url_Contents);
        $movieArray = $movieArray->results;

        return view('/post/index', ['movieArray' => $movieArray]);
    }


    public function detail($tmdb_id)
    {
        $apikey = env('TMDB_API_KEY', null); //TMDbのAPIキー
        $url_Contents = file_get_contents("https://api.themoviedb.org/3/movie/$tmdb_id?api_key=$apikey&language=ja-JP"); //ユーザーが選んだ映画のtmdb_idを組み込んだリクエストURL
        $movie = json_decode($url_Contents);
        
        // $posts = Post::table('posts')->paginate(1);

        $posts = Post::join('users', 'users.id', '=', 'posts.user_id')->where('tmdb_id', $tmdb_id)->get();
        $loginuser_id = Auth::id();//Auth::id()はuserテーブル（laravel承認機能のuserテーブル）のidカラムの中からログイン中のid番号（フィールドの中の数値）だけを取得する。
        foreach ($posts as $post) {
            // $post->idをもとに、お気に入りされている件数を取得して、$count変数にいれる
            $count = Favorite::where('post_id', $post->id)->count();
            // ↓postのオブジェクトにcountプロパティを追加。
            $post->count = $count;
            //↓is_favoriteプロパティ(お気に入りしていますか？の意味)にtrue（変数の型がBoolean型）が入っている。is_favoriteにtrueが入っているとこの投稿に対して「いいね」してる状態。
            // $post->is_favorite = true;
            $myfavorite = Favorite::where('post_id', $post->id)->where('user_id', $loginuser_id)->first();
            // ↑繰り返しの投稿に対して自分のidで絞り込んでいる。->first()は一件のオブジェクトだけ取得する。->getは全件のデータが配列で取得される。
            if ($myfavorite) {
            // php言語による仕様：if()の中に比較演算子やBoolean型を入れなくてもいい感じに判定してくれる。
                $post->is_favorite = true;
                // $postのis_favoriteプロパティーにtrue（Boolean型の値）を代入している。$post->is_favoriteで$post変数にis_favoriteプロパティーを追加している。
            } else {
                $post->is_favorite = false;
            }
            if ($loginuser_id == $post->id) {
                $post->loginuser_id = true;
            } else {
                $post->loginuser_id = false;
            }
        }
        return view('post.detail', ['movie' => $movie, 'tmdb_id' => $tmdb_id, 'post' => $post,'posts' => $posts,]);
    }


    //お気に入り解除
    public function release(Request $request, $tmdb_id){
        Favorite::where('post_id', $request->post_id)->where('user_id', Auth::id())->delete();
        return redirect("/post/detail/$tmdb_id");
    }


    //お気に入り登録
    public function like(Request $request, $tmdb_id)
    {
        // dd($request);
        Favorite::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id
        ]);
        return redirect("/post/detail/$tmdb_id");
    }


    // 投稿作成画面へ移動
    public function create($tmdb_id)
    {
        // $loginuser_id = Auth::id();
        // Favorite::create([
        //     'user_id' => Auth::id(),
        //     'post_id' => $request->post_id
        // ]);
        return view('post.create', ['tmdb_id' => $tmdb_id]);
    }


    // 投稿内容作成後
    public function register(Request $request, $tmdb_id)
    {
        $loginuser_id = Auth::id();
        Post::create([
            //⬆️Postモデルの中のcreateメソッド（クラスに属している関数：メソッド）
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'tmdb_id' => $tmdb_id,
            //⬆️$begin_atなどの変数に代入しないで$requestから直接DBに値を保存
        ]);
        return redirect("/post/detail/$tmdb_id");
    }


    // 投稿編集画面へ移動
    public function edit($tmdb_id)
    {
        $post = Post::find($id);
        return view('post.edit', ['tmdb_id' => $tmdb_id]);
    }


    //投稿内容編集後
    public function update(Request $request, $tmdb_id)
    {
        // dd($request);
        Favorite::create([
            'user_id' => Auth::id(),
            'post_id' => $request->post_id
        ]);
        return redirect("/post/detail/$tmdb_id");
    }


    //投稿削除
    public function delete(Request $request, $tmdb_id){
        Favorite::where('post_id', $request->post_id)->where('user_id', Auth::id())->delete();
        return redirect("/post/detail/$tmdb_id");
    }
}
