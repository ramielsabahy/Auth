<?php

namespace App\Transformers;
use League\Fractal;
use \App\User;
use Themsaid\Transformers\AbstractTransformer;
use Illuminate\Database\Eloquent\Model;
/**
 * 
 */
class UsersTransformer extends AbstractTransformer
{
	
	public function transformModel(Model $user){
		return [
			'id' => (int) $user->id
		];	
	}
}