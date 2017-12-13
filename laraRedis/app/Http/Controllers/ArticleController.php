<?php

namespace App\Http\Controllers;

use App\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
	public function index()
	{
		$inProgressIds = Redis::zrevrange('user.1.inProgress', 0, 2);

		$inProgress = collect($inProgressIds)->map(function ($id) {
			return Article::find($id);
		});

		return $inProgress;
	}
    public function show(Article $article)
    {
    	Redis::zadd('user.1.inProgress', time(), $article->id);

    	return $article;
    }
}
