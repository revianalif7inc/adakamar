<?php

use Illuminate\Support\Facades\Route;

// API murni JSON — tidak boleh pakai session
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
