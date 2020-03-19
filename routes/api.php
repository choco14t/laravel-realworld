<?php

Route::post('/users/login', 'Controllers\Api\AuthController@login');
Route::post('/users', 'Controllers\Api\AuthController@register');

Route::get('/user', 'Controllers\Api\UserController@currentUser');
Route::put('/user', 'Controllers\Api\UserController@update');

Route::get('/profiles/{username}', 'Controllers\Api\ProfileController@show');
Route::post('/profiles/{username}/follow', 'Controllers\Api\ProfileController@follow');
Route::delete('/profiles/{username}/follow', 'Controllers\Api\ProfileController@unfollow');

Route::get('/articles/feed', 'Controllers\Api\FeedController@fetch');

Route::get('/articles', 'Controllers\Api\ArticleController@fetchList');
Route::get('/articles/{slug}', 'Controllers\Api\ArticleController@fetch');
Route::post('/articles', 'Controllers\Api\ArticleController@create');
Route::put('/articles/{slug}', 'Controllers\Api\ArticleController@update');
Route::delete('/articles/{slug}', 'Controllers\Api\ArticleController@delete');

Route::get('/articles/{slug}/comments', 'Controllers\Api\CommentController@fetch');
Route::post('/articles/{slug}/comments', 'Controllers\Api\CommentController@create');
Route::delete('/articles/{slug}/comments/{id}', 'Controllers\Api\CommentController@delete');

Route::post('/articles/{slug}/favorite', 'Controllers\Api\FavoriteController@favorite');
Route::delete('/articles/{slug}/favorite', 'Controllers\Api\FavoriteController@unfavorite');

Route::get('/tags', 'Controllers\Api\TagController@fetch');
