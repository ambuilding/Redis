<?php

use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
	Redis::set('name', 'Dniya');

	//return Redis::get('name');
    //return view('welcome');
    return Redis::hget('preferences', 'length');
});

Route::get('/cache', function () {
	Cache::put('foo', 'bar', 10);

	return Cache::get('foo');
});

Route::get('/event', function () {
	$data = [
		'event' => 'UserSignedUp',
		'data' => [
			'username' => 'Dniya'
		]
	];

	Redis::publish('test-channel', json_encode($data));

	return view('event');
});
