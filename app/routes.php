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

	return Response::json(Product::with(['supplier','category'])->get());

	return Redirect::to('/select');
});

Route::get('/login/fb-auth', function()
{
	dd($_POST);
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

Route::get('/items/{page}', function($id)
{

	if($id < 1) {
		return [];
	}

	$index = $id - 1;

	$products = json_decode(file_get_contents(public_path().'/sample-data.json'), true);

	$product_chunks = array_chunk($products, 5);

	if(count($product_chunks) >= $id) {
		return Response::json($product_chunks[$index]);
	}

});
