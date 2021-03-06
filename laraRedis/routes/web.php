<?php

use App\Article;
use App\Events\UserSignedUp;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;

Route::get('/', function () {
	$visits = Redis::incr('visits');
	Redis::set('name', 'Dniya');

	//return Redis::get('name');
    //return view('welcome');
    //return Redis::hget('preferences', 'length');
    return $visits;
});

Route::get('/cache', function () {
	Cache::put('foo', 'bar', 10);

	return Cache::get('foo');
});

Route::get('/event', function () {
	// $data = [
	// 	'event' => 'UserSignedUp',
	// 	'data' => [
	// 		'username' => 'Dniya'
	// 	]
	// ];

	//Redis::publish('test-channel', json_encode($data));
	//event(new UserSignedUp('Dniya'));
	event(new UserSignedUp(Request::query('name')));

	return view('event');
});

Route::get('videos/{id}/download', function ($id) {
	Redis::incr("videos.{$id}.downloads");
});
Route::get('videos/{id}', function ($id) {
	$downloads = Redis::get("videos.{id}.downloads");
});

class CacheableArticles {
	protected $articles;

	function __construct($articles)
	{
		$this->articles = $articles;
	}

	public function all()
	{
		return Cache::remember('articles.all', 60 * 60, function (){
			return $this->articles->all();
		});
	}
}

class Articles {
	public function all()
	{
		return Article::all();
	}
}

// App::bind('Articles', function () {
// 	return new CacheableArticles(new Articles);
// });

Route::get('articles', function () {
	//dd(App::make('Articles'));
	//dd(resolve('Articles'));
	$articles = new CacheableArticles(new Articles);
	return $articles->all();
});

Route::get('articles/trending', function () {
	$trending = Redis::zrevrange('trending_articles', 0, 2);

//App\Article::whereIn('id', $trending)
	$trending = App\Article::hydrate(array_map('json_decode', $trending));

	return $trending;
});

Route::get('articles/inProgress', 'ArticleController@index');
Route::get('articles/{article}', 'ArticleController@show');
// Route::get('articles/article', function (App\Article $article) {
// 	//Redis::zincreby('trending_articles', 1, $article->id);
// 	Redis::zincreby('trending_articles', 1, $article); // $article->toJson()

// 	Redis::zremrangebyrank('trending_articles', 0, -4); // remove except top 3

// 	return $article;
// });

Route::get('/hash', function () {
	// $user1Stats = [
	// 	'favorites' => $user->favorites()->count(),
	// 	'watchLaters' => $user->watchLaters()->count(),
	// 	'completions' => $user->completions()->count()
	// ];
	// Redis::hmset('user.1.stats', $user1Stats);

	return Redis::hgetall('user.1.stats');
});

Route::get('favorite-video', function () {
	// Auth::id();
	Redis::hincrby('user.1.stats', 'favorites', 1);

	return redirect('/hash');
});

Route::get('users/{id}/states', function ($id) {
	return Redis::hgetall("user.{$id}.stats");
});

