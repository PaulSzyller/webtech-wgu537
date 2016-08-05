<?php

class FriendsController extends \BaseController {

	public function showFriendsView()
	{
        //If not logged in, redirect to login
		if(!Auth::check()){
			return Redirect::to('/login');
		}

        //Get current user and list of the user's friends
		$user = Auth::user();
		$friends = [];
        foreach (Friend::where('user_id', '=', $user->id)->get() as $friend) {
            array_push($friends, User::where('id', '=', $friend->friend_id)->get()->first());
        }

        //Create friend list view for current user
		return View::make('friends', [
			'user'	=> $user,
			'friends'	=> $friends
		]);
	}

	public function addFriend()
    {
        //Validate input with custom error messages
        $validation = Validator::make(Input::all(), [
            'friend_email' => 'required|unique:friends',
        ], [
            'required' => 'Please enter your friend\'s email address.',
            'unique' => 'This user is already in your friend list.'
        ]);

        //If validation fails, store error messages in session and refresh page
		if($validation->fails()){
			$messages = $validation->messages();
			Session::flash('validation_messages', $messages);
			return Redirect::back()->withInput();
		}

        //Get infos required for a entry in friends database
        $user = Auth::user();
        $friend_email = Input::get('friend_email');
        //If entered friend is not in database, send error and refresh
        if (!($friend = User::where('email', '=', $friend_email)->get()->first())) {
            Session::flash('error_message', 'This user does not exist.');
            return Redirect::back()->withInput();
        }
        //If entered friend is current user him/herself, send error and refresh
        if ($user->id == $friend->id) {
            Session::flash('error_message', 'You cannot add yourself as a friend.');
            return Redirect::back()->withInput();
        }

		try {
            //create friend entry
			$input = Friend::create([
				'user_id' => $user->id,
                'friend_id' => $friend->id,
				'friend_email' => $friend_email
			]);
            //increment # of friends for user
            $user->increment('num_of_friends');

            //send email notification
            //NOT CURRENTLY WORKING
            /*$data = ['user' => $user,
                'friend' => User::where('id', '=', $friend->friend_id)->get()->first()];
            Mail::send('emails.newfriend', $data
                , function ($message) use ($friend_email) {
                $message->to($friend_email)
                    ->subject("Someone Added you as a friend.");
            });*/
		}
        catch(Exception $e){
			Session::flash('error_message',
				'Oops! Something is wrong');
			return Redirect::back()->withInput();
		}

		return Redirect::to('/friends');
	}

}
