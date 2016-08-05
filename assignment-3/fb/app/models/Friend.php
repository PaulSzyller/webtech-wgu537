<?php

class Friend extends Eloquent {

    protected $table = 'friends';

    protected $fillable = ['user_id', 'friend_id', 'friend_email'];
}