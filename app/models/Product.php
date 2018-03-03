<?php

class Product extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table      = 'product';
	protected $primaryKey = 'id';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	//protected $hidden = array('password', 'remember_token');


	public function category() {
		return $this->belongsTo('Category', 'category_id');
	}

	public function supplier() {
		return $this->belongsTo('Supplier', 'supplier_id');
	}

	public function userliked() {
		return $this->belongsToMany('User', 'swipe_action', 'product_id', 'user_id')->withPivot('action')->where('action', '=', 'like')->orderBy('created_at', 'desc')->take(5);
	}
}
