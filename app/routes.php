<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});

Route::get('select', function()
{
	return View::make('app.default.content.swipe');
});


Route::get('/category', function()
{
	return View::make('hello');
});

Route::get('/favorite', function()
{
	return View::make('hello');
});

Route::get('/product/{id}', function($id)
{

	dd($id);

	return View::make('hello');
});
