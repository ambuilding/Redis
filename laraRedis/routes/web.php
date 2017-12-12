<?php

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
