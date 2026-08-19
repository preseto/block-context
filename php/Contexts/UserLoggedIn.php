<?php

namespace Preseto\BlockContext\Contexts;

/**
 * Uset login state context.
 */
class UserLoggedIn extends Context {

	/**
	 * Block ID.
	 *
	 * @return string
	 */
	public function id(): string {
		return 'UserLoginState';
	}

	/**
	 * If the current request matches the rule.
	 *
	 * @param  string $state Selected rule state.
	 *
	 * @return boolean
	 */
	public function match( string $state ): bool {
		$is_logged_in = (bool) is_user_logged_in();

		$rules = [
			'logged-in' => $is_logged_in,
			'logged-out' => ! $is_logged_in,
		];

		return ( isset( $rules[ $state ] ) && true === $rules[ $state ] );
	}
}
