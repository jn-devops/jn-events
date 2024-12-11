<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});
Broadcast::channel('poll-updates', function ($user) {
    return true; // Add your logic here, e.g., check user permissions
});
