<?php

namespace App\Transformers;
use League\Fractal;
use \App\User;
/**
 * 
 */
class UsersTransformer extends Fractal\TransformerAbstract
{
	
	public function transform(User $user){
		return [
			'id' => (int) $user->id
		];	
	}
}