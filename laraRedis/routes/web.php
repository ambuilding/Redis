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
