<?php

use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function() {
    Route::get('data', function(){
       return response()->json([
           'id' => 5443,
           'fgde'=>'df'
       ]);
    });
    Route::resource('comment','CommentController');
});


