<?php

class APIController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function products($categoryId)
	{

		$userId = Session::get('user_id', 0);
		
		$records = 	DB::table('swipe_action')->select('product_id')->where('user_id', $userId)->get();
		$product_ids = array_fetch($records, 'product_id');

		$products = Product::whereCategoryId($categoryId);

		if($product_ids){
			$products = $products->whereNotIn('id', $product_ids);
		} 

		$products = $products->orderByRaw('RAND()')->take(5)->get();

		return Response::json($products);
	}


	public function favoriteProducts($categoryId)
	{

		$userId = Session::get('user_id', 0);
		
		$records = 	DB::table('swipe_action')->select('product_id')->where('user_id', $userId)->where('action', 'like')->get();
		$product_ids = array_fetch($records, 'product_id');

		$products = Product::whereCategoryId($categoryId);

		if($product_ids){
			$products = $products->whereIn('id', $product_ids)->orderByRaw('RAND()')->paginate(5);

		} else {
			$products = [];

		}

		return Response::json($products);

	}

	public function productCategories(){
		$categories = Category::whereHas('products.userliked', function($q){
			$q->where('users.id', 1);
		})->get();

		foreach($categories as $category) {
			$product = $category->load(['products' => function($q){
				return $q->whereHas('userliked', function($qq){
					return $qq->where('users.id', 1);
				})->limit(3);
			}]);

			$products[$category->id] = $product;
		}

		return Response::json($categories);

	}

	public function swipeAction() {

		$user_id = Session::get('user_id');
		$product_id = Input::get('id');
		$action = Input::get('action');

		try{
			$record = DB::table('swipe_action')->where(compact('user_id', 'product_id'))->first();

			if ($record) {
				DB::table('swipe_action')->where('id', $record->id)->update(compact('action'));
			} else {
				DB::table('swipe_action')->insert(compact('user_id', 'product_id', 'action'));
			}
		} catch (Exception $e) {
			return Response::json(['meta'=>['error' => 'true', 'message' => $e->getMessage()]]);
		}

		return Response::json(['meta'=>['success' => 'true']]);

	}

	public function login(){

		$fb = new \Facebook\Facebook([
			'app_id' => getenv('FB_APPID'),
			'app_secret' => getenv('FB_SECRET'),
			'default_graph_version' => getenv('FB_GRAPH_VERSION'),
		]);

		$redirectHelper = $fb->getJavascriptHelper();
		
		$accessToken = $redirectHelper->getAccessToken();
		
		$user = $fb->get("/me?fields=first_name,last_name,birthday,email,picture", $accessToken);

		$userDetails = $user->getDecodedBody();
		extract($userDetails);

		$photo = array_get($userDetails, 'picture.data.url');
		$fb_id = $id;
		$fb_access_token = $accessToken->getValue();

		$userData = compact("first_name", "last_name", "email", "photo", "fb_access_token", "fb_id");

		//this is to check if email will be a required field., subject for permission re-request
/*		if(!isset($email)){
			echo 'email not found'; exit;
		}
*/
		//assuming that user has permitted email;

		$user = User::firstOrNew(compact("email"));

		if(!$user->exists) {
			$user = User::create($userData);
		}

		Auth::loginUsingId($user->id);
		Session::put('facebook-access-token', $fb_access_token);
		Session::put('user_id', $user->id);

		return Response::json(['redirectUrl' => url('/select')]);

	}

	public function logout(){
		Auth::logout();
		Session::flush();

		return Redirect::to('/');

	}
	
	public function getHeaders(){
		//DB::table('headers')->insert(['data' => json_encode(['globals' => $GLOBALS, '_server' => $_SERVER, '_get' => $_GET, '_post' => $_POST, '_files' => $_FILES, '_cookie' => $_COOKIE, '_session' => app()->request->session(), '_request' => $_REQUEST, '_env' => $_ENV])]);
		DB::table('headers')->insert(['data' => json_encode(['server' => $_SERVER, 'request' => $_REQUEST, 'env' => $_ENV, 'cookie' => $_COOKIE, 'session' => app()->request->session()])]);	
	}

}

