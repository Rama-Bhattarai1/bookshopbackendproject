<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('contact.{user_id}', function ($user, $id) {
    // Adjust this logic to match your security or access control requirements
    return true; 
});