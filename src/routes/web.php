<?php

use Illuminate\Support\Facades\Route;
//use Illuminate\Support\Facades\Redis;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test-redis', function () {
//     Redis::set('name', 'Laravel Redis OK');
//     return Redis::get('name');
// });