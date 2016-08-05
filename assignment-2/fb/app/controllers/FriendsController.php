<?php

class FriendsController extends \BaseController {

	public function showFriendsView()
	{
		if(!Auth::check()){
			return Redirect::to('/login');
		}

		$user = Auth::user();
		$friends = Friend::where('user_id', '=', $user->id)->get();

		return View::make('friends', [
			'user'	=> $user,
			'friends'	=> $friends
		]);
	}

	public function addFriend()
	{
		$validation = Validator::make(Input::all(),[
			'friend_email' =>'required|unique:friends',
		]);

		if($validation->fails()){
			$messages = $validation->messages();
			Session::flash('validation_messages', $messages);
			return Redirect::back()->withInput();
		}

		$user = Auth::user();
        $friend_email = Input::get('friend_email');
        $friend = User::where('email', '=', $friend_email)->get()->first();

		try {

            //verify that friend exist
            //verify that friend isn't self
            //verify that not already friend

			$input = Friend::create([
				'user_id' => $user->id,
                'friend_id' => $friend->id,
				'friend_email' => $friend_email
			]);

		}catch(Exception $e){
			Session::flash('error_message',
				'Oops! Something is wrong');
			return Redirect::back()->withInput();
		}

		return Redirect::to('/friends');
	}

}
