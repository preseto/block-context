<?php

namespace Preseto\BlockContext\Contexts;

class UserLoggedIn extends Context {

	public function id() {
		return 'UserLoginState';
	}

	public function match( $state ) {
		$is_logged_in = is_user_logged_in();

		$rules = [
			'logged-in' => $is_logged_in,
			'logged-out' => ! $is_logged_in,
		];

		return ( isset( $rules[ $state ] ) && ! empty( $rules[ $state ] ) );
	}

}
