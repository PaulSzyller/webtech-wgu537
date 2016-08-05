<?php

class FeedController extends \BaseController {

	public function showFeed(){

		if(!Auth::check()){
			return Redirect::to('/login');
		}

		$user = Auth::user();

		$posts = Post::where('UID', '=', $user->id)->get();

		$comments = [];

		foreach($posts as $post){
			$comments[$post->id] = Comment::where('PID', '=', $post->id)->get();
		}

		return View::make('feed', [
			'user'	=> $user,
			'posts'	=> $posts,
			'comments' => $comments
		]);

	}

}
