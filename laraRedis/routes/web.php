<?php

use App\Article;
use App\Events\UserSignedUp;
use Illuminate\Support\Facades\Redis;

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

function remember($key, $minutes, $callback)
{
	if ($value = Redis::get($key)) {
		return json_decode($value);
	}

	Redis::setex($key, $minutes, $value = $callback());

	return $value;
}

Route::get('articles', function () {
	return remember('articles.all', 60 * 60, function () {
		return Article::all();
	});
});

Route::get('articles/trending', function () {
	$trending = Redis::zrevrange('trending_articles', 0, 2);

//App\Article::whereIn('id', $trending)
	$trending = App\Article::hydrate(array_map('json_decode', $trending));

	return $trending;
});
Route::get('articles/article', function (App\Article $article) {
	//Redis::zincreby('trending_articles', 1, $article->id);
	Redis::zincreby('trending_articles', 1, $article); // $article->toJson()

	Redis::zremrangebyrank('trending_articles', 0, -4); // except top 3

	return $article;
});

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

