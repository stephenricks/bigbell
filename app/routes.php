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

Route::get('/google', 'APIController@getHeaders');
Route::get('header-data/{num}', function($num){ $data = DB::table('headers')->where('id', $num)->first(); if($data){ return Response::json($data->data);} });

Route::get('/', function()
{

/*	$categories = 
	Category::with(['products' => function($q){
		return $q->whereHas('userliked', function($qq){
			return $qq->where('users.id', 1);
		})->limit(5);
	}])->whereHas('products.userliked', function($q){
		$q->where('users.id', 1);
	})->get();


	$categories = Category::whereHas('products.userliked', function($q){
		$q->where('users.id', 1);
	})->get();

	foreach($categories as $category) {
		$product = $category->load(['products' => function($q){
			return $q->whereHas('userliked', function($qq){
				return $qq->where('users.id', 1)->orderBy('swipe_action.created_at','DESC');
			})->limit(5);
		}]);

		$products[$category->id] = $product;
	}

	return Response::json($categories);

	exit;*/
	return Redirect::to('/select');
});


Route::get('select', function()
{
	return View::make('app.default.content.swipe');
});


Route::get('/category', function()
{
	return View::make('hello');
});

Route::get('/favorites', function()
{
	return View::make('app.default.content.favorites');
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

Route::group(['prefix' => 'api'], function(){

	Route::group(['prefix' => 'v1'], function(){

		//get product
		Route::get('/category/{categoryID}/product', 'APIController@products');
		Route::get('/category/favorite', 'APIController@productCategories');
		//Route::get('/user/category/{categoryID}/product', ['before' => 'auth', 'uses' => 'APIController@favoriteProducts']);


		//record swiping actions

		Route::post('/swipe-action', ['before' => 'auth', 'uses' => 'APIController@swipeAction']);

	});
});

Route::group(['prefix' => 'fb'], function(){

	Route::post('/login', 'APIController@login');
	Route::get('/login', function(){
		return Response::view('app.default.content.login-fb');
	});
});
