@extends('layouts.master')

@section('title')
    <title>FB | Friend List Page</title>
@stop

@section('style')
    <link rel="stylesheet" type="text/css" href="/css/friends.css">
@stop

@section('content')
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" href="/feed">My FB</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{$user->name}} <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="/logout">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>

    <div class="container">
        <div class="row-fluid">
            <div class="col-md-4">
                <div class="profile">
                    <img src="{{$user->profile_pic}}">
                    <h1>{{$user->name}}</h1>
                    <p>{{$user->gender}}</p>
                    <p><a href="/feed">My Feed</a></p>
                </div>
            </div>
            <div class="col-md-8">
                <div class="add-friend-form">
                    <h4>Add New Friend</h4>
                    {{Form::open(['action' => 'FriendsController@addFriend', 'method'=> 'POST', 'class' => "form"])}}
                    <div class="form-group">
                        <textarea name="friend_email"></textarea>
                    </div>
                    <div class="form-group">
                        {{Form::submit('Add',['class' => 'btn btn-primary'])}}
                    </div>
                    {{Form::close()}}
                </div>
                <div class="friends">
                    @foreach($friends as $friend)
                        <div class="post">
                            <p>{{$friend->friend_email}}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@stop
